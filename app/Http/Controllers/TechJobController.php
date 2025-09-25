<?php

namespace App\Http\Controllers;

use App\Models\TechJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TechJobController extends Controller
{
  public function index()
  {
    return TechJob::with('employer')->latest()->get();
  }

  public function addNewJob(Request $request)
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
}
