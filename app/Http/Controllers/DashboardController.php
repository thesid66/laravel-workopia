<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     * Route: GET /dashboard (name: dashboard)
     */
    public function index(): View
    {
        // get logged in user
        $user = Auth::user();

        // get the user listings
        $jobs = Job::where('user_id', $user->id)->with('applicants')->withCount('applicants')->get();

        // get the total applicants for the user's job listings
        $totalApplicantsCount = $jobs->sum('applicants_count');

        return view('dashboard.index', compact('user', 'jobs', 'totalApplicantsCount'));
    }
}
