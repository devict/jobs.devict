<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return view('guest.jobs.index', [
            'jobs' => Job::recent()->lastPublished()->get(),
        ]);
    }

    public function create()
    {
        return view('guest.jobs.create', [
            'job' => new Job,
        ]);
    }

    public function store(Request $request)
    {
        Job::create($request->validate([
            'position' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'url' => ['required_without:description', 'nullable', 'url', 'max:510'],
            'description' => ['required_without:url', 'nullable', 'string', 'max:5000'],
            'email' => ['required', 'email'],
        ]))->publish();

        return redirect()->route('guest.jobs.index')
            ->with('success', 'Job added.');
    }

    public function show(Job $job)
    {
        throw_if($job->isUnpublished(), new ModelNotFoundException);
        throw_if($job->isOld(), new ModelNotFoundException);

        return view('guest.jobs.show', [
            'job' => $job,
        ]);
    }

    public function edit(Job $job)
    {
        return view('guest.jobs.edit', [
            'job' => $job,
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $job->update($request->validate([
            'position' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'url' => ['required_without:description', 'nullable', 'url', 'max:510'],
            'description' => ['required_without:url', 'nullable', 'string', 'max:5000'],
            'email' => ['required', 'email'],
        ]));

        return redirect()->route('guest.jobs.index')
            ->with('success', 'Job details updated.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('guest.jobs.index')
            ->with('success', 'Job removed.');
    }
}
