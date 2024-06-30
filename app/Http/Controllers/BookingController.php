<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
    //
    public function index()
   {
      $bookings = Booking::all();
      if ($bookings->count() > 0) {
         return response()->json([
            'status' => 200,
            'data' => $bookings
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "No Bookings found"
         ], 404);
      }
   }

   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'check_in_date' => 'required|date',
         'check_out_date' => 'required|date|after_or_equal:check_in_date',
         'total_price' => 'required|numeric',
         'booking_status' => 'required|string|max:50',
         'user_id' => 'required|exists:users,id',
         'property_id' => 'required|exists:properties,id',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $booking = Booking::create([
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $request->total_price,
            'booking_status' => $request->booking_status,
            'user_id' => $request->user_id,
            'property_id' => $request->property_id,
         ]);

         if ($booking) {
            return response()->json([
               'status' => 200,
               'message' => "Booking created successfully"
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
      $booking = Booking::find($id);

      if ($booking) {
         return response()->json([
            'status' => 200,
            'data' => $booking
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "Booking not found"
         ], 404);
      }
   }

   public function update(Request $request, $id)
   {
      $validator = Validator::make($request->all(), [
         'check_in_date' => 'required|date',
         'check_out_date' => 'required|date|after_or_equal:check_in_date',
         'total_price' => 'required|numeric',
         'booking_status' => 'required|string|max:50',
         'user_id' => 'required|exists:users,id',
         'property_id' => 'required|exists:properties,id',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $booking = Booking::find($id);

         if (!$booking) {
            return response()->json([
               'status' => 404,
               'message' => "Booking not found"
            ], 404);
         }

         $booking->check_in_date = $request->check_in_date;
         $booking->check_out_date = $request->check_out_date;
         $booking->total_price = $request->total_price;
         $booking->booking_status = $request->booking_status;
         $booking->user_id = $request->user_id;
         $booking->property_id = $request->property_id;

         if ($booking->save()) {
            return response()->json([
               'status' => 200,
               'message' => "Booking updated successfully"
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
      $booking = Booking::find($id);

      if (!$booking) {
         return response()->json([
            'status' => 404,
            'message' => "Booking not found"
         ], 404);
      }

      if ($booking->delete()) {
         return response()->json([
            'status' => 200,
            'message' => "Booking deleted successfully"
         ], 200);
      } else {
         return response()->json([
            'status' => 500,
            'message' => "Something went wrong"
         ], 500);
      }
   }
}
