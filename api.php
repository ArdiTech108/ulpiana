<?php
/**
 * API Handler for Gjimnazi "Ulpiana"
 * Handles Auth, Bookings, Resources, and Admin tasks
 */
require __DIR__ . '/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

$cfg = app_config();
define('SMTP_HOST', (string)($cfg['mail_host'] ?? ''));
define('SMTP_USER', (string)($cfg['mail_user'] ?? ''));
define('SMTP_PASS', (string)($cfg['mail_pass'] ?? ''));
define('SMTP_PORT', (int)($cfg['mail_port'] ?? 587));
define('SMTP_SECURE', (string)($cfg['mail_encryption'] ?? 'tls'));
define('GOOGLE_CLIENT_ID', (string)($cfg['google_client_id'] ?? ''));
define('GOOGLE_CLIENT_SECRET', (string)($cfg['google_client_secret'] ?? ''));
define('GOOGLE_REDIRECT_URI', rtrim((string)($cfg['base_url'] ?? 'http://localhost/ulpiana'), '/') . '/api.php?action=google_callback');

function clean_text($v, $max = 255) {
    $normalized = preg_replace('/\s+/', ' ', trim((string)$v));
    if (function_exists('mb_substr')) return mb_substr($normalized, 0, $max);
    return substr($normalized, 0, $max);
}
function valid_email($e) { return filter_var($e, FILTER_VALIDATE_EMAIL); }
function client_ip() { return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'; }
function random_reset_code($len = 6): string {
    $min = (int)str_pad('1', $len, '0');
    $max = (int)str_pad('', $len, '9');
    return (string)random_int($min, $max);
}
function safe_substr($text, $start, $length = 1) {
    if (function_exists('mb_substr')) return mb_substr((string)$text, $start, $length);
    return substr((string)$text, $start, $length);
}

function rate_limit($key, $limit, $window) {
    if(!isset($_SESSION['rate_limit'])) $_SESSION['rate_limit'] = [];
    $now = time();
    $b = $_SESSION['rate_limit'][$key] ?? ['c'=>0, 's'=>$now];
    if(($now - $b['s']) > $window) $b = ['c'=>0, 's'=>$now];
    $b['c']++;
    $_SESSION['rate_limit'][$key] = $b;
    if($b['c'] > $limit) json_response(['ok'=>false, 'message'=>'Shumë kërkesa. Provoni më vonë.'], 429);
}

function send_simple_email($to, $subject, $body): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(SMTP_USER, 'Gjimnazi Ulpiana');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $html = "
        <div style='font-family:sans-serif; max-width:600px; margin:0 auto; border:1px solid #eee; border-radius:12px; overflow:hidden;'>
            <div style='background:#0f172a; padding:25px; text-align:center;'><h2 style='color:#fff; margin:0;'>Gjimnazi Ulpiana</h2></div>
            <div style='padding:30px; line-height:1.6; color:#334;'>
                <h3 style='color:#0f172a;'>Njoftim i Ri</h3>
                <p>{$body}</p>
                <hr style='border:0; border-top:1px solid #eee; margin:25px 0;'>
                <small style='color:#888;'>Ky është email automatik, ju lutem mos ktheni përgjigje.</small>
            </div>
        </div>";
        $mail->Body = $html;
        $mail->AltBody = strip_tags($body);
        return $mail->send();
    } catch (Exception $e) { return false; }
}

function audit_log($userId, $action, $type=null, $tid=null, $details=null) {
    try {
        $st = db()->prepare('INSERT INTO audit_logs (actor_user_id, action_name, target_type, target_id, details_json) VALUES (?,?,?,?,?)');
        $st->execute([$userId, $action, $type, $tid, $details ? json_encode($details) : null]);
    } catch(Exception $e) {}
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'POST' && !in_array($action, ['login','signup','google_callback'])) {
    verify_csrf();
}

