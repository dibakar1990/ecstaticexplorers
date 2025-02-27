<?php

namespace App\Http\Controllers\Api\Auth;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponseTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }
        $user = User::where('email',$request->email)->first();
        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('MyAppToken')->accessToken;
                return $this->sendSuccessResponse($this->respondWithUserToken($token, $user),'login successfully');
            }else{
                return $this->sendValidationErrorResponse('', 'Invalid credential');
            }
            
        }else{
            return $this->sendValidationErrorResponse('', 'Invalid credential');
        }
       
    }

    public function logout()
    {
        $token = $this->guard()->user()->token();
        $token->revoke();
        return $this->sendSuccessResponse('','logout successfully');
    }

    public function profile()
    {
        $userData = $this->guard()->user();
        return $this->sendSuccessResponse($userData,'success');
    }

    protected function respondWithUserToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'me' => $user,
            'token_type' => 'bearer'
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
