<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\AuditLog;
use App\Models\SafeguardingReport;
use App\Models\Grade;
use App\Models\Announcement;
use App\Models\Resource;
use App\Models\Event;
use App\Models\ScheduledPost;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the dashboard rendering for Admin and Teachers.
     */
    public function index(Request $request)
    {
        $userSession = session('user');

        if (!$userSession) {
            return redirect('/')->with('error', 'Ju lutem kyçuni në sistem.');
        }

        $userId = is_array($userSession) ? ($userSession['id'] ?? null) : ($userSession->id ?? null);
        if (!$userId) {
            return redirect('/')->with('error', 'Sesioni nuk është i vlefshëm.');
        }

        // Reload the user from the database to ensure we have fresh data
        $dbUser = User::find($userId);
        if (!$dbUser || !in_array($dbUser->role, ['admin', 'teacher'])) {
            return redirect('/')->with('error', 'Nuk keni autorizim për këtë faqe.');
        }

        $user = $dbUser;

        // Initialize empty sets
        $bookings = collect();
        $logs = collect();
        $reports = collect();
        $users = collect();
        $teachers = collect();
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        $resources = collect();
        $events = Event::orderBy('event_date', 'asc')->get();
        $grades = collect();
        $scheduledPosts = collect();

        // Metrics
        $totalBookings = 0;
        $acceptedBookings = 0;
        $totalStudents = User::where('role', 'student')->count();

        if ($user->role === 'admin') {
            $totalBookings = Booking::count();
            $acceptedBookings = Booking::where('status', 'accepted')->count();
            $bookings = Booking::orderBy('created_at', 'desc')->get();
            $logs = AuditLog::orderBy('created_at', 'desc')->limit(50)->get();
            $reports = SafeguardingReport::orderBy('created_at', 'desc')->get();
            $users = User::orderBy('created_at', 'desc')->get();
            $teachers = User::where('role', 'teacher')->orderBy('full_name', 'asc')->get();
            $resources = Resource::orderBy('created_at', 'desc')->get();
            $scheduledPosts = ScheduledPost::orderBy('created_at', 'desc')->get();
        } else {
            // Teacher specific data
            $totalBookings = Booking::where('teacher_email', $user->email)->count();
            $acceptedBookings = Booking::where('teacher_email', $user->email)->where('status', 'accepted')->count();
            $bookings = Booking::where('teacher_email', $user->email)->orderBy('created_at', 'desc')->get();
            $grades = Grade::where('teacher_user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $resources = Resource::orderBy('created_at', 'desc')->get();
        }

        return view('dashboard', compact(
            'user',
            'bookings',
            'logs',
            'reports',
            'users',
            'teachers',
            'announcements',
            'resources',
            'events',
            'grades',
            'scheduledPosts',
            'totalBookings',
            'acceptedBookings',
            'totalStudents'
        ));
    }
}
