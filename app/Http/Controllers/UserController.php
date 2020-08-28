<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome')->with('users');
    }   

    public function store()
    {
        $users = User::paginate(20);
        return response()->json($users);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($request->id);
        $user->status = $user->status == '0' ? '1' : '0';
        $user->save();
        return response()->json(['result' => true, 'status' => $user->status]);
    }
}
