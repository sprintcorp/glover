<?php

namespace Tests\Feature;

use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $header;

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authUser()
        ];
    }

    public function test_admin_can_create_user()
    {
        $data = [
            'firstname' => "Frederick",
            'lastname' => "Adebayo",
            'email' => "sprintcorp7+05@gmail.com",
            'password' => 'password'
        ];
       $this->postJson('/api/auth/user', $data,$this->header)
            ->assertCreated();
    }

    public function test_admin_can_update_user()
    {
        $data = [
            'firstname' => "Timi",
        ];
        $user = $this->createUser();
        $this->putJson('/api/auth/user/'.$user->id, $data,$this->header)
            ->assertCreated();
    }

    public function test_admin_can_delete_user()
    {
        $user = $this->createUser();
        $this->deleteJson('/api/auth/user/'.$user->id,[],$this->header)
            ->assertCreated();
    }

    public function test_admin_can_get_request()
    {
        $this->getJson('/api/auth/user',$this->header)
            ->assertOk();
    }

    public function test_admin_can_approve_request()
    {
        $approval = $this->createActionForApproval();
        $this->putJson('/api/auth/approve-request/'.$approval->id,[],$this->header)->assertOk();
    }

    public function test_admin_can_reject_request()
    {
        $approval = $this->createActionForApproval();
        $this->putJson('/api/auth/decline-request/'.$approval->id,[],$this->header)->assertOk();
    }
}
