<?php

namespace App\Http\Controllers;

use App\Models\exam;
use App\Models\packages;
use App\Models\paymentdetails;
use Facade\FlareClient\Api;
use Facade\Ignition\Support\Packagist\Package;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Stripe;
// use Stripe;
use Session;

use Stripe\Stripe as StripeStripe;

class studentcontroller extends Controller
{
    public function paidexamsdash()
    {
        $exams = exam::where('plan', 1)->with('subjects')->orderBy('date', 'DESC')->get();
        return view('student.paidexams', ['exams' => $exams]);
    }





 public function paymentpkr(Request $request){
        $price=$request->price;
          $id=$request->exam_id;
        return view('chargepayment',compact(['price','id']));
 }

 public function paymentdone(Request $request){
    
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $customer = \Stripe\Customer::create(array(
      'name' => auth()->user()->name,
      'description' => 'Exam Payments',
      'email' => auth()->user()->email,
  
      'source' => $request->input('stripeToken'),
       "address" => ["city" => "San Francisco", "country" => "US", "line1" => "510 Townsend St", "postal_code" => "98140", "state" => "CA"]

  ));
    try {
      $details = \Stripe\Charge::create([
        "amount" => $request->price.'00', // amount in cents
        "currency" => "pkr",
        "customer" => $customer["id"],
        "description" => "Exam Payment.",
        "receipt_email" => auth()->user()->email, // Email for the receipt
        "metadata" => [
            "user_id" => auth()->user()->id,
            "user_name" => auth()->user()->name,
            "user_email" => auth()->user()->email,
            // Add more metadata fields if needed
        ]
   
    ]);
    
    // Log the response to check if billing details are properly set
    
        paymentdetails::insert([
            'exam_id'=>$request->exam_id,
            'user_id'=>auth()->user()->id,
            'payment_details'=>json_encode($details)
        ]);
   
        return redirect('/paidexams')->with('success', 'Payment Done Successfully');
        return view ( 'cardForm' );
    } catch ( \Exception $e ) {
        return redirect('/paidexams')->with('success', $e->getMessage());
        return view ( 'cardForm' );
    }


 }

 public function paidpackage(){
    $paidpackage=packages::orderBy('created_at','DESC')->get();
    return view('student.paidpackages',compact('paidpackage'));
 }



 public function packagepayment(Request $request){
   $package_id= $request->package_id;
    $price=$request->price;
      $id=$request->exam_id;
    return view('chargepackagepayment',compact(['price','id','package_id']));
}


 public function packagepaymentdone(Request $request){

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $customer = \Stripe\Customer::create(array(
      'name' => auth()->user()->name,
      'description' => 'Exam Payments',
      'email' => auth()->user()->email,
      'source' => $request->input('stripeToken'),
       "address" => ["city" => "San Francisco", "country" => "US", "line1" => "510 Townsend St", "postal_code" => "98140", "state" => "CA"]

  ));

    try {
      $details = \Stripe\Charge::create([
        "amount" => $request->price * 100, // amount in cents
        "currency" => "pkr",
        "customer" => $customer["id"],
        "description" => "Package payment.",
        "receipt_email" => auth()->user()->email,
        "metadata" => [
            "user_id" => auth()->user()->id,
            "user_name" => auth()->user()->name,
            "user_email" => auth()->user()->email,
            // Add more metadata fields if needed
        ]
        
        // Email for the receipt
        
    ]);
    
    // Log the response to check if metadata and receipt details are properly set
    // Log::info("Stripe Charge Response: " . print_r($details, true));
    
    
          $packagedata=packages::where('id',$request->package_id)->get();

               $exams=$packagedata[0]['exam_id'];



foreach($exams as $exam){

    paymentdetails::insert([
        'exam_id'=>$exam->id,
        'user_id'=>auth()->user()->id,
        'payment_details'=>json_encode([$details,$customer])
    ]);
}

   
        return redirect('/paidpackages')->with('success', 'Payment Done Successfully');
        return view ( 'cardForm' );
    } catch ( \Exception $e ) {
        return redirect('/paidexams')->with('error', $e->getMessage());
        return view ( 'cardForm' );
    }


 }
}
