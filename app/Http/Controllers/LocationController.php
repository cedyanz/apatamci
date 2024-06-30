<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{
    //
    public function index()
   {
      $locations = Location::all();
      if ($locations->count() > 0) {
         return response()->json([
            'status' => 200,
            'data' => $locations
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "No Locations found"
         ], 404);
      }
   }

   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'city' => 'required|string|max:191',
         'state' => 'required|string|max:191',
         'country' => 'required|string|max:191',
         'latitude' => 'required|numeric',
         'longitude' => 'required|numeric',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $location = Location::create([
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
         ]);

         if ($location) {
            return response()->json([
               'status' => 200,
               'message' => "Location created successfully"
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
      $location = Location::find($id);

      if ($location) {
         return response()->json([
            'status' => 200,
            'data' => $location
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "Location not found"
         ], 404);
      }
   }

   public function update(Request $request, $id)
   {
      $validator = Validator::make($request->all(), [
         'city' => 'required|string|max:191',
         'state' => 'required|string|max:191',
         'country' => 'required|string|max:191',
         'latitude' => 'required|numeric',
         'longitude' => 'required|numeric',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $location = Location::find($id);

         if (!$location) {
            return response()->json([
               'status' => 404,
               'message' => "Location not found"
            ], 404);
         }

         $location->city = $request->city;
         $location->state = $request->state;
         $location->country = $request->country;
         $location->latitude = $request->latitude;
         $location->longitude = $request->longitude;

         if ($location->save()) {
            return response()->json([
               'status' => 200,
               'message' => "Location updated successfully"
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
      $location = Location::find($id);

      if (!$location) {
         return response()->json([
            'status' => 404,
            'message' => "Location not found"
         ], 404);
      }

      if ($location->delete()) {
         return response()->json([
            'status' => 200,
            'message' => "Location deleted successfully"
         ], 200);
      } else {
         return response()->json([
            'status' => 500,
            'message' => "Something went wrong"
         ], 500);
      }
   }
}
