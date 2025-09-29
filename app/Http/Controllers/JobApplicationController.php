<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\TechJob;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, TechJob $id)
  {
    $user = $request->user();
    $job = $id;
    // First check that the user is a jobseeker (will be handled by policies)
    if ($user->cannot('apply', $job)) {
      abort(403, 'User does not have the permission to perform this action');
    }

    // 2. Attach the User to the Job using the 'applicants' relationship
    try {
      $job->applicants()->attach($user->id);
    } catch (QueryException $e) {
      if ($e->getCode() == 23000) {
        return response()->json(['message' => 'You have already applied for this job.'], 409);
      }
      throw $e;
    }

    return response()->json(['message' => 'Application submitted successfully.'], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {
    if ($request->user()->cannot('apply', TechJob::class)) {
      abort(403, 'User Isnt a Job Seeker');
    }
    // Get all the jobs that the user has applied for
    $jobs = $request->user()->appliedJobs()->paginate();

    return JobResource::collection($jobs);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
