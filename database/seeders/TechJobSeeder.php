<?php

namespace Database\Seeders;

use App\Models\TechJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechJobSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    TechJob::factory(20)->create();
  }
}
