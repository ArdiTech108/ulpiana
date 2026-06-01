<?php

namespace App\Http\Controllers;

use App\Models\ScheduledPost;
use Illuminate\Http\Request;

class PrivateDashboardController extends Controller
{
    /**
     * Render the private/owner scheduling dashboard.
     */
    public function index(Request $request)
    {
        if (!session('private_authenticated')) {
            return redirect('/')->with('error', 'Nuk keni autorizim për këtë faqe. Kërkohet kyçja private.');
        }

        $scheduledPosts = ScheduledPost::orderBy('created_at', 'desc')->get();

        return view('private-dashboard', compact('scheduledPosts'));
    }
}