try {
    if ($action === 'whoami') json_response(['ok'=>true, 'user'=>$_SESSION['user']??null, 'csrfToken'=>csrf_token()]);
    if ($action === 'csrf') json_response(['ok'=>true, 'csrfToken'=>csrf_token()]);

    if ($action === 'login' && $method === 'POST') {
        rate_limit('login:'.client_ip(), 10, 600);
        $in = json_input();
        $st = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $st->execute([strtolower($in['email']??'')]);
        $user = $st->fetch();
        if(!$user || !password_verify($in['password']??'', $user['password_hash'])) json_response(['ok'=>false, 'message'=>'Email ose fjalëkalim i gabuar'], 401);
        unset($user['password_hash']);
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        json_response(['ok'=>true, 'user'=>$user]);
    }

    if ($action === 'signup' && $method === 'POST') {
        $in = json_input();
        $name = clean_text($in['fullName']??'');
        $email = strtolower(clean_text($in['email']??''));
        $role = $in['role'] ?? 'parent';
        if (!in_array($role, ['parent', 'student'])) $role = 'parent';
        
        if(!$name || !$email || strlen($in['password']??'') < 6) json_response(['ok'=>false, 'message'=>'Të dhëna të paplota'], 422);
        $hash = password_hash($in['password'], PASSWORD_BCRYPT);
        $st = db()->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
        $st->execute([$name, $email, $hash, $role]);
        
        $newId = db()->lastInsertId();
        $st = db()->prepare('SELECT id, full_name, email, role FROM users WHERE id = ?');
        $st->execute([$newId]);
        $user = $st->fetch();
        
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        json_response(['ok'=>true, 'user'=>$user]);
    }

    if ($action === 'request_password_reset' && $method === 'POST') {
        rate_limit('pwreset:'.client_ip(), 5, 900);
        $in = json_input();
        $email = strtolower(clean_text($in['email'] ?? '', 190));
        if (!$email || !valid_email($email)) {
            json_response(['ok'=>true, 'message'=>'Nëse email-i ekziston, kodi u dërgua.']);
        }

        $st = db()->prepare('SELECT id, full_name FROM users WHERE LOWER(email)=LOWER(?) LIMIT 1');
        $st->execute([$email]);
        $u = $st->fetch();

        // Always return success-like message (prevent user enumeration)
        if (!$u) json_response(['ok'=>true, 'message'=>'Nëse email-i ekziston, kodi u dërgua.']);

        $code = random_reset_code(6);
        $hash = password_hash($code, PASSWORD_BCRYPT);
        $expiresAt = date('Y-m-d H:i:s', time() + 15 * 60);

        $stIns = db()->prepare('INSERT INTO password_resets (user_id, email, token_hash, expires_at) VALUES (?,?,?,?)');
        $stIns->execute([$u['id'], $email, $hash, $expiresAt]);

        $body = "Përshëndetje {$u['full_name']},<br><br>Kodi për rivendosjen e fjalëkalimit është: <strong>{$code}</strong><br>Ky kod vlen 15 minuta.";
        send_simple_email($email, 'Kodi për rivendosjen e fjalëkalimit', $body);

        json_response(['ok'=>true, 'message'=>'Kodi u dërgua në email.']);
    }

    if ($action === 'reset_password' && $method === 'POST') {
        rate_limit('pwresetconfirm:'.client_ip(), 8, 900);
        $in = json_input();
        $email = strtolower(clean_text($in['email'] ?? '', 190));
        $token = clean_text($in['token'] ?? '', 20);
        $newPassword = (string)($in['newPassword'] ?? '');

        if (!$email || !valid_email($email) || !$token || strlen($newPassword) < 6) {
            json_response(['ok'=>false, 'message'=>'Të dhëna të pavlefshme.'], 422);
        }

        $st = db()->prepare('SELECT * FROM password_resets WHERE LOWER(email)=LOWER(?) AND used_at IS NULL AND expires_at >= NOW() ORDER BY id DESC LIMIT 5');
        $st->execute([$email]);
        $rows = $st->fetchAll();

        $match = null;
        foreach ($rows as $r) {
            if (password_verify($token, $r['token_hash'])) {
                $match = $r;
                break;
            }
        }

        if (!$match) json_response(['ok'=>false, 'message'=>'Kodi është i gabuar ose i skaduar.'], 400);

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stU = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stU->execute([$newHash, $match['user_id']]);

        $stUsed = db()->prepare('UPDATE password_resets SET used_at = NOW() WHERE id = ?');
        $stUsed->execute([$match['id']]);

        json_response(['ok'=>true, 'message'=>'Fjalëkalimi u përditësua me sukses.']);
    }

    if ($action === 'google_auth') {
        if (!GOOGLE_CLIENT_ID) json_response(['ok'=>false, 'message'=>'Google Auth nuk është konfiguruar.'], 500);
        $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'offline',
            'prompt' => 'select_account'
        ]);
        header("Location: $url");
        exit;
    }

    if ($action === 'google_callback') {
        $code = $_GET['code'] ?? '';
        if (!$code) json_response(['ok'=>false, 'message'=>'Code mungon.'], 400);

        // Exchange code for token
        $ch = curl_init("https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1'], true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !$isLocal);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $isLocal ? 0 : 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code' => $code,
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'grant_type' => 'authorization_code'
        ]));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($res['access_token'])) json_response(['ok'=>false, 'message'=>'Token dështoi. Kontrolloni Client ID/Secret dhe Redirect URI.'], 500);

        // Get User Info
        $ch = curl_init("https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $res['access_token']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !$isLocal);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $isLocal ? 0 : 2);
        $user_info = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $email = strtolower($user_info['email']);
        $name = $user_info['name'];

        // Check if user exists
        $st = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $st->execute([$email]);
        $user = $st->fetch();

        if (!$user) {
            // Auto-signup as parent by default for Google users
            $st = db()->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $st->execute([$name, $email, 'google_auth_no_pass', 'parent']);
            $newId = db()->lastInsertId();
            $st = db()->prepare('SELECT id, full_name, email, role FROM users WHERE id = ?');
            $st->execute([$newId]);
            $user = $st->fetch();
        }

        unset($user['password_hash']);
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        header("Location: index.html?auth=success");
        exit;
    }

    if ($action === 'logout' && $method === 'POST') {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        json_response(['ok'=>true]);
    }

    if ($action === 'book_slot' && $method === 'POST') {
        $user = require_login();
        $in = json_input();
        $st = db()->prepare('INSERT INTO bookings (teacher_id, teacher_name, teacher_subject, teacher_email, slot_time, parent_name, student_name, parent_email, topic, created_by_user_id) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $st->execute([$in['teacherId'], $in['teacherName'], $in['teacherSubject'], $in['teacherEmail'], $in['time'], $in['parentName'], $in['studentName'], $in['parentEmail'], $in['topic'], $user['id']]);
        $bookingId = db()->lastInsertId();
        audit_log($user['id'], 'slot_booked', 'bookings', $bookingId, ['teacher'=>$in['teacherName'], 'time'=>$in['time']]);
        
        // Email për profesorin
        send_simple_email($in['teacherEmail'], "Rezervim i ri: {$in['parentName']}", "Prindi {$in['parentName']} rezervoi terminin në orën {$in['time']} për nxënësin {$in['studentName']}. Tema: {$in['topic']}");
        
        // Email për drejtorinë (Gjimnazi Ulpiana)
        send_simple_email(SMTP_USER, "Njoftim Rezervimi: {$in['teacherName']}", "Ka një rezervim të ri në platformë:\n\nProfesori: {$in['teacherName']}\nLënda: {$in['teacherSubject']}\nPrindi: {$in['parentName']}\nNxënësi: {$in['studentName']}\nOra: {$in['time']}");
        
        json_response(['ok'=>true]);
    }

    if ($action === 'list_teachers') {
        $teachers = [];
        try {
            $st = db()->query('SELECT id, full_name as name, teacher_subject as subject, email FROM users WHERE role = "teacher" ORDER BY full_name ASC');
            foreach($st->fetchAll() as $t) {
                $parts = preg_split('/\s+/', trim((string)$t['name'])) ?: [];
                $initials = implode('', array_map(fn($n)=>safe_substr($n,0,1), $parts));
                $teachers[] = [
                    'id' => 'db_' . $t['id'],
                    'name' => $t['name'],
                    'subject' => $t['subject'] ?: 'Lëndë e papërcaktuar',
                    'email' => $t['email'],
                    'initials' => strtoupper($initials ?: 'T')
                ];
            }
        } catch (Exception $e) {
            $teachers = [];
        }
        json_response(['ok'=>true, 'teachers'=>$teachers]);
    }

    if ($action === 'get_teacher_booked_slots') {
        $tid = $_GET['teacherId'] ?? '';
        $st = db()->prepare('SELECT slot_time FROM bookings WHERE teacher_id = ? AND DATE(created_at) = CURDATE()');
        $st->execute([$tid]);
        json_response(['ok'=>true, 'slots'=>array_map(fn($r)=>$r['slot_time'], $st->fetchAll())]);
    }

    if ($action === 'get_bookings') {
        $user = require_login();
        $sql = ($user['role']==='admin') ? 'SELECT * FROM bookings ORDER BY id DESC' : 'SELECT * FROM bookings WHERE teacher_email = ? ORDER BY id DESC';
        $st = db()->prepare($sql);
        $user['role']==='admin' ? $st->execute() : $st->execute([$user['email']]);
        json_response(['ok'=>true, 'bookings'=>$st->fetchAll()]);
    }

    if ($action === 'update_booking_status' && $method === 'POST') {
        require_role(['teacher', 'admin']);
        $in = json_input();
        
        // Update status
        $st = db()->prepare('UPDATE bookings SET status = ? WHERE id = ?');
        $st->execute([$in['status'], $in['id']]);

        // Nëse pranohet, dërgo email njoftues prindit
        if ($in['status'] === 'accepted') {
            $st = db()->prepare('SELECT * FROM bookings WHERE id = ?');
            $st->execute([$in['id']]);
            $b = $st->fetch();
            if ($b && $b['parent_email']) {
                $msg = "I/e nderuar {$b['parent_name']},\n\nTakimi juaj me profesorin {$b['teacher_name']} për nxënësin {$b['student_name']} është KONFIRMUAR për orën {$b['slot_time']}.\n\nJu faleminderit!";
                send_simple_email($b['parent_email'], "Konfirmim i Takimit - Gjimnazi Ulpiana", $msg);
            }
        }
        
        json_response(['ok'=>true]);
    }

    if ($action === 'dashboard_analytics') {
        require_role(['teacher', 'admin']);
        $total = db()->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
        $accepted = db()->query("SELECT COUNT(*) FROM bookings WHERE status = 'accepted'")->fetchColumn();
        $students = db()->query('SELECT COUNT(DISTINCT student_name) FROM bookings')->fetchColumn();
        json_response(['ok'=>true, 'analytics'=>[
            'totalBookings' => $total,
            'acceptedBookings' => $accepted,
            'totalStudents' => $students
        ]]);
    }

    if ($action === 'get_settings') {
        $user = require_login();
        json_response(['ok'=>true, 'settings'=>['display_name'=>$user['full_name'], 'email'=>$user['email']]]);
    }

    if ($action === 'save_settings' && $method === 'POST') {
        $user = require_login();
        $in = json_input();
        $st = db()->prepare('UPDATE users SET full_name = ? WHERE id = ?');
        $st->execute([$in['displayName'], $user['id']]);
        $_SESSION['user']['full_name'] = $in['displayName'];
        json_response(['ok'=>true]);
    }

    if ($action === 'list_announcements') {
        $rows = db()->query('SELECT a.*, u.full_name as author_name FROM announcements a LEFT JOIN users u ON a.created_by_user_id = u.id ORDER BY a.id DESC LIMIT 50')->fetchAll();
        json_response(['ok'=>true, 'announcements'=>$rows]);
    }

    if ($action === 'list_resources') {
        $rows = db()->query('SELECT r.*, u.full_name as uploader_name FROM resources r LEFT JOIN users u ON r.uploaded_by_user_id = u.id ORDER BY r.id DESC')->fetchAll();
        json_response(['ok'=>true, 'resources'=>$rows]);
    }

    if ($action === 'list_grades') {
        $user = require_login();
        if($user['role']==='student') {
            $st = db()->prepare('SELECT * FROM grades WHERE LOWER(TRIM(student_name)) = LOWER(TRIM(?)) AND is_published = 1 ORDER BY id DESC');
            $st->execute([$user['full_name']]);
        } else {
            $st = db()->prepare('SELECT * FROM grades WHERE teacher_user_id = ? ORDER BY id DESC');
            $st->execute([$user['id']]);
        }
        json_response(['ok'=>true, 'grades'=>$st->fetchAll()]);
    }
    
    // Add more actions as needed...
    if ($action === 'save_grade' && $method === 'POST') {
        $user = require_role(['teacher', 'admin']);
        $in = json_input();
        $rawStudent = clean_text($in['studentName'] ?? '', 190);
        $resolvedStudentName = $rawStudent;

        if ($rawStudent !== '') {
            // If teacher typed student email, resolve to exact registered full_name
            if (filter_var($rawStudent, FILTER_VALIDATE_EMAIL)) {
                $stU = db()->prepare('SELECT full_name FROM users WHERE role = "student" AND LOWER(email) = LOWER(?) LIMIT 1');
                $stU->execute([$rawStudent]);
                $uRow = $stU->fetch();
                if ($uRow && !empty($uRow['full_name'])) {
                    $resolvedStudentName = $uRow['full_name'];
                }
            } else {
                // If teacher typed only first name (e.g. "Ardi"), try unique student match
                $stU = db()->prepare('SELECT full_name FROM users WHERE role = "student" AND LOWER(full_name) LIKE LOWER(?) ORDER BY full_name ASC LIMIT 2');
                $stU->execute([$rawStudent . '%']);
                $rowsU = $stU->fetchAll();
                if (count($rowsU) === 1 && !empty($rowsU[0]['full_name'])) {
                    $resolvedStudentName = $rowsU[0]['full_name'];
                }
            }
        }

        $st = db()->prepare('INSERT INTO grades (student_name, subject, grade_value, comment_text, teacher_user_id, is_published) VALUES (?,?,?,?,?,?)');
        $st->execute([$resolvedStudentName, $in['subject'], $in['gradeValue'], $in['commentText']??'', $user['id'], $in['isPublished']??0]);
        json_response(['ok'=>true]);
    }

    if ($action === 'publish_grade' && $method === 'POST') {
        require_role(['teacher', 'admin']);
        $in = json_input();
        $st = db()->prepare('UPDATE grades SET is_published = ? WHERE id = ?');
        $st->execute([$in['isPublished'], $in['id']]);
        json_response(['ok'=>true]);
    }

    if ($action === 'create_announcement' && $method === 'POST') {
        $user = require_role(['teacher', 'admin']);
        $in = json_input();
        $st = db()->prepare('INSERT INTO announcements (title, content, created_by_user_id) VALUES (?,?,?)');
        $st->execute([$in['title'], $in['content'], $user['id']]);
        json_response(['ok'=>true]);
    }

    if ($action === 'upload_resource' && $method === 'POST') {
        $user = require_role(['teacher', 'admin']);
        if (empty($_FILES['file'])) json_response(['ok'=>false, 'message'=>'Asnjë skedar nuk u dërgua.'], 400);
        
        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // SECURITY FIX: Whitelist allowed extensions
        $allowedExts = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'zip'];
        if (!in_array($ext, $allowedExts, true)) {
            json_response(['ok'=>false, 'message'=>'Prapashtesa e skedarit nuk lejohet për arsye sigurie.'], 403);
        }
        
        $newName = uniqid('res_') . '.' . $ext;
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
            $filePath = 'uploads/' . $newName;
            $st = db()->prepare('INSERT INTO resources (title, category, file_path, uploaded_by_user_id) VALUES (?,?,?,?)');
            $st->execute([$_POST['title'], $_POST['category'], $filePath, $user['id']]);
            json_response(['ok'=>true]);
        }
        json_response(['ok'=>false, 'message'=>'Dështoi ngarkimi i skedarit.'], 500);
    }

    if ($action === 'delete_resource' && $method === 'POST') {
        require_role(['teacher', 'admin']);
        $in = json_input();
        $st = db()->prepare('DELETE FROM resources WHERE id = ?');
        $st->execute([$in['id']]);
        json_response(['ok'=>true]);
    }

    if ($action === 'submit_safeguarding_report' && $method === 'POST') {
        $in = json_input();
        $st = db()->prepare('INSERT INTO safeguarding_reports (reporter_name, reporter_email, is_anonymous, category, message_text) VALUES (?,?,?,?,?)');
        $st->execute([
            $in['isAnonymous'] ? 'Anonim' : ($in['reporterName'] ?? ''),
            $in['isAnonymous'] ? '' : ($in['reporterEmail'] ?? ''),
            $in['isAnonymous'] ? 1 : 0,
            $in['category'],
            $in['message']
        ]);
        audit_log(null, 'safeguarding_report_created', 'safeguarding_reports', db()->lastInsertId());
        json_response(['ok'=>true]);
    }

    if ($action === 'list_safeguarding') {
        require_role(['admin']);
        $rows = db()->query('SELECT * FROM safeguarding_reports ORDER BY id DESC')->fetchAll();
        json_response(['ok'=>true, 'reports'=>$rows]);
    }

    if ($action === 'list_audit_logs') {
        require_role(['admin']);
        $rows = db()->query('SELECT l.*, u.full_name as actor_name FROM audit_logs l LEFT JOIN users u ON l.actor_user_id = u.id ORDER BY l.id DESC LIMIT 100')->fetchAll();
        json_response(['ok'=>true, 'logs'=>$rows]);
    }

    if ($action === 'list_users') {
        require_role(['admin']);
        $rows = db()->query('SELECT id, full_name, email, role, teacher_subject, created_at FROM users ORDER BY role ASC, full_name ASC')->fetchAll();
        json_response(['ok'=>true, 'users'=>$rows]);
    }

    if ($action === 'list_events') {
        try {
            $rows = db()->query('SELECT * FROM events ORDER BY event_date ASC')->fetchAll();
        } catch (Exception $e) {
            $rows = [];
        }
        json_response(['ok'=>true, 'events'=>$rows]);
    }

    if ($action === 'create_event' && $method === 'POST') {
        require_role(['admin']);
        $in = json_input();
        $st = db()->prepare('INSERT INTO events (title, description, event_date, category) VALUES (?,?,?,?)');
        $st->execute([$in['title'], $in['description'], $in['event_date'], $in['category']]);
        audit_log(null, 'event_created', 'events', db()->lastInsertId());
        json_response(['ok'=>true]);
    }

    if ($action === 'delete_event' && $method === 'POST') {
        require_role(['admin']);
        $in = json_input();
        $st = db()->prepare('DELETE FROM events WHERE id = ?');
        $st->execute([$in['id']]);
        json_response(['ok'=>true]);
    }

    if ($action === 'submit_contact' && $method === 'POST') {
        $in = json_input();
        send_simple_email(SMTP_USER, "Mesazh i ri nga: ".($in['name']??'Vizitor'), "Email: ".($in['email']??'pa email')."\n\n".($in['message']??'pa mesazh'));
        json_response(['ok'=>true]);
    }
    // --- PRIVATE DASHBOARD ENDPOINTS ---

    if ($action === 'private_whoami') {
        $auth = !empty($_SESSION['private_auth']);
        json_response(['ok'=>true, 'authenticated'=>$auth, 'csrfToken'=>csrf_token()]);
    }

    if ($action === 'private_login' && $method === 'POST') {
        rate_limit('privatelogin:'.client_ip(), 10, 600);
        $in = json_input();
        $secret = (string)($cfg['private_dashboard_key'] ?? '');
        if (!$secret || $secret !== ($in['key'] ?? '')) {
            json_response(['ok'=>false, 'message'=>'Çelësi është i pasaktë ose i pakonfiguruar'], 401);
        }
        $_SESSION['private_auth'] = true;
        json_response(['ok'=>true]);
    }

    if ($action === 'private_logout' && $method === 'POST') {
        unset($_SESSION['private_auth']);
        json_response(['ok'=>true]);
    }

    if ($action === 'private_list_scheduled_posts') {
        if (empty($_SESSION['private_auth'])) json_response(['ok'=>false, 'message'=>'Unauthorized'], 401);
        $rows = db()->query('SELECT * FROM scheduled_posts ORDER BY id DESC LIMIT 100')->fetchAll();
        json_response(['ok'=>true, 'posts'=>$rows]);
    }

    if ($action === 'private_schedule_from_prompt' && $method === 'POST') {
        if (empty($_SESSION['private_auth'])) json_response(['ok'=>false, 'message'=>'Unauthorized'], 401);
        $in = json_input();
        $title = mb_substr($in['prompt'] ?? 'Prompt', 0, 180);
        $st = db()->prepare('INSERT INTO scheduled_posts (source_prompt, title, content, publish_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY))');
        $st->execute([$in['prompt'] ?? '', $title, 'Gjeneruar nga: ' . ($in['prompt'] ?? '')]);
        json_response(['ok'=>true]);
    }

    if ($action === 'private_create_scheduled_post' && $method === 'POST') {
        if (empty($_SESSION['private_auth'])) json_response(['ok'=>false, 'message'=>'Unauthorized'], 401);
        
        $title = clean_text($_POST['title'] ?? '', 180);
        $content = $_POST['content'] ?? '';
        $publishAt = $_POST['publishAt'] ?? '';
        $audience = $_POST['audience'] ?? 'all';
        $prompt = $_POST['prompt'] ?? '';
        
        if (!$title || !$content || !$publishAt) {
            json_response(['ok'=>false, 'message'=>'Titulli, përmbajtja dhe data janë të detyrueshme'], 422);
        }

        $imagePath = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'], true)) {
                $newName = uniqid('post_') . '.' . $ext;
                $uploadDir = __DIR__ . '/uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName)) {
                    $imagePath = 'uploads/' . $newName;
                    $content .= "\n\n![Image]($imagePath)";
                }
            }
        }

        $st = db()->prepare('INSERT INTO scheduled_posts (source_prompt, title, content, audience, publish_at) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$prompt, $title, $content, $audience, $publishAt]);
        json_response(['ok'=>true]);
    }

    if ($action === 'private_publish_due_posts' && $method === 'POST') {
        if (empty($_SESSION['private_auth'])) json_response(['ok'=>false, 'message'=>'Unauthorized'], 401);
        
        $rows = db()->query("SELECT * FROM scheduled_posts WHERE status='scheduled' AND publish_at <= NOW() ORDER BY publish_at ASC LIMIT 100")->fetchAll();
        $published = 0;
        foreach ($rows as $r) {
            $ins = db()->prepare('INSERT INTO announcements (title, content, audience, created_by_user_id) VALUES (?, ?, ?, ?)');
            $ins->execute([$r['title'], $r['content'], $r['audience'] ?: 'all', $r['created_by_user_id']]);

            $up = db()->prepare("UPDATE scheduled_posts SET status='published', published_at=NOW() WHERE id=?");
            $up->execute([(int)$r['id']]);
            $published++;
        }
        json_response(['ok'=>true, 'published'=>$published]);
    }

} catch (Exception $e) { json_response(['ok'=>false, 'message'=>$e->getMessage()], 500); }
