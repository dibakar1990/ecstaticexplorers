<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Models\CmsDont;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class DontController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $data = CmsDont::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.dont.edit',['dont' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.dont.destroy',['dont' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-primary px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Dont Confirmation\')"><i class="bx bxs-trash"></i></a>
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
                            $w->orWhere('title', 'LIKE', "%$search%");
                        });
                    }
                })
            ->rawColumns(['action','checkbox','status'])
            ->toJson();
        }
        return view('admin.cms.dont.index');
    }

    public function create()
    {
        return view('admin.cms.dont.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $dont = new CmsDont();
        $dont->title = $request->name;
        $dont->save();
        $redirect = route('admin.dont.index');
        return $this->success($redirect, 'Cms dont created successfully');
    }

    public function edit(string $id)
    {
        $dont_id = Crypt::decrypt($id);
        $item = CmsDont::findOrFail($dont_id);
        return view('admin.cms.dont.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $dont = CmsDont::findOrFail($id);
        $dont->title = $request->name;
        $dont->save();
        $redirect = route('admin.dont.index');
        return $this->success($redirect, 'Cms dont updated successfully');
    }

    public function destroy(string $id)
    {
        CmsDont::destroy($id);
        $redirect = route('admin.dont.index');
        return $this->success($redirect, 'Cms dont deleted successfully');
    }

    public function status(Request $request)
    {
        $response = CmsDont::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Cms dont status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $dont = CmsDont::findOrFail($id);
                $dont->delete();
            }
            $redirect = route('admin.dont.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Cms dont deleted successfully','status' => true]);
        }
    }
}
