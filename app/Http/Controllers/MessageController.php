<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    //
    public function index()
    {
        $messages = Message::all();

        if ($messages->count() > 0) {
            return response()->json([
                'status' => 200,
                'data' => $messages
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No messages found"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'timestamp' => 'required|date',
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $message = Message::create([
                'content' => $request->content,
                'timestamp' => $request->timestamp,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
            ]);

            if ($message) {
                return response()->json([
                    'status' => 200,
                    'message' => "Message sent successfully"
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
        $message = Message::find($id);

        if ($message) {
            return response()->json([
                'status' => 200,
                'data' => $message
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Message not found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'status' => 404,
                'message' => "Message not found"
            ], 404);
        }

        if ($message->delete()) {
            return response()->json([
                'status' => 200,
                'message' => "Message deleted successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
            ], 500);
        }
    }
}
