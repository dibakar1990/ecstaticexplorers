<?php

namespace App\Http\Controllers\Api\Homestay;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeStayController extends Controller
{
    use ApiResponseTrait;

    public function index($state_id)
    {
        
        $homeStayCollection = HomeStay::with('state','location','homestay_images','homestay_facilities')
            ->where('status',1)
            ->where('state_id',$state_id)
            ->latest()
            ->get();
            $homestays = $homeStayCollection->map(function($item) {
                foreach($item->homestay_images as $row){
                    if($row->file_path != ''){
                        $row->file_path = $row->file_path_url;
                    }else{
                        $row->file_path = null;
                    }
                }
                if($item->state->file_path != ''){
                    $item->state->file_path = $item->state->file_path_url;
                }else{
                    $item->state->file_path = null;
                }
                if($item->state->trending_image != ''){
                    $item->state->trending_image = $item->state->trending_file_path_url;
                }else{
                    $item->state->trending_image = null;
                }

                foreach($item->homestay_facilities as $rowFacility){
                    if($rowFacility->file_path != ''){
                        $rowFacility->file_path = $rowFacility->file_path_url;
                    }else{
                        $rowFacility->file_path = null;
                    }
                }
                return $item;
            });
        
        return $this->sendSuccessResponse($homestays,'success');
    }

    public function location_wise_homestay($location_id)
    {
        
        $homeStayCollection = HomeStay::with('state','location','homestay_images','homestay_facilities')
            ->where('status',1)
            ->where('location_id',$location_id)
            ->latest()
            ->get();
        $homeStays = $homeStayCollection->map(function($item) {
            foreach($item->homestay_images as $row){
                if($row->file_path != ''){
                    $row->file_path = $row->file_path_url;
                }else{
                    $row->file_path = null;
                }
            }
            if($item->state->file_path != ''){
                $item->state->file_path = $item->state->file_path_url;
            }else{
                $item->state->file_path = null;
            }
            if($item->state->trending_image != ''){
                $item->state->trending_image = $item->state->trending_file_path_url;
            }else{
                $item->state->trending_image = null;
            }

            foreach($item->homestay_facilities as $rowFacility){
                if($rowFacility->file_path != ''){
                    $rowFacility->file_path = $rowFacility->file_path_url;
                }else{
                    $rowFacility->file_path = null;
                }
            }
            return $item;
        });
        
        return $this->sendSuccessResponse($homeStays,'success');
    }

    public function get_location()
    {
        
        $locations = Location::with('state')
            ->where('status',1)
            ->latest()
            ->get();
        
        return $this->sendSuccessResponse($locations,'success');
    }

    public function homestay_details($id)
    {
        
        $homeStay = HomeStay::with('state','location','homestay_images','homestay_facilities')
            ->where('status',1)
            ->where('id',$id)
            ->latest()
            ->first();
        if($homeStay->state->file_path != '')
        {
            $homeStay->state->file_path = $homeStay->state->file_path_url;
        }else{
            $homeStay->state->file_path = null;
        }

        if($homeStay->state->trending_image != '')
        {
            $homeStay->state->trending_image = $homeStay->state->trending_file_path_url;
        }else{
            $homeStay->state->trending_image = null;
        }

        foreach($homeStay->homestay_images as $rowImage){
            if($rowImage->file_path != ''){
                $rowImage->file_path = $rowImage->file_path_url;
            }else{
                $rowImage->file_path = null;
            }
        }

        foreach($homeStay->homestay_facilities as $rowFacility){
            if($rowFacility->file_path != ''){
                $rowFacility->file_path = $rowFacility->file_path_url;
            }else{
                $rowFacility->file_path = null;
            }
        }
        
        return $this->sendSuccessResponse($homeStay,'success');
    }
}
