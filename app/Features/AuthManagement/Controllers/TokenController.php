<?php

namespace App\Features\AuthManagement\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Features\AuthManagement\Requests\LoginRequest;
use App\Features\SystemManagements\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    use ApiResponses;


    public function login(LoginRequest $request,$guard)
    {

        if($guard == "admin"){
        // check credentials
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return $this->badResponse(
                message: 'User not found'
            );
        }

            if (!Hash::check($request->password, $user->password) || $user->role()->name != 'admin') {
                return $this->badResponse(
                    message: 'Invalid credentials'
                );

            }
        }elseif($guard == "customer"){
            // First, try to find user with customer role
            $user = User::where('phone_code', $request->phone_code)
            ->where('phone', $request->phone)
            ->where(function ($query) {
                $query->where(
                    DB::raw('(SELECT roles.name
                              FROM roles
                              INNER JOIN user_roles ON roles.id = user_roles.role_id
                              WHERE user_roles.user_id = users.id
                              ORDER BY user_roles.created_at DESC
                              LIMIT 1)'),
                    'customer'
                );
            })
            ->first();

            if (!$user) {
                // Check if user exists without customer role
                $existingUser = User::where('phone_code', $request->phone_code)
                    ->where('phone', $request->phone)
                    ->first();

                if ($existingUser) {
                    // User exists but doesn't have customer role
                    return $this->badResponse(
                        message: 'User exists but is not authorized as customer'
                    );
                } else {
                    // Create new user
                    $user = User::create([
                        'phone_code' => $request->phone_code,
                        'phone' => $request->phone,
                        'name' => 'customer 1',
                        'password' => Hash::make('password'),
                    ]);

                    // Assign customer role to new user
                    $customerRole = \App\Features\SystemManagements\Models\Role::where('name', 'customer')->first();
                    if ($customerRole) {
                        $user->roles()->attach($customerRole->id);
                    }
                }
            }
        }

        $abilities = $user->allPermissions()->pluck('name')->toArray();

        $user->token = $user->createToken('token', $abilities)->plainTextToken;

        return $this->okResponse(
            data: $user,
            message: 'Login successful'
        );
    }

    public function logout(Request $request)
    {
        return $this->okResponse(
            data: $request->user()->currentAccessToken()->delete(),
            message: 'Logout successful'
        );
    }
}
