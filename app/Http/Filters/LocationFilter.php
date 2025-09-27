<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class LocationFilter
{
  public function handle(Builder $query, $value): Builder
  {
    return $query->where('location', 'like', '%' . $value . '%');
  }
}
