<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\AuthInterface;
use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    use ApiResponse;

    public function login($data)
    {

        if (!$token = auth()->attempt($data)) {
            return $this->errorResponse('Invalid login credentials', 401);
        }
        return $this->createNewToken($token);
    }

    public function register($data)
    {
        $data['role'] = 'admin';
        $user = User::create($data);
        return $this->showModel($user,201);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
}
