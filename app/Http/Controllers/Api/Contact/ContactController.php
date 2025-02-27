<?php

namespace App\Http\Controllers\Api\Contact;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Mail\ContactUsMail;
use App\Models\ContactUs;
use App\Models\NewsLetter;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }

        $contact = new ContactUs();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        $setting = Setting::find(1);
        $request_sent = [
            'file_path' => $setting->file_path,
            'file_url' => $setting->file_path_url,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'message' => $contact->message,
        ];
        Mail::to($setting->email)->send(new ContactUsMail($request_sent));
        $data_sent = [
            'file_path' => $setting->file_path,
            'file_url' => $setting->file_path_url,
            'name' => $contact->name,
            'app_title' => $setting->app_title
        ];
        Mail::to($contact->email)->send(new ContactMail($data_sent));
        
        return $this->sendSuccessResponse('','Contact query has been submitted successfully');
    }

    public function news_letter_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }

        $newsletter = new NewsLetter();
        $newsletter->email = $request->email;
        $newsletter->save();
        return $this->sendSuccessResponse('','Newsletter submitted successfully');
    }
}
