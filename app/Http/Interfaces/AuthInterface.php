<?php


namespace App\Http\Interfaces;


interface AuthInterface
{
    public function login($data);
    public function register($data);
}
