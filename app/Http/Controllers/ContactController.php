<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        try {

            return view('contact');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|digits:10',
                'email' => 'required|email',
                'message' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

           Contact::create([
            'user_id' =>Auth::id(),
            'name' =>$request->name,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'message' =>$request->message,
           ]);

            return response()->json(['success' => 'Message sent successfully']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
