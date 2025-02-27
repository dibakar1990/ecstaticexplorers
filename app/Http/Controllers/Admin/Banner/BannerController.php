<?php

namespace App\Http\Controllers\Admin\Banner;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.banners.edit',['banner' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.banners.destroy',['banner' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Banner Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                ->addColumn('file_path_url', function ($row) {
                    if($row->file_path != ''){
                        $file_path_url = '<img height="50px" src='. $row->file_path_url .' id="image_preview" alt="">';
                    }else{
                        $file_path_url = '<img height="50px" src='.asset('backend/assets/images/no-image.jpg').' id="image_preview" alt="">';
                    }
                    return $file_path_url;
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
                            $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhere('sub_title', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','status'])
            ->toJson();
        }
        return view('admin.banner.index');
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'file' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/banners');
        }

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->file_path = $file_path;
        $banner->save();
        $redirect = route('admin.banners.index');
        return $this->success($redirect, 'Banner Created successfully');
    }

    public function edit(string $id)
    {
        $banner_id = Crypt::decrypt($id);
        $item = Banner::findOrFail($banner_id);
        return view('admin.banner.edit',compact(
            'item'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required'
        ]);

        $filename = Banner::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/banners');
            
        }else{
            $file_path = $filename;
        }

        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->file_path = $file_path;
        $banner->save();
        $redirect = route('admin.banners.index');
        return $this->success($redirect, 'Banner updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = Banner::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        Banner::destroy($id);
        $redirect = route('admin.banners.index');
        return $this->success($redirect, 'Banner deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Banner::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Banner status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $banner = Banner::findOrFail($id);
                $banner->delete();
            }
            $redirect = route('admin.banners.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Banner deleted successfully','status' => true]);
        }
    }
}
