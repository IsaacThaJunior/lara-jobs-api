<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TechJob>
 */
class TechJobFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    // Get an employer from the database or create a new one.
    // This ensures the job is always associated with an employer.
    $employer = User::where('role', 'employer')->inRandomOrder()->first() ?? User::factory()->employer()->create();

    // Define a list of common job types for variety.
    $jobTypes = ['full-time', 'part-time', 'contract', 'freelance'];
    return [
      // The employer_id links the job to the employer user.
      'employer_id' => $employer->id,
      'title' => fake()->jobTitle(),
      'location' => fake()->city(),
      'description' => fake()->paragraph(5),
      'type' => fake()->randomElement($jobTypes),
      // Generate a random salary range.
      'salary_min' => fake()->numberBetween(30000, 70000),
      'salary_max' => fake()->numberBetween(80000, 150000),

    ];
  }
}
