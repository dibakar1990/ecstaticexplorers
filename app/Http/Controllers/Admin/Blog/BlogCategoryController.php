<?php

namespace App\Http\Controllers\Admin\Blog;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
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
            $data = BlogCategory::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.category.edit',['category' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.category.destroy',['category' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Blog Category Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                            $w->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','status'])
            ->toJson();
        }
        return view('admin.blog.category.index');
    }

    public function create()
    {
        return view('admin.blog.category.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:blog_categories,name',
            'file' => 'required|image'
        ]);

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/category');
        }
        
        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name,'-');
        $category->file_path = $file_path;
        $category->save();
        $redirect = route('admin.category.index');
        return $this->success($redirect, 'Blog category Created successfully');
    }

    public function edit(string $id)
    {
        $blog_category_id = Crypt::decrypt($id);
        $item = BlogCategory::findOrFail($blog_category_id);
        return view('admin.blog.category.edit',compact(
            'item',
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name,'.$id.',id'
        ]);

        $filename = BlogCategory::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/category');
            
        }else{
            $file_path = $filename;
        }

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->file_path = $file_path;
        $category->save();
        $redirect = route('admin.category.index');
        return $this->success($redirect, 'Blog category updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = BlogCategory::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        BlogCategory::destroy($id);
        $redirect = route('admin.category.index');
        return $this->success($redirect, 'Blog category deleted successfully');
    }

    public function status(Request $request)
    {
        $response = BlogCategory::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Blog category status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $blog = BlogCategory::findOrFail($id);
                $blog->delete();
            }
            $redirect = route('admin.category.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Blog category deleted successfully','status' => true]);
        }
    }
}
