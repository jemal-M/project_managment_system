<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
      $payments = Payment::all();
      return response()->json(['payments'=>$payments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required',
            'lease_id' => 'required',
            'amount' => 'required|numeric',
            'payment_date'=>'required',
            'status'=>'required',
            'payment_method'=>'required'
        ]);
        $payment = Payment::create($request->all());
        return response()->json(['payment'=>$payment,201]);
    }
      public function  show($id)
    {
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json(['message'=>'Payment not found'], 404);
        }
        return response()->json(['payment'=>$payment]);
    }
     public function update(Request $request, $id)
    {
        $request->validate([
            'tenant_id' => 'required',
            'lease_id' => 'required',
            'amount' => 'required|numeric',
            'payment_date'=>'required',
            'status'=>'required',
            'payment_method'=>'required'
        ]);
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json(['message'=>'Payment not found'], 404);
        }
        $payment->update($request->all());
        return response()->json(['payment'=>$payment]);
    }
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json(['message'=>'Payment not found'], 404);
        }
        $payment->delete();
        return response()->json(['message'=>'Payment deleted successfully']);
    }
     
}
