<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Course;
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
      'email' => 'required|email|max:191',
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

  /**
   * Update an existing instructor.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $instructor = User::where('userType', 'instructor')->findOrFail($id);

    $rules = [
      'username' => 'required|string|min:3|max:191|unique:users,username,' . $id,
      'email' => 'required|email|max:191|unique:users,email,' . $id,
    ];

    if ($request->filled('password')) {
      $rules['password'] = 'string|min:6|confirmed';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->route('admin.instructors.index')
        ->withErrors($validator)
        ->with('error', $validator->errors()->first());
    }

    try {
      $instructor->username = $request->username;
      $instructor->email = $request->email;

      if ($request->filled('password')) {
        $instructor->password = Hash::make($request->password);
        $instructor->plain_password = $request->password;
      }

      $instructor->save();

      return redirect()->route('admin.instructors.index')
        ->with('success', 'Instructor updated successfully.');
    } catch (\Exception $e) {
      return redirect()->route('admin.instructors.index')
        ->with('error', 'Error updating instructor: ' . $e->getMessage());
    }
  }

  /**
   * Remove the specified instructor.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $instructor = User::where('userType', 'instructor')->findOrFail($id);

    // Block deletion if the instructor still has courses
    $courseCount = Course::where('instructor_id', $id)->count();
    if ($courseCount > 0) {
      return redirect()->route('admin.instructors.index')
        ->with('error', 'Cannot delete "' . $instructor->username . '" — they still have ' . $courseCount . ' course(s). Please remove their courses first.');
    }

    try {
      $instructor->delete();

      return redirect()->route('admin.instructors.index')
        ->with('success', 'Instructor "' . $instructor->username . '" deleted successfully.');
    } catch (\Exception $e) {
      return redirect()->route('admin.instructors.index')
        ->with('error', 'Error deleting instructor: ' . $e->getMessage());
    }
  }
}
