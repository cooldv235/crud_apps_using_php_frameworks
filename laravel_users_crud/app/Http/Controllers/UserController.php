<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = Admin::orderBy('id', 'desc')->paginate(5);
        return view('users.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'address' => 'required|max:191',
            'contact' => 'required|max:191'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = new Admin;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->contact = $request->contact;
            $user->save();
            
            return response()->json([
                'status' => 200,
                'message' => 'User Added Successfully',
            ]);
        }

    }
}
