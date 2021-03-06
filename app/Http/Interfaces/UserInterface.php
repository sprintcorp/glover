<?php


namespace App\Http\Interfaces;


use App\Models\Approval;
use App\Models\User;

interface UserInterface
{
    public function create($data);
    public function fetch();
    public function update(User $user,$data);
    public function delete(User $user);
    public function approve(Approval $approval);
    public function decline(Approval $approval);
}
