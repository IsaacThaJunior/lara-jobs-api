<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('job_applications', function (Blueprint $table) {
      $table->id();

      $table->foreignId('tech_job_id')->constrained('tech_jobs')->cascadeOnDelete();

      // The ID of the user (job seeker) applying
      // Assuming your users table holds both seekers and employers
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

      $table->unique(['tech_job_id', 'user_id']);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('job_applications');
  }
};
