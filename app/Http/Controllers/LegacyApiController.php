<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Booking;
use App\Models\TeacherSetting;
use App\Models\Grade;
use App\Models\Announcement;
use App\Models\SafeguardingReport;
use App\Models\PasswordReset;
use App\Models\AuditLog;
use App\Models\ScheduledPost;
use App\Models\Resource;
use App\Models\Event;

class LegacyApiController extends Controller
{
    /**
     * Handle incoming AJAX requests from the legacy frontend
     */
    public function handle(Request $request)
    {
        $action = $request->query('action', '');
        $method = $request->method();

        // 1. Manual CSRF Verification to match the exact legacy logic
        if ($method === 'POST' && !in_array($action, ['login', 'signup', 'google_callback', 'private_login', 'submit_safeguarding_report'])) {
            $token = $request->header('X-CSRF-Token');
            if (!$token || $token !== csrf_token()) {
                return response()->json(['ok' => false, 'message' => 'CSRF token i pavlefshëm'], 419);
            }
        }

        try {
            switch ($action) {
                // --- AUTHENTICATION ---
                case 'whoami':
                    return response()->json([
                        'ok' => true,
                        'user' => session('user'),
                        'csrfToken' => csrf_token()
                    ]);

                case 'csrf':
                    return response()->json([
                        'ok' => true,
                        'csrfToken' => csrf_token()
                    ]);

                case 'login':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $email = strtolower(trim($in['email'] ?? ''));
                    $password = $in['password'] ?? '';

                    $user = User::where('email', $email)->first();
                    if (!$user || !Hash::check($password, $user->password_hash)) {
                        return response()->json(['ok' => false, 'message' => 'Email ose fjalëkalim i gabuar'], 401);
                    }

                    $userData = $user->toArray();
                    unset($userData['password_hash']);
                    
                    $request->session()->regenerate();
                    session(['user' => $userData]);

                    return response()->json(['ok' => true, 'user' => $userData]);

                case 'signup':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $name = preg_replace('/\s+/', ' ', trim($in['fullName'] ?? ''));
                    $email = strtolower(trim($in['email'] ?? ''));
                    $password = $in['password'] ?? '';
                    $role = $in['role'] ?? 'parent';

                    if (!in_array($role, ['parent', 'student'])) {
                        $role = 'parent';
                    }

                    if (!$name || !$email || strlen($password) < 6) {
                        return response()->json(['ok' => false, 'message' => 'Të dhëna të paplota'], 422);
                    }

                    $exists = User::where('email', $email)->exists();
                    if ($exists) {
                        return response()->json(['ok' => false, 'message' => 'Ky email ekziston në sistem'], 400);
                    }

                    $user = User::create([
                        'full_name' => $name,
                        'email' => $email,
                        'password_hash' => Hash::make($password),
                        'role' => $role,
                    ]);

                    $userData = $user->toArray();
                    unset($userData['password_hash']);

                    $request->session()->regenerate();
                    session(['user' => $userData]);

                    return response()->json(['ok' => true, 'user' => $userData]);

                case 'request_password_reset':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $email = strtolower(trim($in['email'] ?? ''));

                    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return response()->json(['ok' => true, 'message' => 'Nëse email-i ekziston, kodi u dërgua.']);
                    }

                    $user = User::where('email', $email)->first();
                    if (!$user) {
                        return response()->json(['ok' => true, 'message' => 'Nëse email-i ekziston, kodi u dërgua.']);
                    }

                    $code = (string)random_int(100000, 999999);
                    $hash = Hash::make($code);
                    $expiresAt = now()->addMinutes(15);

                    PasswordReset::create([
                        'user_id' => $user->id,
                        'email' => $email,
                        'token_hash' => $hash,
                        'expires_at' => $expiresAt,
                    ]);

                    $body = "Përshëndetje {$user->full_name},<br><br>Kodi për rivendosjen e fjalëkalimit është: <strong>{$code}</strong><br>Ky kod vlen 15 minuta.";
                    $this->sendHtmlEmail($email, 'Kodi për rivendosjen e fjalëkalimit', $body);

                    return response()->json(['ok' => true, 'message' => 'Kodi u dërgua në email.']);

                case 'reset_password':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $email = strtolower(trim($in['email'] ?? ''));
                    $token = trim($in['token'] ?? '');
                    $newPassword = $in['newPassword'] ?? '';

                    if (!$email || !$token || strlen($newPassword) < 6) {
                        return response()->json(['ok' => false, 'message' => 'Të dhëna të pavlefshme.'], 422);
                    }

                    $resets = PasswordReset::where('email', $email)
                        ->whereNull('used_at')
                        ->where('expires_at', '>=', now())
                        ->orderBy('id', 'desc')
                        ->take(5)
                        ->get();

                    $match = null;
                    foreach ($resets as $r) {
                        if (Hash::check($token, $r->token_hash)) {
                            $match = $r;
                            break;
                        }
                    }

                    if (!$match) {
                        return response()->json(['ok' => false, 'message' => 'Kodi është i gabuar ose i skaduar.'], 400);
                    }

                    $user = User::find($match->user_id);
                    if ($user) {
                        $user->update(['password_hash' => Hash::make($newPassword)]);
                    }

                    $match->update(['used_at' => now()]);

                    return response()->json(['ok' => true, 'message' => 'Fjalëkalimi u përditësua me sukses.']);

                case 'google_auth':
                    $googleClientId = config('services.google.client_id', env('GOOGLE_CLIENT_ID'));
                    $redirectUri = url('/api.php?action=google_callback');
                    $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
                        'client_id' => $googleClientId,
                        'redirect_uri' => $redirectUri,
                        'response_type' => 'code',
                        'scope' => 'email profile',
                        'access_type' => 'offline',
                        'prompt' => 'select_account'
                    ]);
                    return redirect($url);

