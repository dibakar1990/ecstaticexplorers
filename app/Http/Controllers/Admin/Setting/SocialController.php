<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaLink;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SocialMediaLink::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.socials.edit',['social' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.socials.destroy',['social' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Social Link Confirmation\')"><i class="bx bxs-trash"></i></a>
                    </div>';
                    return $actionButton;
                })
                
                ->addColumn('status', function ($row) {
                    if($row->status == 1){
                        $itemStatus = '<div class="form-check form-switch form-check-success" id="check_id_'.$row->id.'">
                        <input class="form-check-input changeStatus" type="checkbox" data-value="0" data-id="'.$row->id.'" role="switch" id="flexSwitchCheckSuccess_'.$row->id.'" checked>
                        <label class="form-check-label" for="flexSwitchCheckSuccess_'.$row->id.'"></label>
                      </div>';
                    }
                    if($row->status == 0){
                        $itemStatus = '<div class="form-check form-switch form-check-danger" id="check_id_'.$row->id.'">
                        <input class="form-check-input changeStatus" type="checkbox" data-value="1" data-id="'.$row->id.'" role="switch" id="flexSwitchCheckSuccess_'.$row->id.'" checked>
                        <label class="form-check-label" for="flexSwitchCheckSuccess_'.$row->id.'"></label>
                      </div>';
                    }
                    
                    return $itemStatus;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request['status'] == '1' || $request['status'] == '0') {
                        $instance->where('status', $request['status']);
                    }
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('link', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','status'])
            ->toJson();
        }
        return view('admin.setting.social.index');
    }

    public function create()
    {
        return view('admin.setting.social.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required'
        ]);

        $social = new SocialMediaLink();
        $social->name = $request->name;
        $social->slug = Str::slug($request->name);
        $social->link = $request->link;
        $social->save();
        $redirect = route('admin.socials.index');
        return $this->success($redirect, 'Social Media Link Created successfully');
    }

    public function edit(string $id)
    {
        $social_id = Crypt::decrypt($id);
        $item = SocialMediaLink::findOrFail($social_id);
        return view('admin.setting.social.edit',compact(
            'item'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required'
        ]);
        $social = SocialMediaLink::findOrFail($id);
        $social->name = $request->name;
        $social->link = $request->link;
        $social->save();
        $redirect = route('admin.socials.index');
        return $this->success($redirect, 'Social Media Link updated successfully');
    }

    public function destroy(string $id)
    {
        SocialMediaLink::destroy($id);
        $redirect = route('admin.socials.index');
        return $this->success($redirect, 'Social Media Link deleted successfully');
    }

    public function status(Request $request)
    {
        $response = SocialMediaLink::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Social Media Link status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }
}
