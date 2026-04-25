<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with latest job listings.
     * Route: GET / (name: home)
     *
     * @return View
     */
    public function index(): View
    {
        $jobs = Job::latest()->limit(6)->get();
        return view('pages.index')->with('jobs', $jobs);
    }
}
