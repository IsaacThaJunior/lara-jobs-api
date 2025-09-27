<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TypeFilter
{
  public function handle(Builder $query, $value): Builder
  {
    return $query->where('type', $value);
  }
}
