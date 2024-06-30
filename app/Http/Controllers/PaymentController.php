<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{
    //
    public function index()
    {
       $payments = Payment::all();
       if ($payments->count() > 0) {
          return response()->json([
             'status' => 200,
             'data' => $payments
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "No Payments found"
          ], 404);
       }
    }
 
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'amount' => 'required|numeric',
          'date' => 'required|date',
          'method' => 'required|string|max:100',
          'status' => 'required|string|max:50',
          'booking_id' => 'required|exists:bookings,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $payment = Payment::create([
             'amount' => $request->amount,
             'date' => $request->date,
             'method' => $request->method,
             'status' => $request->status,
             'booking_id' => $request->booking_id,
          ]);
 
          if ($payment) {
             return response()->json([
                'status' => 200,
                'message' => "Payment created successfully"
             ], 200);
          } else {
             return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
             ], 500);
          }
       }
    }
 
    public function show($id)
    {
       $payment = Payment::find($id);
 
       if ($payment) {
          return response()->json([
             'status' => 200,
             'data' => $payment
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "Payment not found"
          ], 404);
       }
    }
 
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
          'amount' => 'required|numeric',
          'date' => 'required|date',
          'method' => 'required|string|max:100',
          'status' => 'required|string|max:50',
          'booking_id' => 'required|exists:bookings,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $payment = Payment::find($id);
 
          if (!$payment) {
             return response()->json([
                'status' => 404,
                'message' => "Payment not found"
             ], 404);
          }
 
          $payment->amount = $request->amount;
          $payment->date = $request->date;
          $payment->method = $request->method;
          $payment->status = $request->status;
          $payment->booking_id = $request->booking_id;
 
          if ($payment->save()) {
             return response()->json([
                'status' => 200,
                'message' => "Payment updated successfully"
             ], 200);
          } else {
             return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
             ], 500);
          }
       }
    }
 
    public function destroy($id)
    {
       $payment = Payment::find($id);
 
       if (!$payment) {
          return response()->json([
             'status' => 404,
             'message' => "Payment not found"
          ], 404);
       }
 
       if ($payment->delete()) {
          return response()->json([
             'status' => 200,
             'message' => "Payment deleted successfully"
          ], 200);
       } else {
          return response()->json([
             'status' => 500,
             'message' => "Something went wrong"
          ], 500);
       }
    }
}
