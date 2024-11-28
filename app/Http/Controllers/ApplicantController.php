<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ApplicantController extends Controller{
    //@desc store new Job application
    // @route Post /jobs/{job}/apply

    public function store(Request $request, Job $job): RedirectResponse
    {
        // Check if the user has already applied for the job
        $existingApplication = Applicant::where('job_id', $job->id)
                                        ->where('user_id', auth()->id())
                                        ->exists();
    
        if ($existingApplication) {
            return redirect()->back()->with('status', 'You have already applied to this job.');
        }
    
        // Validate incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'contact_phone' => 'string',
            'contact_email' => 'required|string|email',
            'message' => 'string',
            'location' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);
    
        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validatedData['resume_path'] = $path;
        }
    
        // Store the application
        $application = new Applicant($validatedData);
        $application->job_id = $job->id;
        $application->user_id = auth()->id();
        $application->save();
    
        return redirect()->back()->with('success', 'Your application has been submitted.');
    }
    // @desc   Delete a job application
// @route  DELETE /applicants/{applicant}
public function destroy($id): RedirectResponse
{
    $applicant = Applicant::findOrFail($id);
    $applicant->delete();
    return redirect()->route('dashboard.show')->with('success', 'Applicant deleted successfully.');

}
}
