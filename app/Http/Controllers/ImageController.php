<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;


class ImageController extends Controller
{
    //
    public function index()
    {
       $images = Image::all();
       if ($images->count() > 0) {
          return response()->json([
             'status' => 200,
             'data' => $images
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "No Images found"
          ], 404);
       }
    }
 
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'url' => 'required|string|max:191',
          'description' => 'nullable|string',
          'property_id' => 'required|exists:properties,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $image = Image::create([
             'url' => $request->url,
             'description' => $request->description,
             'property_id' => $request->property_id,
          ]);
 
          if ($image) {
             return response()->json([
                'status' => 200,
                'message' => "Image created successfully"
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
       $image = Image::find($id);
 
       if ($image) {
          return response()->json([
             'status' => 200,
             'data' => $image
          ], 200);
       } else {
          return response()->json([
             'status' => 404,
             'message' => "Image not found"
          ], 404);
       }
    }
 
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
          'url' => 'required|string|max:191',
          'description' => 'nullable|string',
          'property_id' => 'required|exists:properties,id',
       ]);
 
       if ($validator->fails()) {
          return response()->json([
             'status' => 422,
             'errors' => $validator->messages()
          ], 422);
       } else {
          $image = Image::find($id);
 
          if (!$image) {
             return response()->json([
                'status' => 404,
                'message' => "Image not found"
             ], 404);
          }
 
          $image->url = $request->url;
          $image->description = $request->description;
          $image->property_id = $request->property_id;
 
          if ($image->save()) {
             return response()->json([
                'status' => 200,
                'message' => "Image updated successfully"
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
       $image = Image::find($id);
 
       if (!$image) {
          return response()->json([
             'status' => 404,
             'message' => "Image not found"
          ], 404);
       }
 
       if ($image->delete()) {
          return response()->json([
             'status' => 200,
             'message' => "Image deleted successfully"
          ], 200);
       } else {
          return response()->json([
             'status' => 500,
             'message' => "Something went wrong"
          ], 500);
       }
    }
}
