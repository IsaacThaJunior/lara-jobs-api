<?php
namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait AppliesFilters
{
  /**
   * Applies a set of filter classes to an Eloquent query builder.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query The initial query builder instance.
   * @param \Illuminate\Http\Request $request The current HTTP request instance.
   * @param array $filters An array mapping request keys to Filter class names.
   * @return \Illuminate\Database\Eloquent\Builder The filtered query builder instance.
   */
  protected function applyFilters(Builder $query, Request $request, array $filters): Builder
  {
    foreach ($filters as $param => $filterClass) {
      // Check if the query parameter is present in the request
      if ($request->has($param)) {
        // Apply the filter class, passing the current query and the parameter value
        $query = (new $filterClass())->handle($query, $request->query($param));
      }
    }

    return $query;
  }
}
