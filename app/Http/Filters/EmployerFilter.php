<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class EmployerFilter
{
  /**
   * Apply the employer_id filter to the query.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param mixed $value (The employer_id from the request)
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function handle(Builder $query, $value): Builder
  {
    return $query->where('employer_id', $value);
  }
}
