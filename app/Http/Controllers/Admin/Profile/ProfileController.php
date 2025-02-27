<?php

namespace App\Http\Controllers\Admin\Profile;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\ResponseTrait;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ResponseTrait;
    public $fileService;
    public $user;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->user = Auth::guard('admin')->user();
    }

    public function index()
    {
        $user = $this->user;
        return view('admin.profile.index',compact(
            'user'
        ));
    }

    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' .$id. ',id',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/'
        ]);

        $filename = User::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/avatar');
            
        }else{
            $file_path = $filename;
        }

        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->file_path = $file_path;
        $user->save();
        $redirect = route('admin.profile.index');
        return $this->success($redirect, 'Profile updated successfully');
    }

    public function change_password()
    {
        $id = $this->user->id;
        return view('admin.profile.password',compact(
            'id'
        ));
    }

    public function update_password(Request $request, $id)
    {
        $request->validate([
            'currentPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->newPassword);
        $user->save();
        $redirect = route('admin.change.password');
        return $this->success($redirect, 'Profile password updated successfully');
    }

    public function theme_style_store(Request $request)
    {
        
        $themeStyle = Setting::first();
        if($themeStyle){
            $themeStyle->theme_style = $request->value;
            $themeStyle->save();
        }
        return response()->json(['success'=>'Theme style store successfully.','result'=>$themeStyle]);
       
    }
}
