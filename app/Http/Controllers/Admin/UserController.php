<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function index(){
        // no need to pass users only return the view
        return View('admin.users.index');
    }

    /**
     * This method is for ajax only
     */
    public function ajaxUsers() {
        return Datatables::of(User::query())

        // add actions collumn
        ->addColumn('actions', function (User $user) {
            return '
            <button
                data-id="' . $user->id . '"
                class="btn btn-success btn-sm edit">Edit</button>
            <button
                data-id="' . $user->id .'"
                class="btn btn-danger btn-sm delete">Delete</button>';
        })
        
        // to interpret html and not considering it as text
        ->rawColumns(['actions'])

        ->toJson();
    }

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

        return response()->json(['alert' => 'User has been updated with success']);
    }

    public function destroy(Request $request,$id){
        $user=User::findOrFail($id);

        $user->delete();

        return redirect('users')->with('status','User has been removed with success');
    }
}
