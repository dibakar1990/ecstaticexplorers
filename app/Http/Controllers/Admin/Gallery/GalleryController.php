<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\State;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    use ResponseTrait;
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $states =  State::where('status',1)->orderBy('name','ASC')->get();
        if ($request->ajax()) {
             $data = Gallery::with('gallery_images','state')
                ->with('gallery_images', function($query){
                    $query->where('default_status', 1);
                });
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.galleries.edit',['gallery' => Crypt::encrypt($row->id) ]);
                   
                    $deleteUrl = route('admin.galleries.destroy',['gallery' => $row->id]);
                    $imageUrl = route('admin.gallery.image',['id' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="javascript:;" class="btn btn-sm btn-outline-success px-1 openPopup" data-action-url="'.$imageUrl.'" data-title="Gallery Images" data-bs-toggle="modal"><i class="bx bx-images"></i></a>&nbsp;
                        
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Gallery Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                    
                    if($row->gallery_images->first()->file_path != ''){
                        $file_path_url = '<img height="50px" src='. $row->gallery_images->first()->file_path_url .' id="image_preview" alt="">';
                    }else{
                        $file_path_url = '<img height="50px" src='.asset('backend/assets/images/no-image.jpg').' id="image_preview" alt="">';
                    }
                    return $file_path_url;
                })
                
                ->addColumn('state', function ($row) {
                   
                    return $row->state->name;
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
                    if ($request['state_id']) {
                        $instance->where('state_id', $request['state_id']);
                    }
                    if (!empty($request['search'])) {
                        $instance->where(function($w) use($request){
                            $search = $request['search'];
                            $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhereHas('state', function ($queryHas) use ($search) {
                                $queryHas->where('name', 'LIKE', "%{$search}%");
                            });
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','state','status'])
            ->toJson();
        }
        return view('admin.gallery.index',compact(
            'states'
        ));
    }

    public function create()
    {
        $states =  State::where('status',1)->orderBy('name','ASC')->get();
        return view('admin.gallery.create',compact(
            'states'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required',
            'title' => 'required',
            'files.*' => 'required'
        ]); 

        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->state_id = $request->state_id; 
        $gallery->save(); 

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                if($key == 0){
                    $default_status = 1;
                }else{
                    $default_status = 0;
                }
                $file_path = $this->fileService->store($file, '/gallery');
                $galleryImage = new GalleryImage();
                $galleryImage->file_path = $file_path;
                $galleryImage->gallery_id = $gallery->id;
                $galleryImage->default_status = $default_status;
                $galleryImage->save();
            }
        }
        $redirect = route('admin.galleries.index');
        return $this->success($redirect, 'Gallery Created successfully');
    }

    public function edit(string $id)
    {
        $gallery_id = Crypt::decrypt($id);
        $item = Gallery::with('gallery_images')->findOrFail($gallery_id);
        $states =  State::where('status',1)->orderBy('name','ASC')->get();
        return view('admin.gallery.edit',compact(
            'item',
            'states'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'state_id' => 'required'
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->title = $request->title;
        $gallery->state_id = $request->state_id;
        $gallery->save();

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                $file_path = $this->fileService->store($file, '/gallery');

                $galleryImage = new GalleryImage();
                $galleryImage->file_path = $file_path;
                $galleryImage->gallery_id = $id;
                $galleryImage->save();
            }
        }

        $redirect = route('admin.galleries.index');
        return $this->success($redirect, 'Gallery updated successfully');
    }

    public function destroy(string $id)
    {
        $galleryImages = GalleryImage::where('gallery_id',$id)->get();
        foreach($galleryImages as $image){
            if($image->file_path!='') {
                if(Storage::exists($image->file_path)){
                    Storage::delete($image->file_path);
                }
            }
        }
        Gallery::destroy($id);
        $redirect = route('admin.galleries.index');
        return $this->success($redirect, 'Gallery deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Gallery::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Gallery status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $galleryImages = GalleryImage::where('gallery_id',$id)->get();
                foreach($galleryImages as $image){
                    if($image->file_path!='') {
                        if(Storage::exists($image->file_path)){
                            Storage::delete($image->file_path);
                        }
                    }
                }
                $gallery = Gallery::findOrFail($id);
                $gallery->delete();
            }
            $redirect = route('admin.galleries.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Gallery deleted successfully','status' => true]);
        }
    }

    public function image(string $id)
    {
        $item = Gallery::with('gallery_images')->findOrFail($id);
        $returnHTML = view('admin.gallery.image', ['item' => $item])->render();
      
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function image_store(Request $request,string $id)
    {
        $request->validate([
            'files.*' => 'required|image'
        ]);
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach($files as $key => $file){
                $file_path = $this->fileService->store($file, '/gallery');
                $galleryImage = new GalleryImage();
                $galleryImage->file_path = $file_path;
                $galleryImage->gallery_id = $id;
                $galleryImage->save();
            }
        }

        $redirect = route('admin.galleries.index');
        return $this->success($redirect, 'Gallery image added successfully');
    }

    public function set_default_image(Request $request,string $id)
    {
       $gallery_id = $id;
       $defaultStatus = GalleryImage::where('gallery_id',$gallery_id)->where('default_status',1)->first();
       
       $defaultStatus->default_status = 0;
       $defaultStatus->save();

       $galleryImage = GalleryImage::findOrFail($request->id);
       $galleryImage->default_status = 1;
       $galleryImage->save();
       return $this->ajaxSuccess(['title' => 'Set Default!', 'success_msg' => 'Your default image has been set.','status' => true]);
    }

    public function delete_image(Request $request,string $id)
    {
       $galleryImage = GalleryImage::findOrFail($id);
       if($galleryImage->default_status == 1){
            return $this->ajaxSuccess(['title' => 'Delete Error!', 'error_msg' => 'This image can not be deleted because is a default image.','status' => false]);
       }else{
        
        if($galleryImage->file_path!='') {
            if(Storage::exists($galleryImage->file_path)){
                Storage::delete($galleryImage->file_path);
            }
        }
        GalleryImage::destroy($id);
        $galleryImages = GalleryImage::where('gallery_id',$request->gallery_id)->get();
        $html = '';
        
        foreach($galleryImages as $key => $rowImage){
            $deleteUrl = route('admin.gallery.delete.image',['id'=> $rowImage->id]);
            $setUrl = route('admin.gallery.default.image.set',['id'=> $request->gallery_id]);
            if($rowImage->default_status == 1){
                $check = 'checked';
            }else{
                $check = '';
            }
            $html .='<div class="col">
                    <img src="'.$rowImage->file_path_url.'" width="100" height="100" class="border rounded cursor-pointer" alt="">
                    <a href="javascript:;" class="delete-image" data-gallery-id="'.$request->gallery_id.'" data-action-url="'.$deleteUrl.'"><span class="icon"><i class="fas fa-trash-alt" style="color: red"></i></span></a>
                    <div class="form-check">
                        <input class="form-check-input default-image" type="radio" data-action-url="'.$setUrl.'" name="default_status" value="'.$rowImage->id.'" id="flexRadioDefault'.$rowImage->id.'" '.$check.'>
                        <label class="form-check-label" for="flexRadioDefault'.$rowImage->id.'">
                          Main Image
                        </label>
                      </div>
                </div>';
        }
        
        return $this->ajaxSuccess(['html' => $html ,'title' => 'Delete!', 'success_msg' => 'Your image has been deleted.','status' => true]);
       }

       
    }
}
