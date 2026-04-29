<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    /**
     * Display the authenticated user's bookmarked jobs.
     * Route: GET /bookmarks (name: bookmarks.index)
     *
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();

        $bookmarks = $user->bookmarkedJobs()->latest()->paginate(9);

        return view('jobs.bookmarked')->with('bookmarks', $bookmarks);
    }

    /**
     * Bookmark a job for the authenticated user.
     * Route: POST /bookmarks/{job} (name: bookmarks.store)
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        // Check if the job is bookmarked
        if ($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Job is already bookmarked');
        }

        // Create new book mark
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'Job has been bookmarked successfully!');

    }

    /**
     * Remove a bookmarked job for the authenticated user.
     * Route: DELETE /bookmarks/{job} (name: bookmarks.destroy)
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function destroy(Job $job): RedirectResponse
    {
        $user = Auth::user();

        // Check if the job is bookmarked
        if (! $user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Job is already bookmarked');
        }

        // Remove bookmark
        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('success', 'Bookmark has been removed successfully!');
    }
}
