<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    //
    public function index()
   {
      $reviews = Review::all();
      if ($reviews->count() > 0) {
         return response()->json([
            'status' => 200,
            'data' => $reviews
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "No Reviews found"
         ], 404);
      }
   }

   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'rating' => 'required|numeric|between:1,5',
         'comment' => 'nullable|string',
         'user_id' => 'required|exists:users,id',
         'property_id' => 'required|exists:properties,id',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $review = Review::create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'property_id' => $request->property_id,
         ]);

         if ($review) {
            return response()->json([
               'status' => 200,
               'message' => "Review created successfully"
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
      $review = Review::find($id);

      if ($review) {
         return response()->json([
            'status' => 200,
            'data' => $review
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "Review not found"
         ], 404);
      }
   }

   public function update(Request $request, $id)
   {
      $validator = Validator::make($request->all(), [
         'rating' => 'required|numeric|between:1,5',
         'comment' => 'nullable|string',
         'user_id' => 'required|exists:users,id',
         'property_id' => 'required|exists:properties,id',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $review = Review::find($id);

         if (!$review) {
            return response()->json([
               'status' => 404,
               'message' => "Review not found"
            ], 404);
         }

         $review->rating = $request->rating;
         $review->comment = $request->comment;
         $review->user_id = $request->user_id;
         $review->property_id = $request->property_id;

         if ($review->save()) {
            return response()->json([
               'status' => 200,
               'message' => "Review updated successfully"
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
      $review = Review::find($id);

      if (!$review) {
         return response()->json([
            'status' => 404,
            'message' => "Review not found"
         ], 404);
      }

      if ($review->delete()) {
         return response()->json([
            'status' => 200,
            'message' => "Review deleted successfully"
         ], 200);
      } else {
         return response()->json([
            'status' => 500,
            'message' => "Something went wrong"
         ], 500);
      }
   }  
}
