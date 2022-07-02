<?php


namespace App\Http\Repositories;


use App\Events\UserActionEvent;
use App\Http\Interfaces\UserInterface;
use App\Http\Resources\UserRequestResource;
use App\Http\Traits\ApiResponse;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    use ApiResponse;

    public function create($data)
    {
        return $this->createApproval('User created successfully and awaiting approval',
            'Action needed for user creation','create');
    }

    public function update(User $user, $data)
    {
        return $this->createApproval('User update logged and awaiting approval',
            'Action needed for user update','update');
    }

    public function delete(User $user)
    {
        return $this->createApproval('User delete logged and awaiting approval',
            'Action needed for deleting user','delete');
    }

    public function fetch()
    {
        $approval = Approval::where('approved_at',NULL)->get();
        return $this->showAll(UserRequestResource::collection($approval));
    }


    public function approve(Approval $approval)
    {
        if($approval->created_by != auth()->user()->id){
            if ($approval->approved_at){
                return $this->errorResponse('Request does not exist',404);
            }
            try {
                DB::beginTransaction();
                $data = unserialize($approval->data);
                switch ($approval->action){
                    case('create'):
                        $data['password'] = Hash::make($data['password']);
                        $user = $approval->model_type::create($data);
                        $approval::updateApproval($user->id);
                        $message = 'User creation approved';
                        break;
                    case('update'):
                        $approval->user->update($data);
                        $approval::updateApproval($approval->user->id);
                        $message = 'User update approved';
                        break;
                    case('delete'):
                        $approval->user->delete();
                        $message = 'User deletion approved';
                        break;
                    default:
                        $message = 'Request approved successfully';
                }
                DB::commit();
                return $this->showMessage($message);
            }catch(\Exception $exp) {
                DB::rollBack();
                return $this->errorResponse($exp->getMessage(),400);
            }
        }
        return $this->errorResponse('You cannot approve request you created',400);
    }

    public function decline(Approval $approval)
    {
        if($approval->created_by != auth()->user()->id){
            $approval->delete();
            return $this->showMessage('Request declined successfully');
        }
        return $this->errorResponse('You cannot decline request you created',400);
    }

    private function createApproval($message, $subject,$action)
    {
        try {
            $email = User::where('id','!=',auth()->user()->id)->where('role','admin')->first()->email;
            request()->action = $action;
            request()->model = 'App\Models\User';
            $approval = Approval::create();
            event(new UserActionEvent($approval, $email,$subject));
            return $this->successResponse(
                $message,
                201);
        }catch(\Exception $exp) {
            return $this->errorResponse($exp->getMessage(),400);
        }
    }
}
