<?php

namespace App\Policies;

use App\Models\TechJob;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TechJobPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return false;
  }

  /**
   * Determine whether the user can view the model.
   */
  public function apply(User $user,): bool
  {
    return $user->role === 'job_seeker';
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role === 'employer';
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, TechJob $techJob): bool
  {

    return $user->role === 'employer' && $user->id === $techJob->employer_id;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, TechJob $techJob): bool
  {
    return $user->role === 'employer' && $user->id === $techJob->employer_id;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, TechJob $techJob): bool
  {
    return false;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, TechJob $techJob): bool
  {
    return false;
  }
}
