<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use  App\models\Customer;
use  App\models\Country;
use  App\models\State;
use  App\models\City;
class CustomerController extends Controller
{
   public function index()
   {
$customers=Customer::all();
    return view('customer.customer_index',compact('customers'));

   }
   public function create()
   {
    $countries=DB::table('countries')->get();
    return view('customer.customer_add',compact('countries'));
  }


  public function edit(Request $request ,$id)
  {
      $customers=Customer::find($id);
      $countries=Country::all();
      $states = State::where('country_id', $customers->country)->get(); // Get states for the selected country
      $cities = City::where('state_id', $customers->state)->get(); // Get cities for the selected state
  
      return view('customer.edit',compact('customers','countries','states','cities')) ;


  }

public function store(Request $request)
{
    // Validate the request
    // $request->validate([
    //     'customer_name' => 'required|string|max:255',
    //     'email' => 'required|email|unique:customers',
    //     'mobile_no' => 'required|string|max:15',
    //     'address' => 'required|string|max:255',
    //     'zip_code' => 'required|string|max:10',
    //     'country' => 'required|exists:countries,id',
    //     'state' => 'required|exists:states,id',
    //     'city' => 'required|exists:cities,id',
    //     'tax_identification_no' => 'required|string|max:50',
    //     'account_type' => 'required|in:credit,debit',
    //     'opening_balance' => 'required|numeric',
    //     'document_type' => 'required|string|max:50',
    //     'document_no' => 'required|string|max:50',
    //     'date_of_birth' => 'required|date',
    //     'anniversary_date' => 'nullable|date',
    //     'credit_allowed' => 'required|boolean',
    //     'credit_limit' => 'required|numeric',
    //     'remark' => 'nullable|string',
    //     'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    // ]);

    // Handle file upload


    // Create customer
 
    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->mobile_no = $request->mobile_no;
    $customer->address = $request->address;
    $customer->zip_code = $request->zip_code;
    $customer->country = $request->country;
    $customer->state = $request->state;
    $customer->city = $request->city;
    $customer->gst_no = $request->gst_no;  
    $customer->date_of_birth = $request->date_of_birth; 
    $customer->remark = $request->remark;
    // if ($request->hasFile('avatar')) {
    //     $image = $request->file('avatar');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension(); 
    //     $image->storeAs('public/images', $imageName);
    //     $customer->avatar=$imageName;        
    // }
    // // $customer->avatar = $avatarPath;
    $customer->save();
    
    return redirect()->route('customerIndex')->with('success', 'Customer created successfully!');
}
public function customerstore(Request  $request)
{
    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->mobile_no = $request->mobile_no;
    $customer->address = $request->address;
    $customer->zip_code = $request->zip_code;
    $customer->country = $request->country;
    $customer->state = $request->state;
    $customer->city = $request->city;
    $customer->gst_no = $request->gst_no;  
    $customer->date_of_birth = $request->date_of_birth; 
    $customer->remark = $request->remark;
    $customer->save();
    return redirect()->back()->with('success' ,'customer create successfully');
}
public function update( Request $request,$id)
{

    // $request->validate([
    //     'customer_name' => 'required|string|max:255',
    //     'email' => 'required|email|unique:customers',
    //     'mobile_no' => 'required|string|max:15',
    //     'address' => 'required|string|max:255',
    //     'zip_code' => 'required|string|max:10',
    //     'country' => 'required|exists:countries,id',
    //     'state' => 'required|exists:states,id',
    //     'city' => 'required|exists:cities,id',
    //     'tax_identification_no' => 'required|string|max:50',
    //     'account_type' => 'required|in:credit,debit',
    //     'opening_balance' => 'required|numeric',
    //     'document_type' => 'required|string|max:50',
    //     'document_no' => 'required|string|max:50',
    //     'date_of_birth' => 'required|date',
    //     'anniversary_date' => 'nullable|date',
    //     'credit_allowed' => 'required|boolean',
    //     'credit_limit' => 'required|numeric',
    //     'remark' => 'nullable|string',
    //     'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    // ]);


    $customer =Customer::find($id);
    $customer->name = $request->name   ??  $customer->name;
    $customer->email = $request->email   ??$customer->email;
    $customer->mobile_no = $request->mobile_no?? $customer->mobile_no;
    $customer->address = $request->address ?? $customer->address;
    $customer->zip_code = $request->zip_code ??$customer->zip_code;
    $customer->country = $request->country ??$customer->country;
    $customer->state = $request->state  ?? $customer->state;
    $customer->city = $request->city   ?? $customer->city;
    $customer->gst_no = $request->gst_no  ??$customer->gst_no;  
    $customer->date_of_birth = $request->date_of_birth ??$customer->date_of_birth; 
    $customer->remark = $request->remark ?? $customer->remark;
    $customer->save();

    // if ($request->hasFile('avatar')) {
    //     if ($customer->avatar && \Storage::exists('public/images/' . $customer->avatar)) {
    //         \Storage::delete('public/images/' . $customer->avatar);
    //     }
    //     $image = $request->file('avatar');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
    //     $image->storeAs('public/images', $imageName);
    //     $customer->avatar = $imageName;
    // }
    


    return redirect()->route('customerIndex')->with('success', 'Customer Update successfully!');

}
public function delete($id)
{
    $customer = Customer::find($id);
    $customer->delete();
    return redirect()->route('customerIndex')->with('success', 'Customer Update successfully!');



}
public function restoreAll()
{
    // softdeleted   customers restore
    Customer::onlyTrashed()->restore();
    return redirect()->back()->with('success', 'All customers have been restored.');
}



   public function getStates(Request $request) {
    $states = DB::table('states')
            ->where('country_id', $request->country_id)
            ->get();
    if (count($states) > 0) {
        return response()->json($states);
    }
}

public function getCities(Request $request) {
    $cities = DB::table('cities')
            ->where('state_id', $request->state_id)
            ->get();
    if (count($cities) > 0) {
        return response()->json($cities);
    }

}


    
}
