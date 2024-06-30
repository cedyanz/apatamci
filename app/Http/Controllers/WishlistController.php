<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;


class WishlistController extends Controller
{
    //
    public function index()
    {
        $wishlists = Wishlist::all();

        if ($wishlists->count() > 0) {
            return response()->json([
                'status' => 200,
                'data' => $wishlists
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No wishlists found"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $wishlist = Wishlist::create([
                'user_id' => $request->user_id,
            ]);

            if ($wishlist) {
                return response()->json([
                    'status' => 200,
                    'message' => "Wishlist created successfully"
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
        $wishlist = Wishlist::find($id);

        if ($wishlist) {
            return response()->json([
                'status' => 200,
                'data' => $wishlist
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Wishlist not found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return response()->json([
                'status' => 404,
                'message' => "Wishlist not found"
            ], 404);
        }

        if ($wishlist->delete()) {
            return response()->json([
                'status' => 200,
                'message' => "Wishlist deleted successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
            ], 500);
        }
    }
}
