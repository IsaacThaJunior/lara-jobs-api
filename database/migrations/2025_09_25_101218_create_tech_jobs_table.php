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
    Schema::create('tech_jobs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('employer_id')->constrained('users')->cascadeOnDelete();
      $table->string('title');
      $table->string('location');
      $table->text('description');
      $table->string('type')->default('full-time');
      $table->unsignedBigInteger('salary_min')->nullable();
      $table->unsignedBigInteger('salary_max')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tech_jobs');
  }
};
