<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiResponseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function register(Request $request)
    {
        logger($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email','unique:users', 'max:50'],
            // 'email' => 'required','email','unique:users',
            'password' => ['required', 'string', 'min:8'],
            // 'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if($input['login_status'] == 1)
        {
            $user->roles()->attach(1);
        }
        elseif($input['login_status'] == 2)
        {
            $user->roles()->attach(2);
        }
        $role_user = DB::table('role_user')->where('user_id',$user->id)->first();
        $role = Role::find($role_user->role_id);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['user_id'] = $user->id;
        $success['role'] = $role->name;
        return $this->sendResponse($success, 'User register successfully.');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $role_user = DB::table('role_user')->where('user_id',$user->id)->first();
            $role = Role::find($role_user->role_id);
            if($request->status == 1)
            {
                if($role->name == 'admin')
                {
                    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                    $success['name'] =  $user->name;
                    $success['user_id'] = $user->id;
                    $success['role'] = $role->name;

                    return $this->sendResponse($success, 'User login successfully.');
                }
                else
                {
                    return $this->sendError('TypeError', ['error'=>'Login Fail Not Admin Account!']);
                }
            }
            elseif($request->status == 2)
            {
                if($role->name == 'seller')
                {
                    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                    $success['name'] =  $user->name;
                    $success['user_id'] = $user->id;
                    $success['role'] = $role->name;

                    return $this->sendResponse($success, 'User login successfully.');
                }
                else
                {
                    return $this->sendError('TypeError', ['error'=>'Login Fail Not Seller Account!']);
                }
            }
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $success['role'] = $request->user_role;
        return $this->sendResponse($success, 'Logout successfully.');
    }
}
