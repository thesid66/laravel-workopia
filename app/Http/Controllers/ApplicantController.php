<?php

namespace App\Http\Controllers;

use App\Mail\JobApplied;
use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    /**
     * Display the authenticated user's submitted applications.
     * Route: GET /applications (name: applications.index)
     */
    public function index(Request $request): View
    {
        $applications = $request->user()
            ->applicants()
            ->with('job')
            ->latest()
            ->paginate(9);

        return view('applicants.index', compact('applications'));
    }

    /**
     * Store a new application for the given job.
     * Route: POST /jobs/{job}/apply (name: applicant.store)
     */
    public function store(Request $request, Job $job): RedirectResponse
    {
        // Check if the user has already applied
        $existingApplication = Applicant::where('job_id', $job->id)->where('user_id', $request->user()->id)->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied!');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'message' => 'required|string',
            'location' => 'nullable|string|max:255',
            'resume_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Store the uploaded resume on the public disk
        if ($request->hasFile('resume_path')) {
            $resumePath = $request->file('resume_path')->store('resumes', 'public');
            $validatedData['resume_path'] = Storage::url($resumePath);

        }

        $validatedData['job_id'] = $job->id;
        $validatedData['user_id'] = $request->user()->id;

        // Store the application
        $application = Applicant::create($validatedData)->load('user');

        // Send email to owner
        // Mail::to($job->user->email)->send(new JobApplied($application, $job));

        return redirect()->back()->with('success', 'Your application has been submitted');
    }

    /**
     * Delete an applicant and remove their stored resume.
     *
     * @param  int  $id
     */
    public function destroy($id, Request $request): RedirectResponse
    {
        $applicant = Applicant::findOrFail($id);
        abort_unless($applicant->job->user_id === $request->user()->id, 403);

        // Convert /storage/resumes/file.pdf into resumes/file.pdf for the public disk
        if ($applicant->resume_path) {
            $resumePath = str_replace('/storage/', '', $applicant->resume_path);
            Storage::disk('public')->delete($resumePath);
        }

        $applicant->delete();

        return redirect()->back()->with('success', 'Applicant deleted successfully');
    }
}
