<?php


namespace App\Http\Repositories;


use App\Events\UserActionEvent;
use App\Http\Interfaces\UserInterface;
use App\Http\Traits\ApiResponse;
use App\Models\User;

class UserRepository implements UserInterface
{
    use ApiResponse;

    public function create($data)
    {
        try {
            $email = User::where('id','!=',auth()->user()->id)->where('role','admin')->first();
            $user = User::create($data);
            event(new UserActionEvent($user, $email->email,'Action needed for user creation'));
        }catch(\Exception $exp) {
            return $this->errorResponse($exp->getMessage(),400);
        }
    }

    public function fetch()
    {

    }

    public function update(User $user, $data)
    {

    }

    public function delete(User $user)
    {

    }
}
