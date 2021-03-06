<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('company')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $this->validate($request, [
            'name' => 'required|string|min:3|max:200',
            'email' => 'required|email|unique:users,email',
            'company_id' => 'required|integer|exists:companies,id'
        ]);

        $user = User::create($post);

        $user->load('company');
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('company');
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $post = $this->validate($request, [
            'name' => 'required|string|min:3|max:200',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'company_id' => 'required|integer|exists:companies,id'
        ]);

        $user->update($post);

        $user->load('company');

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(true);
    }
}
