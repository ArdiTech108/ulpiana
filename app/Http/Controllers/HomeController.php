<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('index', compact('announcements', 'events', 'resources', 'teachers'));
    }
}
