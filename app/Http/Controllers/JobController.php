<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        // Logic to list all jobs
        $jobs = Job::with('employer')->latest()->Paginate(10);

        return view('jobs.index', [
            'jobs' =>  $jobs
        ]);
    }
    public function create()
    {
        // Logic to show form for creating a new job
        return view('jobs.create');
    }
    public function show(Job $job)
    {
        // Logic to show a specific job by ID
        return view('jobs.show', [
            'job' => $job
        ]);
    }

    public function store()
    {
        // Logic to store a new job in the database
        request()->validate([
            'title' => 'required',
            'salary' => 'required|numeric|max:1000000|min:20000'
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1 // TODO: replace with auth user id
        ]);

        return redirect('/jobs');
    }
    public function edit(Job $job)
    {
        // Logic to show form for editing an existing job

        return view('jobs.edit', ['job' => $job]);
    }
    public function update(Job $job)
    {
        // Logic to update an existing job in the database
        // authorize (On hold...)

        // validate
        request()->validate([
            'title' => 'required',
            'salary' => 'required|numeric|max:1000000|min:20000'
        ]);

        // Update the job and persist

        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        // redirect to the job page
        return redirect('/jobs/' . $job->id);
    }
    public function destroy(Job $job)
    {
        // Logic to delete a job from the database
        // authorize (On hold...)
        // Delete the job
        $job->delete();
        // redirect to the jobs list
        return redirect('/jobs');
    }
}
