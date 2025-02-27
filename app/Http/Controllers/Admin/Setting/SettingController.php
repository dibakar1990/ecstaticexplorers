<?php

namespace App\Http\Controllers\Admin\Setting;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.application-setting.index',compact(
            'setting'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'whatsapp_number' => 'required',
            'location' => 'required',

        ]);

        $filename= Setting::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/logo');
           
        }else{
            $file_path = $filename;
        }

        $filenameFav = Setting::where('id',$id)->value('file_path_fav_icon');
        if ($request->hasFile('fav_file')) {
            if($filenameFav!='') {
                if(Storage::exists($filenameFav)){
                    Storage::delete($filenameFav);
                }
            }

            $uploaded_file = $request->file('fav_file');
            $file_path_favicon = $this->fileService->store($uploaded_file, '/logo');
           
        }else{
            $file_path_favicon = $filenameFav;
        }
        
        $setting =  Setting::findOrFail($id);
        $setting->app_title = $request->name;
        $setting->email = $request->email;
        $setting->mobile = $request->mobile;
        $setting->whatsapp_number = $request->whatsapp_number;
        $setting->location = $request->location;
        $setting->file_path = $file_path;
        $setting->file_path_fav_icon = $file_path_favicon;
        $setting->save();
        
        $redirect = route('admin.application.setting.index');
        return $this->success($redirect, 'Application setting updated successfully');
    }
}
