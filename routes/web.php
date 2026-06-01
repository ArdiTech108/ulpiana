<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\PrivateDashboardController;
use App\Http\Controllers\LegacyApiController;

// Clean Dynamic URLs
Route::get('/', [HomeController::class, 'index']);
Route::get('/drejtimi-natyror', function () { return view('drejtimi-natyror'); });
Route::get('/drejtimi-shoqeror', function () { return view('drejtimi-shoqeror'); });
Route::get('/kushtet', function () { return view('kushtet'); });
Route::get('/privatesia', function () { return view('privatesia'); });
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/student-dashboard', [StudentDashboardController::class, 'index']);
Route::get('/private-dashboard', [PrivateDashboardController::class, 'index']);

// Legacy .html Compatibility URLs (Redirecting dynamically)
Route::get('/index.html', function () { return redirect('/'); });
Route::get('/drejtimi-natyror.html', function () { return view('drejtimi-natyror'); });
Route::get('/drejtimi-shoqeror.html', function () { return view('drejtimi-shoqeror'); });
Route::get('/kushtet.html', function () { return view('kushtet'); });
Route::get('/privatesia.html', function () { return view('privatesia'); });
Route::get('/dashboard.html', [DashboardController::class, 'index']);
Route::get('/student-dashboard.html', [StudentDashboardController::class, 'index']);
Route::get('/private-dashboard.html', [PrivateDashboardController::class, 'index']);

// Legacy api.php AJAX Bridge Routing
Route::any('/api.php', [LegacyApiController::class, 'handle']);
