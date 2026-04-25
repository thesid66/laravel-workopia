<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class JobController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of jobs.
     * Route: GET /jobs (name: jobs.index)
     */
    public function index(): View
    {
        $jobs = Job::paginate(3);

        return view('jobs.index')->with('jobs', $jobs);
    }

    /**
     * Show the form to create a new job.
     * Route: GET /jobs/create (name: jobs.create)
     *
     * @return View
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a new job listing.
     * Route: POST /jobs (name: jobs.store)
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer|min:0',
            'tags' => 'nullable|string|max:255',
            'job_type' => 'required|in:Full-Time,Part-Time,Contract,Temporary,Internship,Volunteer,On-Call',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'address' => 'nullable|string',
            'benefits' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'company_website' => 'nullable|url|max:255',
            'company_description' => 'nullable|string',
        ]);

        // Getting the logged user id
        $loggedUserID = Auth::id();

        $validatedData['user_id'] = $loggedUserID;
        $validatedData['remote'] = $request->boolean('remote');

        // check for company logo image
        $validatedData['company_logo'] = null;

        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('logos', 'public');
            $validatedData['company_logo'] = Storage::url($logoPath);
        }

        // Submit to database
        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully!');
    }

    /**
     * Display a single job listing.
     * Route: GET /jobs/{job} (name: jobs.show)
     */
    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form to edit an existing job.
     * Route: GET /jobs/{job}/edit (name: jobs.edit)
     */
    public function edit(Job $job): View
    {
        // Check user authorisation
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update an existing job listing.
     * Route: PUT|PATCH /jobs/{job} (name: jobs.update)
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        // Check user authorisation
        $this->authorize('update', $job);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer|min:0',
            'tags' => 'nullable|string|max:255',
            'job_type' => 'required|in:Full-Time,Part-Time,Contract,Temporary,Internship,Volunteer,On-Call',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'address' => 'nullable|string',
            'benefits' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'company_website' => 'nullable|url|max:255',
            'company_description' => 'nullable|string',
        ]);

        $fallbackUserId = User::query()->value('id');

        if (! $fallbackUserId) {
            return back()
                ->withErrors(['user' => 'No user found. Please seed users first.'])
                ->withInput();
        }

        $validatedData['user_id'] = $fallbackUserId;
        $validatedData['remote'] = $request->boolean('remote');

        // Keep existing logo unless a new one is uploaded
        unset($validatedData['company_logo']);

        if ($request->hasFile('company_logo')) {
            // Delete old stored logo before replacing it
            if ($job->company_logo) {
                Storage::disk('public')->delete('logos/'.basename($job->company_logo));
            }

            $logoPath = $request->file('company_logo')->store('logos', 'public');
            $validatedData['company_logo'] = Storage::url($logoPath);
        }

        // Submit to database
        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
    }

    /**
     * Delete a job listing and its stored logo.
     * Route: DELETE /jobs/{job} (name: jobs.destroy)
     */
    public function destroy(Job $job): RedirectResponse
    {
        // Check user authorisation
        $this->authorize('delete', $job);

        // Find and delete logo
        if ($job->company_logo) {
            Storage::disk('public')->delete('logos/'.basename($job->company_logo));
        }

        $job->delete();

        // check if the request came from dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully!');
        }

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }
}
