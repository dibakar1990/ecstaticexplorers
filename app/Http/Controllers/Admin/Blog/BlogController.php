<?php

namespace App\Http\Controllers\Admin\Blog;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Tag;
use App\ResponseTrait;
use App\View\Components\admin\status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
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
            $data = Blog::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $showUrl = route('admin.blogs.show',['blog' => Crypt::encrypt($row->id) ]);
                    $editUrl = route('admin.blogs.edit',['blog' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.blogs.destroy',['blog' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$showUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bx-show"></i></a>&nbsp;
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Blog Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                ->addColumn('publish_at', function ($row) {
                   
                    return $row->published_at;
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
                            $w->orWhere('title', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','file_path_url','publish_at','status'])
            ->toJson();
        }
        return view('admin.blog.index');
    }

    public function create()
    {
        $tags = Tag::where('status',1)->orderBy('name','asc')->get();
        $categories = BlogCategory::where('status',1)->orderBy('name','asc')->get();
        return view('admin.blog.create',compact(
            'tags',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'blog_category_id' => 'required',
            'tag_id' => 'required',
            'description' => 'required',
            'file' => 'required'
        ]); 

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/blogs');
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->text = $request->text; 
        $blog->description = $request->description;
        $blog->file_path = $file_path;
        $blog->created_by = Auth::guard('admin')->user()->id;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->save();
        if($request->tag_id){
            foreach($request->tag_id as $tag){
                $blogTag = new BlogTag();
                $blogTag->blog_id = $blog->id;
                $blogTag->tag_id = $tag;
                $blogTag->save();
            }
        }
        $redirect = route('admin.blogs.index');
        return $this->success($redirect, 'Blog Created successfully');
    }

    public function show(string $id)
    {
        $blog_id = Crypt::decrypt($id);
        $item = Blog::with('user','blog_tags','blog_category')->findOrFail($blog_id);
        return view('admin.blog.show',compact(
            'item'
        ));
    }

    public function edit(string $id)
    {
        $blog_id = Crypt::decrypt($id);
        $item = Blog::with('user','blog_tags','blog_category')->findOrFail($blog_id);
        $tags = Tag::where('status',1)->orderBy('name','asc')->get();
        $categories = BlogCategory::where('status',1)->orderBy('name','asc')->get();
        return view('admin.blog.edit',compact(
            'item',
            'tags',
            'categories'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required', 
            'blog_category_id' => 'required',
            'tag_id' => 'required',
            'description' => 'required'
        ]);

        $filename = Blog::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/blogs');
            
        }else{
            $file_path = $filename;
        }

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->text = $request->text; 
        $blog->description = $request->description;
        $blog->file_path = $file_path;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->save();
        if($request->tag_id){
            BlogTag::where('blog_id',$id)->delete();
            foreach($request->tag_id as $tag){
               
                $blogTag = new BlogTag();
                $blogTag->blog_id = $id;
                $blogTag->tag_id = $tag;
                $blogTag->save();
            }
        }
        $redirect = route('admin.blogs.index');
        return $this->success($redirect, 'Blog updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = Blog::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        Blog::destroy($id);
        $redirect = route('admin.blogs.index');
        return $this->success($redirect, 'Blog deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Blog::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Blog status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $blog = Blog::findOrFail($id);
                $blog->delete();
            }
            $redirect = route('admin.blogs.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Blog deleted successfully','status' => true]);
        }
    }
}
