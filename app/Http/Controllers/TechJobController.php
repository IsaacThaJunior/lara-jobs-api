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
    $query = TechJob::with('employer');

    // Apply filters
    $query = $this->applyFilters($query, $request, [
      'location' => LocationFilter::class,
      'type' => TypeFilter::class,
      'employer_id' => EmployerFilter::class,
    ]);

    return JobResource::collection($query->latest()->paginate(3));
  }



  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {}

  /**
   * Display the specified resource.
   */
  public function show(TechJob $id)
  {
    return new JobResource($id);
  }

  /**
   * Update the specified resource in storage.
   */
 

  /**
   * Remove the specified resource from storage.
   */
  
}
