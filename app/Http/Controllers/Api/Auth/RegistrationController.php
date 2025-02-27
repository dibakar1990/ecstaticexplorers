<?php

namespace App\Http\Controllers\Api\Auth;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->mobile = $request->mobile;
        $user->role = 'user';
        $user->save();
        return $this->sendSuccessResponse('','Registration successfully');

    }
}
