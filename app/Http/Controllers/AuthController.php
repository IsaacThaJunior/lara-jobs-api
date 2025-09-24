<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6',],
      'role' => ['required', Rule::in(['job_seeker', 'employer'])]
    ]);

    if ($validated->fails()) {
      return response()->json($validated->errors(), 403);
    };

    try {

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,

      ]);

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
        'access_token' => $token,
        'user' => $user
      ], 200);
    } catch (\Exception $exception) {
      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }
  }

  public function login(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8'],
    ]);
  }
}


