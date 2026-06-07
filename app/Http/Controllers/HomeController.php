<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Grade;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Render the landing page with direct database variables.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        $events = Event::orderBy('event_date', 'asc')->get();
        $resources = Resource::orderBy('created_at', 'desc')->get();
        $teachers = User::where('role', 'teacher')->orderBy('full_name', 'asc')->get();

        // Public Leaderboard - Top 5 students by average grade (SQLite compatible)
        $allGrades = Grade::where('is_published', 1)->get();
        $grouped = $allGrades->filter(fn($g) => is_numeric(trim($g->grade_value)))
            ->groupBy('student_name')
            ->map(function ($grades, $name) {
                $avg = $grades->avg(fn($g) => floatval(trim($g->grade_value)));
                return (object)['student_name' => $name, 'avg_grade' => $avg, 'total_grades' => $grades->count()];
            })
            ->sortByDesc('avg_grade')
            ->take(5)
            ->values();
        $leaderboard = $grouped;

        return view('index', compact('announcements', 'events', 'resources', 'teachers', 'leaderboard'));
    }
}
