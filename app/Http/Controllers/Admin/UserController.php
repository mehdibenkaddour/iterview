<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id')->paginate(8);
        return View('admin.users.index')->with('users',$users);
    }

    // public function edit(Request $request,$id){
    //     $user = User::findOrFail($id);

    //     return view('admin.users.edit')->with('user',$user);
    // }

    public function update(Request $request, $id){
        $user=User::findOrfail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $user->name= $request->input('name');
        $user->email=$request->input('email');
        $user->role=$request->input('usertype');

        $user->update();

        return redirect('users')->with('status','User has been updated with success');
    }

    public function destroy(Request $request,$id){
        $user=User::findOrFail($id);

        $user->delete();

        return redirect('users')->with('status','User has been removed with success');
    }
}
