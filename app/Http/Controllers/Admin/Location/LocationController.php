<?php

namespace App\Http\Controllers\Admin\Location;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\State;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class LocationController extends Controller
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
            $data = Location::select('*');
            return DataTables::of($data)
                ->setRowId('id') 
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.locations.edit',['location' => Crypt::encrypt($row->id) ]);
                    $deleteUrl = route('admin.locations.destroy',['location' => $row->id]);
                    $actionButton ='<div class="d-flex">
                        <a href="' .$editUrl. '" class="btn btn-sm btn-outline-success px-1"><i class="bx bxs-edit"></i></a>&nbsp;
                        <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure, want to delete?\', \'Delete Location Confirmation\')"><i class="bx bxs-trash"></i></a>
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
        return view('admin.location.index');
    }

    public function create()
    {
        $states = State::where('status',1)->where('is_home_stay',1)->orderBy('name','ASC')->get();
        return view('admin.location.create',compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required'
        ]);

        $location = new Location();
        $location->name = $request->name;
        $location->state_id = $request->state_id;
        $location->save();
        $redirect = route('admin.locations.index');
        return $this->success($redirect, 'LOcation Created successfully');
    }

    public function edit(string $id)
    {
        $location_id = Crypt::decrypt($id);
        $item = Location::findOrFail($location_id);
        $states = State::where('status',1)->where('is_home_stay',1)->orderBy('name','ASC')->get();
        return view('admin.location.edit',compact(
            'item',
            'states'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required'
        ]);

        

        $location = Location::findOrFail($id);
        $location->name = $request->name;
        $location->state_id = $request->state_id;
        $location->save();
        $redirect = route('admin.locations.index');
        return $this->success($redirect, 'Location updated successfully');
    }

    public function destroy(string $id)
    {
        Location::destroy($id);
        $redirect = route('admin.locations.index');
        return $this->success($redirect, 'Location deleted successfully');
    }

    public function status(Request $request)
    {
        $response = Location::findOrFail($request->id);
        $response->status = $request->status;
        $response->save();
        if($response){
            return $this->ajaxSuccess($response, 'Location status has been changed successfully');
        }else{
            return $this->ajaxError([]);
        }
    }

    public function action(Request $request)
    {
        if($request->action_value == 'is_delete'){
            foreach($request->ids as $id){
                $city = Location::findOrFail($id);
                $city->delete();
            }
            $redirect = route('admin.locations.index');
            return $this->ajaxSuccess(['response' => $redirect, 'success_msg' => 'Location deleted successfully','status' => true]);
        }
    }

    public function fetch_location(Request $request)
    {
        $cities = Location::where('status',1)->where('state_id',$request->id)->get();
        $data = view('admin.location.fetch-location',compact('cities'))->render();
        return $this->ajaxSuccess(['status' => true, 'cities' => $cities, 'response' => $data,'success_msg' => 'State wise city fetch Successfully']);
    }
}
