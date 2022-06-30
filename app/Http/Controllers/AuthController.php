<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\AuthInterface;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthInterface $authInterface){
        $this->auth = $authInterface;
    }

    public function login(AuthRequest $request){
        return $this->auth->login($request->all());
    }

    public function register(AuthRequest $request){
        return $this->auth->register($request->all());
    }
}
