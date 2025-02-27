<?php

namespace App\Http\Controllers\Admin\CMS;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PageController extends Controller
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
            $data = Page::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.pages.edit',['page' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.pages.destroy',['page' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Page Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                            $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox'])
            ->toJson();
        }
        return view('admin.page.index');
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:pages,name',
            'description' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/page');
        }else{
            $file_path = null;
        }
        
        $page = new Page();
        $page->name = $request->name;
        $page->slug = Str::slug($request->name,'-');
        $page->description = $request->description;
        $page->file_path = $file_path;
        $page->save();
        $redirect = route('admin.pages.index');
        return $this->success($redirect, 'Page Created successfully');
    }

    public function edit(string $id)
    {
        $page_id = Crypt::decrypt($id);
        $item = Page::findOrFail($page_id);
        return view('admin.page.edit',compact(
            'item',
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:pages,name,'.$id.',id',
            'description' => 'required'
        ]);

        $filename = Page::where('id',$id)->value('file_path');
        if ($request->hasFile('file')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/page');
            
        }else{
            $file_path = $filename;
        }

        $page = Page::findOrFail($id);
        $page->name = $request->name;
        $page->description = $request->description;
        $page->file_path = $file_path;
        $page->save();
        $redirect = route('admin.pages.index');
        return $this->success($redirect, 'Page updated successfully');
    }

    public function destroy(string $id)
    {
        $filename = Page::where('id',$id)->value('file_path');
        if($filename!='') {
            if(Storage::exists($filename)){
                Storage::delete($filename);
            }
        }
        Page::destroy($id);
        $redirect = route('admin.pages.index');
        return $this->success($redirect, 'Page deleted successfully');
    }

    
    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $state = Page::findOrFail($id);
                $state->delete();
            }
            $redirect = route('admin.pages.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Page deleted successfully','status' => true]);
        }
    }
}
