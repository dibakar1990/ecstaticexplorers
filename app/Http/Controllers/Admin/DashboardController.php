<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\Pakage;
use App\Models\State;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
 
class DashboardController extends Controller
{
    public function index()
    {
        $dataCount = [];
        $pakageCount =  Pakage::where('status',1)->count();
        $stateCount = State::where('status',1)->count();
        $cityCount = City::where('status',1)->count();
        $contatCount = ContactUs::count();
        $blogCount = Blog::where('status',1)->count();
        $quoteCount = 0;
        $dataCount = [ 
            'pakageCount' => $pakageCount,
            'stateCount' => $stateCount,
            'cityCount' => $cityCount,
            'contatCount' => $contatCount,
            'blogCount' => $blogCount,
            'quoteCount' => $quoteCount
        ];
        $contacts = ContactUs::limit(10)->latest()->get();
        return view('admin.dashboard.index',compact(
            'dataCount',
            'contacts'
        ));
    }
    
    public function users()
    {
        $users = User::where('is_super_admin', 0)->latest()->get(); 
        return view('admin.user.index', compact('users'));  
    }
    
    public function userAdd()
    {
        return view('admin.user.add');  
    }
    
    public function userAddPost(Request $request)
    { 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:8', 
            'confirm_password' => 'required_with:password|same:password|min:8'   
        ]);  
        $user = new User(); 
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);  
        $user->save(); 
        return redirect('admin/users'); 
    }    
    
    public function userUpdate($id)
    {
        $id = decrypt($id); 
        $user = User::find($id); 
        return view('admin.user.update', compact('user'));  
    } 
    
    public function userUpdatePost(Request $request, $id)
    { 
        $id = decrypt($id); 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,    
        ]);    
        $user = User::find($id);  
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;  
        $user->save();  
        return redirect('admin/users'); 
    }   
    
    public function userDelete($id)
    {
        $id = decrypt($id); 
        $user = User::find($id); 
        $user->delete();  
        return redirect('admin/users'); 
    }  
    
    public function quotes()
    {
        $quotes = Quote::latest()->get();  
        return view('admin.quote.index', compact('quotes'));  
    }  
    
    public function quoteAdd()
    {
        return view('admin.quote.add');  
    } 
    
    public function quoteAddPost(Request $request)
    {  
        $quote = new Quote(); 
        $quote->invoice_number = $request->invoice_number;
        $quote->place_of_supply = $request->place_of_supply;
        $quote->transaction_category = $request->transaction_category;
        $quote->date = $request->date;
        $quote->transaction_type = $request->transaction_type;
        $quote->document_type = $request->document_type;
        $quote->location = $request->location;
        $quote->customer_name = $request->customer_name;
        $quote->travel_date = $request->travel_date;
        $quote->customer_contact_number = $request->customer_contact_number;
        $quote->total_pax = $request->total_pax;
        $quote->number_of_adult = $request->number_of_adult;
        $quote->number_of_children = $request->number_of_children;
        $quote->number_of_infant = $request->number_of_infant;
        $quote->pick_up_point = $request->pick_up_point;
        $quote->drop_point = $request->drop_point;
        $quote->transportation = $request->transportation;
        $quote->no_of_room = $request->no_of_room;
        $quote->meal_plan = $request->meal_plan;
        $quote->accommodation = $request->accommodation;
        $quote->cost_breakup = $request->cost_breakup;
        $quote->itinerary = $request->itinerary;
        $quote->package_inclusion = $request->package_inclusion;
        $quote->package_exclusion = $request->package_exclusion;
        $quote->mode_of_payment = $request->mode_of_payment;
        $quote->term_condition = $request->term_condition;
        $quote->cancellation_policy = $request->cancellation_policy;
        $quote->save();  
        return redirect('admin/quotes'); 
    } 
    
    public function quoteUpdate($id)
    {
        $id = decrypt($id); 
        $quote = Quote::find($id); 
        return view('admin.quote.update', compact('quote'));  
    }   
    
    public function quoteUpdatePost(Request $request, $id)
    { 
        $id = decrypt($id);
        $quote = Quote::find($id); 
        $quote->invoice_number = $request->invoice_number;
        $quote->place_of_supply = $request->place_of_supply;
        $quote->transaction_category = $request->transaction_category;
        $quote->date = $request->date;
        $quote->transaction_type = $request->transaction_type;
        $quote->document_type = $request->document_type;
        $quote->location = $request->location;
        $quote->customer_name = $request->customer_name;
        $quote->travel_date = $request->travel_date;
        $quote->customer_contact_number = $request->customer_contact_number;
        $quote->total_pax = $request->total_pax;
        $quote->number_of_adult = $request->number_of_adult;
        $quote->number_of_children = $request->number_of_children;
        $quote->number_of_infant = $request->number_of_infant;
        $quote->pick_up_point = $request->pick_up_point;
        $quote->drop_point = $request->drop_point;
        $quote->transportation = $request->transportation;
        $quote->no_of_room = $request->no_of_room;
        $quote->meal_plan = $request->meal_plan;
        $quote->accommodation = $request->accommodation;
        $quote->cost_breakup = $request->cost_breakup;
        $quote->itinerary = $request->itinerary;
        $quote->package_inclusion = $request->package_inclusion;
        $quote->package_exclusion = $request->package_exclusion;
        $quote->mode_of_payment = $request->mode_of_payment;
        $quote->term_condition = $request->term_condition;
        $quote->cancellation_policy = $request->cancellation_policy;
        $quote->save();  
        return redirect('admin/quotes'); 
    }   
    
    public function quoteDelete($id)
    {
        $id = decrypt($id); 
        $quote = Quote::find($id); 
        $quote->delete();   
        return redirect('admin/quotes'); 
    }
    
    public function quoteDetail($id)
    { 
        $id = decrypt($id); 
        $quote = Quote::find($id); 
        return view('admin.quote.detail', compact('quote'));
    }  
}
