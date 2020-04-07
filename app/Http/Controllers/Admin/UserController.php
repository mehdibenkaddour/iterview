<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id')->get();

        return View('admin.users.index')->with('users',$users);
    }

    public function edit(Request $request,$id){
        $user = User::findOrFail($id);

        return view('admin.users.edit')->with('user',$user);
    }

    public function update(Request $request,$id){
        $user=User::find($id);

        $user->name= $request->input('username');
        $user->email=$request->input('email');
        $user->role=$request->input('usertype');

        $user->update();

        return redirect('/users')->with('status','Your user is updated');
    }

    public function delete(Request $request,$id){
        $user=User::findOrFail($id);

        $user->delete();

        return redirect('/users')->with('status','User has been removed with success !');
    }
}
