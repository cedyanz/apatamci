<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    //
    public function index()
    {
       $properties = Property::all();
       if ($properties->count() > 0) {
          return response()->json([
             'status' => 200,
             'data' => $properties
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "No Properties found"
          ], 404);
       }
    }
 
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:191',
          'description' => 'nullable|string',
          'location' => 'required|string|max:255',
          'type' => 'required|string|max:100',
          'price_per_night' => 'required|numeric',
          'amenities' => 'nullable|string',
          'owner_id' => 'required|exists:users,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $property = Property::create([
             'name' => $request->name,
             'description' => $request->description,
             'location' => $request->location,
             'type' => $request->type,
             'price_per_night' => $request->price_per_night,
             'amenities' => $request->amenities,
             'owner_id' => $request->owner_id,
          ]);
 
          if ($property) {
             return response()->json([
                'status' => 200,
                'message' => "Property created successfully"
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
       $property = Property::find($id);
 
       if ($property) {
          return response()->json([
             'status' => 200,
             'data' => $property
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "Property not found"
          ], 404);
       }
    }
 
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:191',
          'description' => 'nullable|string',
          'location' => 'required|string|max:255',
          'type' => 'required|string|max:100',
          'price_per_night' => 'required|numeric',
          'amenities' => 'nullable|string',
          'owner_id' => 'required|exists:users,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $property = Property::find($id);
 
          if (!$property) {
             return response()->json([
                'status' => 404,
                'message' => "Property not found"
             ], 404);
          }
 
          $property->name = $request->name;
          $property->description = $request->description;
          $property->location = $request->location;
          $property->type = $request->type;
          $property->price_per_night = $request->price_per_night;
          $property->amenities = $request->amenities;
          $property->owner_id = $request->owner_id;
 
          if ($property->save()) {
             return response()->json([
                'status' => 200,
                'message' => "Property updated successfully"
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
       $property = Property::find($id);
 
       if (!$property) {
          return response()->json([
             'status' => 404,
             'message' => "Property not found"
          ], 404);
       }
 
       if ($property->delete()) {
          return response()->json([
             'status' => 200,
             'message' => "Property deleted successfully"
          ], 200);
       } else {
          return response()->json([
             'status' => 500,
             'message' => "Something went wrong"
          ], 500);
       }
    }
}
