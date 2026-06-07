<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Announcement;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    /**
     * Render the student dashboard.
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

        $dbUser = User::find($userId);
        if (!$dbUser || $dbUser->role !== 'student') {
            return redirect('/')->with('error', 'Nuk keni autorizim për këtë faqe.');
        }

        $user = $dbUser;
        
        // Exact lower-trim matches for student name with publish filtering
        $grades = Grade::whereRaw('LOWER(TRIM(student_name)) = ?', [strtolower(trim($user->full_name))])
            ->where('is_published', 1)
            ->orderBy('id', 'desc')
            ->get();
            
        $resources = Resource::orderBy('created_at', 'desc')->get();
        $announcements = Announcement::orderBy('created_at', 'desc')->get();

        // Leaderboard: Top 10 students by average grade (SQLite compatible)
        $allGradesLb = Grade::where('is_published', 1)->get();
        $leaderboard = $allGradesLb->filter(fn($g) => is_numeric(trim($g->grade_value)))
            ->groupBy('student_name')
            ->map(function ($grades, $name) {
                $avg = $grades->avg(fn($g) => floatval(trim($g->grade_value)));
                return (object)['student_name' => $name, 'avg_grade' => $avg, 'total_grades' => $grades->count()];
            })
            ->sortByDesc('avg_grade')
            ->take(10)
            ->values();

        return view('student-dashboard', compact('user', 'grades', 'resources', 'announcements', 'leaderboard'));
    }
}
