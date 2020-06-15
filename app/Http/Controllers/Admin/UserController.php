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
            <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <button
                data-id="' . $user->id . '"
                class="edit dropdown-item">Modifier</button>
                <button
                data-id="' . $user->id .'"
                class="delete dropdown-item">Supprimer</button>
                </div>
            </div>';
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