                case 'google_callback':
                    $code = $request->query('code', '');
                    if (!$code) {
                        return response()->json(['ok' => false, 'message' => 'Code mungon.'], 400);
                    }

                    $googleClientId = config('services.google.client_id', env('GOOGLE_CLIENT_ID'));
                    $googleClientSecret = config('services.google.client_secret', env('GOOGLE_CLIENT_SECRET'));
                    $redirectUri = url('/api.php?action=google_callback');

                    // Exchange code for token
                    $client = new \GuzzleHttp\Client();
                    $response = $client->post('https://oauth2.googleapis.com/token', [
                        'form_params' => [
                            'code' => $code,
                            'client_id' => $googleClientId,
                            'client_secret' => $googleClientSecret,
                            'redirect_uri' => $redirectUri,
                            'grant_type' => 'authorization_code'
                        ]
                    ]);
                    $res = json_decode($response->getBody()->getContents(), true);

                    if (empty($res['access_token'])) {
                        return response()->json(['ok' => false, 'message' => 'Token dështoi.'], 500);
                    }

                    // Get User Info
                    $userInfoResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $res['access_token']
                        ]
                    ]);
                    $userInfo = json_decode($userInfoResponse->getBody()->getContents(), true);

                    $email = strtolower($userInfo['email']);
                    $name = $userInfo['name'];

                    $user = User::where('email', $email)->first();
                    if (!$user) {
                        $user = User::create([
                            'full_name' => $name,
                            'email' => $email,
                            'password_hash' => 'google_auth_no_pass',
                            'role' => 'parent',
                        ]);
                    }

                    $userData = $user->toArray();
                    unset($userData['password_hash']);

                    $request->session()->regenerate();
                    session(['user' => $userData]);

                    return redirect('/index.html?auth=success');

                case 'logout':
                    if ($method !== 'POST') break;
                    Session::flush();
                    return response()->json(['ok' => true]);

                // --- TEACHERS & BOOKINGS ---
                case 'list_teachers':
                    $teachers = User::where('role', 'teacher')->orderBy('full_name', 'asc')->get();
                    $formatted = [];
                    foreach ($teachers as $t) {
                        $parts = preg_split('/\s+/', trim($t->full_name)) ?: [];
                        $initials = '';
                        foreach ($parts as $p) {
                            $initials .= mb_substr($p, 0, 1);
                        }
                        $formatted[] = [
                            'id' => 'db_' . $t->id,
                            'name' => $t->full_name,
                            'subject' => $t->teacher_subject ?: 'Lëndë e papërcaktuar',
                            'email' => $t->email,
                            'initials' => strtoupper($initials ?: 'T')
                        ];
                    }
                    return response()->json(['ok' => true, 'teachers' => $formatted]);

                case 'get_teacher_booked_slots':
                    $tid = $request->query('teacherId', '');
                    $slots = Booking::where('teacher_id', $tid)
                        ->whereDate('created_at', now()->toDateString())
                        ->pluck('slot_time')
                        ->toArray();
                    return response()->json(['ok' => true, 'slots' => $slots]);

                case 'book_slot':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    $in = $request->json()->all();
                    
                    // Double check double booking
                    $exists = Booking::where('teacher_id', $in['teacherId'])
                        ->where('slot_time', $in['time'])
                        ->whereDate('created_at', now()->toDateString())
                        ->exists();
                    if ($exists) {
                        return response()->json(['ok' => false, 'message' => 'Ky slot është i rezervuar tashmë.'], 400);
                    }

                    $booking = Booking::create([
                        'teacher_id' => $in['teacherId'],
                        'teacher_name' => $in['teacherName'],
                        'teacher_subject' => $in['teacherSubject'],
                        'teacher_email' => $in['teacherEmail'],
                        'slot_time' => $in['time'],
                        'parent_name' => $in['parentName'],
                        'student_name' => $in['studentName'],
                        'parent_email' => $in['parentEmail'],
                        'topic' => $in['topic'] ?? null,
                        'created_by_user_id' => $user['id'],
                    ]);

                    $this->auditLog($user['id'], 'slot_booked', 'bookings', $booking->id, [
                        'teacher' => $in['teacherName'],
                        'time' => $in['time']
                    ]);

                    // Send email to teacher
                    $teacherBody = "Prindi {$in['parentName']} rezervoi terminin në orën {$in['time']} për nxënësin {$in['studentName']}. Tema: {$in['topic']}";
                    $this->sendHtmlEmail($in['teacherEmail'], "Rezervim i ri: {$in['parentName']}", $teacherBody);

                    // Send email to admin
                    $adminEmail = config('mail.from.address', env('MAIL_USER'));
                    $adminBody = "Ka një rezervim të ri në platformë:<br><br>Profesori: {$in['teacherName']}<br>Lënda: {$in['teacherSubject']}<br>Prindi: {$in['parentName']}<br>Nxënësi: {$in['studentName']}<br>Ora: {$in['time']}";
                    $this->sendHtmlEmail($adminEmail, "Njoftim Rezervimi: {$in['teacherName']}", $adminBody);

                    return response()->json(['ok' => true]);

                case 'get_bookings':
                    $user = session('user');
                    if (!$user) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    if ($user['role'] === 'admin') {
                        $bookings = Booking::orderBy('id', 'desc')->get();
                    } else {
                        $bookings = Booking::where('teacher_email', $user['email'])->orderBy('id', 'desc')->get();
                    }
                    return response()->json(['ok' => true, 'bookings' => $bookings]);

                case 'update_booking_status':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $booking = Booking::find($in['id']);
                    if (!$booking) {
                        return response()->json(['ok' => false, 'message' => 'Takimi nuk u gjet'], 404);
                    }

                    $booking->update(['status' => $in['status']]);

                    if ($in['status'] === 'accepted' && $booking->parent_email) {
                        $parentBody = "I/e nderuar {$booking->parent_name},<br><br>Takimi juaj me profesorin {$booking->teacher_name} për nxënësin {$booking->student_name} është KONFIRMUAR për orën {$booking->slot_time}.<br><br>Ju faleminderit!";
                        $this->sendHtmlEmail($booking->parent_email, "Konfirmim i Takimit - Gjimnazi Ulpiana", $parentBody);
                    }

                    return response()->json(['ok' => true]);

                case 'dashboard_analytics':
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $total = Booking::count();
                    $accepted = Booking::where('status', 'accepted')->count();
                    $students = Booking::distinct('student_name')->count('student_name');

                    return response()->json([
                        'ok' => true,
                        'analytics' => [
                            'totalBookings' => $total,
                            'acceptedBookings' => $accepted,
                            'totalStudents' => $students
                        ]
                    ]);

                // --- SETTINGS ---
                case 'get_settings':
                    $user = session('user');
                    if (!$user) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }
                    return response()->json([
                        'ok' => true,
                        'settings' => [
                            'display_name' => $user['full_name'],
                            'email' => $user['email']
                        ]
                    ]);

                case 'save_settings':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    $in = $request->json()->all();
                    $displayName = preg_replace('/\s+/', ' ', trim($in['displayName'] ?? ''));

                    if (!$displayName) {
                        return response()->json(['ok' => false, 'message' => 'Të dhëna të pavlefshme'], 400);
                    }

                    $dbUser = User::find($user['id']);
                    if ($dbUser) {
                        $dbUser->update(['full_name' => $displayName]);
                    }

                    $user['full_name'] = $displayName;
                    session(['user' => $user]);

                    return response()->json(['ok' => true]);

                // --- ANNOUNCEMENTS ---
                case 'list_announcements':
                    $rows = Announcement::leftJoin('users', 'announcements.created_by_user_id', '=', 'users.id')
                        ->select('announcements.*', 'users.full_name as author_name')
                        ->orderBy('announcements.id', 'desc')
                        ->take(50)
                        ->get();
                    return response()->json(['ok' => true, 'announcements' => $rows]);

                case 'create_announcement':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    Announcement::create([
                        'title' => trim($in['title'] ?? ''),
                        'content' => trim($in['content'] ?? ''),
                        'created_by_user_id' => $user['id'],
                    ]);

                    return response()->json(['ok' => true]);

                // --- RESOURCES ---
                case 'list_resources':
                    $rows = Resource::leftJoin('users', 'resources.uploaded_by_user_id', '=', 'users.id')
                        ->select('resources.*', 'users.full_name as uploader_name')
                        ->orderBy('resources.id', 'desc')
                        ->get();
                    return response()->json(['ok' => true, 'resources' => $rows]);

                case 'upload_resource':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    if (!$request->hasFile('file')) {
                        return response()->json(['ok' => false, 'message' => 'Asnjë skedar nuk u dërgua.'], 400);
                    }

                    $file = $request->file('file');
                    $ext = strtolower($file->getClientOriginalExtension());
                    
                    $allowedExts = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'zip'];
                    if (!in_array($ext, $allowedExts, true)) {
                        return response()->json(['ok' => false, 'message' => 'Prapashtesa e skedarit nuk lejohet për arsye sigurie.'], 403);
                    }

                    $newName = uniqid('res_') . '.' . $ext;
                    $uploadPath = public_path('uploads');

                    if (!File::isDirectory($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    $file->move($uploadPath, $newName);
                    $filePath = 'uploads/' . $newName;

                    Resource::create([
                        'title' => trim($request->input('title', '')),
                        'category' => trim($request->input('category', 'general')),
                        'file_path' => $filePath,
                        'uploaded_by_user_id' => $user['id'],
                    ]);

                    return response()->json(['ok' => true]);

                case 'delete_resource':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $res = Resource::find($in['id']);
                    if ($res) {
                        $fullPath = public_path($res->file_path);
                        if (File::exists($fullPath)) {
                            File::delete($fullPath);
                        }
                        $res->delete();
                    }

                    return response()->json(['ok' => true]);

                // --- GRADES ---
                case 'list_grades':
                    $user = session('user');
                    if (!$user) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    if ($user['role'] === 'student') {
                        $grades = Grade::whereRaw('LOWER(TRIM(student_name)) = ?', [strtolower(trim($user['full_name']))])
                            ->where('is_published', 1)
                            ->orderBy('id', 'desc')
                            ->get();
                    } else {
                        $grades = Grade::where('teacher_user_id', $user['id'])
                            ->orderBy('id', 'desc')
                            ->get();
                    }
                    return response()->json(['ok' => true, 'grades' => $grades]);

                case 'save_grade':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $rawStudent = preg_replace('/\s+/', ' ', trim($in['studentName'] ?? ''));
                    $resolvedStudentName = $rawStudent;

                    if ($rawStudent !== '') {
                        if (filter_var($rawStudent, FILTER_VALIDATE_EMAIL)) {
                            $uRow = User::where('role', 'student')
                                ->whereRaw('LOWER(email) = ?', [strtolower($rawStudent)])
                                ->first();
                            if ($uRow && !empty($uRow->full_name)) {
                                $resolvedStudentName = $uRow->full_name;
                            }
                        } else {
                            $rowsU = User::where('role', 'student')
                                ->whereRaw('LOWER(full_name) LIKE ?', [strtolower($rawStudent) . '%'])
                                ->orderBy('full_name', 'asc')
                                ->take(2)
                                ->get();
                            if (count($rowsU) === 1 && !empty($rowsU[0]->full_name)) {
                                $resolvedStudentName = $rowsU[0]->full_name;
                            }
                        }
                    }

                    Grade::create([
                        'student_name' => $resolvedStudentName,
                        'subject' => trim($in['subject'] ?? ''),
                        'grade_value' => trim($in['gradeValue'] ?? ''),
                        'comment_text' => trim($in['commentText'] ?? ''),
                        'teacher_user_id' => $user['id'],
                        'is_published' => $in['isPublished'] ?? 0,
                    ]);

                    return response()->json(['ok' => true]);

                case 'publish_grade':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $grade = Grade::find($in['id']);
                    if ($grade) {
                        $grade->update(['is_published' => $in['isPublished']]);
                    }

                    return response()->json(['ok' => true]);

                // --- SAFEGUARDING & AUDIT LOGS ---
                case 'submit_safeguarding_report':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    
                    $report = SafeguardingReport::create([
                        'reporter_name' => ($in['isAnonymous'] ?? true) ? 'Anonim' : ($in['reporterName'] ?? ''),
                        'reporter_email' => ($in['isAnonymous'] ?? true) ? '' : ($in['reporterEmail'] ?? ''),
                        'is_anonymous' => ($in['isAnonymous'] ?? true) ? 1 : 0,
                        'category' => $in['category'],
                        'message_text' => $in['message'],
                    ]);

                    $this->auditLog(null, 'safeguarding_report_created', 'safeguarding_reports', $report->id);

                    return response()->json(['ok' => true]);

                case 'list_safeguarding':
                    $user = session('user');
                    if (!$user || $user['role'] !== 'admin') {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }
                    $rows = SafeguardingReport::orderBy('id', 'desc')->get();
                    return response()->json(['ok' => true, 'reports' => $rows]);

                case 'list_audit_logs':
                    $user = session('user');
                    if (!$user || $user['role'] !== 'admin') {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }
                    $rows = AuditLog::leftJoin('users', 'audit_logs.actor_user_id', '=', 'users.id')
                        ->select('audit_logs.*', 'users.full_name as actor_name')
                        ->orderBy('audit_logs.id', 'desc')
                        ->take(100)
                        ->get();
                    return response()->json(['ok' => true, 'logs' => $rows]);

                case 'list_users':
                    $user = session('user');
                    if (!$user || $user['role'] !== 'admin') {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }
                    $rows = User::orderBy('role', 'asc')->orderBy('full_name', 'asc')->get();
                    return response()->json(['ok' => true, 'users' => $rows]);

                // --- EVENTS ---
                case 'list_events':
                    $rows = Event::orderBy('event_date', 'asc')->get();
                    return response()->json(['ok' => true, 'events' => $rows]);

                case 'create_event':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || $user['role'] !== 'admin') {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $event = Event::create([
                        'title' => trim($in['title'] ?? ''),
                        'description' => trim($in['description'] ?? ''),
                        'event_date' => $in['event_date'],
                        'category' => $in['category'],
                    ]);

                    $this->auditLog($user['id'], 'event_created', 'events', $event->id);

                    return response()->json(['ok' => true]);

                case 'delete_event':
                    if ($method !== 'POST') break;
                    $user = session('user');
                    if (!$user || $user['role'] !== 'admin') {
                        return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
                    }

                    $in = $request->json()->all();
                    $event = Event::find($in['id']);
                    if ($event) {
                        $event->delete();
                    }

                    return response()->json(['ok' => true]);

                case 'submit_contact':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $adminEmail = config('mail.from.address', env('MAIL_USER'));
                    $msgBody = "Emri: " . ($in['name'] ?? 'Vizitor') . "<br>Email: " . ($in['email'] ?? 'pa email') . "<br>Subjekti: " . ($in['subject'] ?? 'pa subjekt') . "<br><br>" . nl2br($in['message'] ?? 'pa mesazh');
                    
                    $this->sendHtmlEmail($adminEmail, "Mesazh i ri nga: " . ($in['name'] ?? 'Vizitor'), $msgBody);

                    return response()->json(['ok' => true]);

                // --- PRIVATE DASHBOARD ---
                case 'private_whoami':
                    $auth = !empty(session('private_auth'));
                    return response()->json([
                        'ok' => true,
                        'authenticated' => $auth,
                        'csrfToken' => csrf_token()
                    ]);

                case 'private_login':
                    if ($method !== 'POST') break;
                    $in = $request->json()->all();
                    $secret = env('PRIVATE_DASHBOARD_KEY', 'ardi22');
                    
                    if (!$secret || $secret !== ($in['key'] ?? '')) {
                        return response()->json(['ok' => false, 'message' => 'Çelësi është i pasaktë ose i pakonfiguruar'], 401);
                    }

                    session(['private_auth' => true]);
                    return response()->json(['ok' => true]);

                case 'private_logout':
                    if ($method !== 'POST') break;
                    session()->forget('private_auth');
                    return response()->json(['ok' => true]);

                case 'private_list_scheduled_posts':
                    if (empty(session('private_auth'))) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }
                    $rows = ScheduledPost::orderBy('id', 'desc')->take(100)->get();
                    return response()->json(['ok' => true, 'posts' => $rows]);

                case 'private_schedule_from_prompt':
                    if ($method !== 'POST') break;
                    if (empty(session('private_auth'))) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    $in = $request->json()->all();
                    $prompt = $in['prompt'] ?? '';
                    $title = mb_substr($prompt, 0, 180);

                    ScheduledPost::create([
                        'source_prompt' => $prompt,
                        'title' => $title,
                        'content' => 'Gjeneruar nga: ' . $prompt,
                        'publish_at' => now()->addDays(3),
                    ]);

                    return response()->json(['ok' => true]);

                case 'private_create_scheduled_post':
                    if ($method !== 'POST') break;
                    if (empty(session('private_auth'))) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    $title = preg_replace('/\s+/', ' ', trim($request->input('title', '')));
                    $content = $request->input('content', '');
                    $publishAt = $request->input('publishAt', '');
                    $audience = $request->input('audience', 'all');
                    $prompt = $request->input('prompt', '');

                    if (!$title || !$content || !$publishAt) {
                        return response()->json(['ok' => false, 'message' => 'Titulli, përmbajtja dhe data janë të detyrueshme'], 422);
                    }

                    $imagePath = null;
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'], true)) {
                            $newName = uniqid('post_') . '.' . $ext;
                            $uploadPath = public_path('uploads');
                            if (!File::isDirectory($uploadPath)) {
                                File::makeDirectory($uploadPath, 0777, true, true);
                            }
                            $file->move($uploadPath, $newName);
                            $imagePath = 'uploads/' . $newName;
                            $content .= "\n\n![Image]($imagePath)";
                        }
                    }

                    ScheduledPost::create([
                        'source_prompt' => $prompt,
                        'title' => $title,
                        'content' => $content,
                        'audience' => $audience,
                        'publish_at' => $publishAt,
                    ]);

                    return response()->json(['ok' => true]);

                case 'private_publish_due_posts':
                    if ($method !== 'POST') break;
                    if (empty(session('private_auth'))) {
                        return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
                    }

                    $due = ScheduledPost::where('status', 'scheduled')
                        ->where('publish_at', '<=', now())
                        ->orderBy('publish_at', 'asc')
                        ->take(100)
                        ->get();

                    $published = 0;
                    foreach ($due as $post) {
                        Announcement::create([
                            'title' => $post->title,
                            'content' => $post->content,
                            'audience' => $post->audience ?: 'all',
                            'created_by_user_id' => $post->created_by_user_id,
                        ]);

                        $post->update([
                            'status' => 'published',
                            'published_at' => now(),
                        ]);

                        $published++;
                    }

                    return response()->json(['ok' => true, 'published' => $published]);

                default:
                    return response()->json(['ok' => false, 'message' => 'Veprim i panjohur'], 400);
            }
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['ok' => false, 'message' => 'Metodë e pasaktë'], 405);
    }

    /**
     * Send structured HTML emails utilizing Laravel's Mail system
     */
    private function sendHtmlEmail(string $to, string $subject, string $body): bool
    {
        try {
            $fromName = config('mail.from.name', 'Gjimnazi Ulpiana');
            $html = "
            <div style='font-family:sans-serif; max-width:600px; margin:0 auto; border:1px solid #eee; border-radius:12px; overflow:hidden;'>
                <div style='background:#0f172a; padding:25px; text-align:center;'><h2 style='color:#fff; margin:0;'>{$fromName}</h2></div>
                <div style='padding:30px; line-height:1.6; color:#334;'>
                    <h3 style='color:#0f172a;'>Njoftim i Ri</h3>
                    <p>{$body}</p>
                    <hr style='border:0; border-top:1px solid #eee; margin:25px 0;'>
                    <small style='color:#888;'>Ky është email automatik, ju lutem mos ktheni përgjigje.</small>
                </div>
            </div>";

            Mail::html($html, function ($message) use ($to, $subject, $fromName) {
                $message->to($to)
                        ->subject($subject);
            });
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Audit log helper
     */
    private function auditLog($userId, string $action, string $type = null, $targetId = null, array $details = null): void
    {
        try {
            AuditLog::create([
                'actor_user_id' => $userId,
                'action_name' => $action,
                'target_type' => $type,
                'target_id' => (string)$targetId,
                'details_json' => $details ? json_encode($details) : null,
            ]);
        } catch (\Throwable $e) {}
    }
}
