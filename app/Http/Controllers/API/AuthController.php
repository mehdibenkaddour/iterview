<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class AuthController extends ResponseController
{
    //registration
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            if($validator->errors()->first()== "The email has already been taken."){
              return $this->sendError("EMAIL EXIST");
            }      
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if($user){
            $token=$user->createToken('token');
            $success['id']= $user->id;
            $success['name']= $user->name;
            $success['email'] = $user->email;
            $success['token'] =  $token->accessToken;
            $success['expiresIn'] = "3600";
            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401); 
        }
        
    }
    
    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            if(User::where('email','=',$request->input('email'))->exists()){
                return $this->sendError("WRONG PASSWORD", 401);
            }
            else{
                return $this->sendError("WRONG EMAIL", 401);
            }
        }
        $user = $request->user();
        $token=$user->createToken('token');
        $success['id']= $user->id;
        $success['name']= $user->name;
        $success['email']= $user->email;
        $success['token'] =  $token->accessToken;
        $success['expiresIn']= "3600";
        return $this->sendResponse($success);
    }

    //logout
    public function logout(Request $request)
    {
        
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
            
        
    }

    //getuser
    /*public function getUser(Request $request)
    {
        //$id = $request->user()->id;
        $user = $request->user();
        if($user){
            return $this->sendResponse($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }*/
}
