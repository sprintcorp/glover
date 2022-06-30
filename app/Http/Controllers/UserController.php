<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $userInterface){
        $this->user = $userInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->user->fetch();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        return $this->user->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        return $this->user->update($user, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        return $this->user->delete($user);
    }

    public function approve(Approval $approval)
    {
        return $this->user->approve($approval);
    }

    public function decline(Approval $approval)
    {
        return $this->user->decline($approval);
    }
}
