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

            if (!Hash::check($request->password, $user->password) || $user->role != 'admin') {
                return $this->badResponse(
                    message: 'Invalid credentials'
                );

            }
        }elseif($guard == "customer"){
            // First, try to find user with customer role
            $user = User::where('phone_code', $request->phone_code)
            ->where('phone', $request->phone)
            ->where('role', 'customer')
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
                        'role' => 'customer',
                        'password' => Hash::make('password'),
                    ]);
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
