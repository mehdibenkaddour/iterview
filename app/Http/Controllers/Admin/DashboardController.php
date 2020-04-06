<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function registred(){
        $users = User::orderBy('id')->get();
        return View('admin.users-list')->with('users',$users);
    }
    public function registredEdit(Request $request,$id){
        $user = User::findOrFail($id);
        return view('admin.user-edit')->with('user',$user);
    }
    public function registredUpdate(Request $request,$id){
                $user=User::find($id);
                $user->name= $request->input('username');
                $user->email=$request->input('email');
                $user->role=$request->input('usertype');
                $user->update();
                return redirect('/users-list')->with('status','Your user is updated');

    }
    public function registredDelete(Request $request,$id){
        $user=User::findOrFail($id);
        $user->delete();
        return redirect('/users-list')->with('status','User has been removed with success !');
    }
}
