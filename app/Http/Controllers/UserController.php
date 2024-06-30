<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index()
   {
      $users = User::all();
      if ($users->count() > 0) {
         return response()->json([
            'status' => 200,
            'data' => $users
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "No Users found"
         ], 404);
      }
   }

   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'name' => 'required|string|max:191',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|string|min:6',
         'phone_number' => 'nullable|string|max:15',
         'address' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
         ]);

         if ($user) {
            return response()->json([
               'status' => 200,
               'message' => "User created successfully"
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
      $user = User::find($id);

      if ($user) {
         return response()->json([
            'status' => 200,
            'data' => $user
         ], 200);
      } else {
         return response()->json([
            'status' => 404,
            'message' => "User not found"
         ], 404);
      }
   }

   public function update(Request $request, $id)
   {
      $validator = Validator::make($request->all(), [
         'name' => 'required|string|max:191',
         'email' => 'required|email|unique:users,email,' . $id,
         'phone_number' => 'nullable|string|max:15',
         'address' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
         ], 422);
      } else {
         $user = User::find($id);

         if (!$user) {
            return response()->json([
               'status' => 404,
               'message' => "User not found"
            ], 404);
         }

         $user->name = $request->name;
         $user->email = $request->email;
         $user->phone_number = $request->phone_number;
         $user->address = $request->address;

         if ($user->save()) {
            return response()->json([
               'status' => 200,
               'message' => "User updated successfully"
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
      $user = User::find($id);

      if (!$user) {
         return response()->json([
            'status' => 404,
            'message' => "User not found"
         ], 404);
      }

      if ($user->delete()) {
         return response()->json([
            'status' => 200,
            'message' => "User deleted successfully"
         ], 200);
      } else {
         return response()->json([
            'status' => 500,
            'message' => "Something went wrong"
         ], 500);
      }
   }
}
