<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechJob extends Model
{
  /** @use HasFactory<\Database\Factories\TechJobFactory> */
  use HasFactory;
  protected $guarded = [];


  public function employer()
  {
    return $this->belongsTo(User::class, 'employer_id');
  }

  public function applicants()
  {
    return $this->belongsToMany(User::class, 'job_applications', 'tech_job_id', 'user_id');
  }
}
