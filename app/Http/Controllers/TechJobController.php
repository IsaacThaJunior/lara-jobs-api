<?php

namespace App\Http\Controllers;

use App\Http\Filters\EmployerFilter;
use App\Http\Filters\LocationFilter;
use App\Http\Filters\TypeFilter;
use App\Http\Resources\JobResource;
use App\Http\Traits\AppliesFilters;
use App\Models\TechJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TechJobController extends Controller
{
  use AppliesFilters;
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    // Start with the base query, eagerly loading the employer relationship
    $query = TechJob::with('employer');

    // Apply filters
    $query = $this->applyFilters($query, $request, [
      'location' => LocationFilter::class,
      'type' => TypeFilter::class,
      'employer_id' => EmployerFilter::class,
    ]);

    // Execute the query and return the resource collection
    return JobResource::collection($query->latest()->paginate());
  }



  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    if (! $request->user()->can('create', TechJob::class)) {
      abort(403, 'User does not have the permission to perform this action');
    }

    $validated = Validator::make($request->all(), [
      'title' => ['required', 'string'],
      'description' => ['required', 'string',],
      'location' => ['required', 'string'],
      'type' => ['required', Rule::in(['full-time', 'part-time', 'contract', 'freelance'])],
      'salary_min' => ['required', 'string'],
      'salary_max' => ['required', 'string'],
    ]);

    if ($validated->fails()) {
      return response()->json($validated->errors(), 403);
    };

    $job = TechJob::create([
      'title' => $request->title,
      'description' => $request->description,
      'location' => $request->location,
      'type' => $request->type,
      'salary_min' => $request->salary_min,
      'salary_max' => $request->salary_max,
      'employer_id' => $request->user()->id,
    ]);

    return response()->json(['message' => 'Job added successfully', 'job' => $job, 'user' => $request->user()], 200);
  }

  /**
   * Display the specified resource.
   */
  public function show(TechJob $id)
  {
    return $id;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, TechJob $id)
  {

    $job = $id;

    if (! $request->user()->can('update', $job)) {
      abort(403, 'User does not have the permission to perform this action');
    }


    $request->validate([
      'title' => ['sometimes', 'string'],
      'description' => ['sometimes', 'string',],
      'location' => ['sometimes', 'string'],
      'type' => ['sometimes', Rule::in(['full-time', 'part-time', 'contract', 'freelance'])],
      'salary_min' => ['sometimes', 'string'],
      'salary_max' => ['sometimes', 'string'],
    ]);


    $job->update($request->all());

    return response()->json(['message' => 'Job updated successfully', 'job' => $job, 'user' => $request->user()], 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, TechJob $id)
  {
    $job = $id;

    if (! $request->user()->can('delete', $job)) {
      abort(403, 'User does not have the permission to perform this action');
    }

    $job->delete();

    return response()->json(['message' => 'Job deleted successfully'], 200);
  }
}
