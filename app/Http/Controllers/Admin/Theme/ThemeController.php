<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Theme::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.tag.edit',['tag' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.tag.destroy',['tag' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Tag Confirmation\')"><i class="bx bxs-trash"></i></a>
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
            ->rawColumns(['action','checkbox','status'])
            ->toJson();
        }
        return view('admin.theme.index');
    }

    public function create()
    {
        return view('admin.theme.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:themes,name'
        ]);

        $theme = new Theme();
        $theme->name = $request->name;
        $theme->slug = Str::slug($request->name,'-');
        $theme->save();
        $redirect = route('admin.tag.index');
        return $this->success($redirect, 'Pakage tag created successfully');
    }

    public function edit(string $id)
    {
        $theme_id = Crypt::decrypt($id);
        $item = Theme::findOrFail($theme_id);
        return view('admin.theme.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:themes,name,' .$id. ',id'
        ]);

        $theme = Theme::findOrFail($id);
        $theme->name = $request->name;
        $theme->save();
        $redirect = route('admin.tag.index');
        return $this->success($redirect, 'Pakage tag updated successfully');
    }

    public function destroy(string $id)
    {
        Theme::destroy($id);
        $redirect = route('admin.tag.index');
        return $this->success($redirect, 'Pakage tag deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Theme::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Pakage tag status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $theme = Theme::findOrFail($id);
                $theme->delete();
            }
            $redirect = route('admin.tag.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Pakage tag deleted successfully','status' => true]);
        }
    }
}
