<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller
{
    /**
     * Display a listing of the instructors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructors = User::where('userType', 'instructor')->get();
        return view('admin.instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new instructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created instructor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username|min:3|max:191',
            'email' => 'required|email|unique:users,email|max:191',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'plain_password' => $request->password,
                'userType' => 'instructor',
                'status' => 1,
                'branch_id' => 1 // Adding branch ID as usually required by similar forms
            ]);

            return redirect()->route('admin.instructors.index')->with('success', 'Instructor created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating instructor: ' . $e->getMessage());
        }
    }
}
