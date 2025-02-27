<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Setting;
use App\Notifications\ContactNotification;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $sendMailUrl = route('admin.contact.send.mail',['id' => $row->id ]);
                    $showUrl = route('admin.contacts.show',['contact' => $row->id ]);
                    $deleteUrl = route('admin.contacts.destroy',['contact' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="javascript:;" class="btn btn-sm btn-outline-primary px-1 openPopup" data-action-url="'.$showUrl.'" data-title="Contact Details" data-bs-toggle="modal"><i class="bx bxs-show"></i></a>&nbsp;
                        <a href="javascript:;" class="btn btn-sm btn-outline-success px-1 openPopup" data-action-url="'.$sendMailUrl.'" data-title="Send Mail '.$row->email.'" data-bs-toggle="modal"><i class="lni lni-envelope"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Contact Confirmation\')"><i class="bx bxs-trash"></i></a>
                    </div>';
                    return $actionButton;
                })
                
                ->addColumn('checkbox', function ($row) {
                    $checkbox ='<div class="form-check form-check-primary">
                        <input class="form-check-input single_check" type="checkbox" value="'.$row->id.'" name="single_check" id="single_check_"'.$row->id.'">
                        <label class="form-check-label" for="single_check_"'.$row->id.'"></label>
                    </div>';
                    return $checkbox;
                })
                ->filter(function ($instance) use ($request) {
                    
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox'])
            ->toJson();
        }
        return view('admin.contact.index');
    }

    public function show(string $id)
    {
        $item = ContactUs::findOrFail($id);
        $returnHTML = view('admin.contact.show', ['item' => $item])->render();
      
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function send_mail($id)
    {
        $item = ContactUs::findOrFail($id);
        $returnHTML = view('admin.contact.send-mail', ['item' => $item])->render();
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function bluk_mail()
    {
        $returnHTML = view('admin.contact.bluk-mail')->render();
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function store(Request $request)
    {
        $setting = Setting::where('id',1)->first();
        if($setting->file_path != ''){
            $logo = $setting->file_path_url;
        }else{
            $logo = asset('backend/assets/images/no-image.jpg');
        }
        $appName =  isset($setting->app_title) ? ($setting->app_title) : config('app.name');
        $data = [
            'subject' => $request->subject,
            'body' => $request->message,
            'thanks' => 'Thank you this is from '.$appName.' .',
            'title' => $appName,
            'logo' => $logo
            
        ];
        if($request->id){
            $users = ContactUs::whereIn('id',$request->id)->latest()->get();
        }else{
            $users = ContactUs::latest()->get();
        }
        
        Notification::route('mail', $users)->notify(new ContactNotification($data));
        $redirect = route('admin.contacts.index');
        return $this->success($redirect, 'Notification send successfully');
    }

    public function update(Request $request,$id)
    {
        $setting = Setting::where('id',1)->first();
        if($setting->file_path != ''){
            $logo = $setting->file_path_url;
        }else{
            $logo = asset('backend/assets/images/no-image.jpg');
        }
        $appName =  isset($setting->app_title) ? ($setting->app_title) : config('app.name');
        $data = [
            'subject' => $request->subject,
            'body' => $request->message,
            'thanks' => 'Thank you this is from '.$appName.' .',
            'title' => $appName,
            'logo' => $logo
            
        ];
        $contact = ContactUs::findOrFail($id);
        Notification::route('mail', $contact->email)->notify(new ContactNotification($data));
        $redirect = route('admin.contacts.index');
        return $this->success($redirect, 'Notification send successfully');
    }

    public function destroy(string $id)
    {
        ContactUs::destroy($id);
        $redirect = route('admin.contacts.index');
        return $this->success($redirect, 'Contact deleted successfully');
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $contact = ContactUs::findOrFail($id);
                $contact->delete();
            }
            $redirect = route('admin.contacts.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Contact deleted successfully','status' => true]);
        }
        if($request->action_value == 'is_send_mail'){
            $ids = $request->ids;
            $returnHTML = view('admin.contact.bluk-mail',compact('ids'))->render();
            return $this->ajaxSuccess(['response' => $returnHTML, 'is_send_mail' => true,'success' => true]);
        }
    }
}
