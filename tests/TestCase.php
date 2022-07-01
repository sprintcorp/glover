<?php

namespace Tests;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        return JWTAuth::fromUser($user);
    }

    public function createActionForApproval()
    {
        return Approval::factory()->create();
    }
}
