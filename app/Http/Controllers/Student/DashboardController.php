<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $enrollments = Auth::user()->enrollments()
            ->where('payment_status', 'paid')
            ->with(['course.instructor'])
            ->latest()
            ->get();

        return view('student.dashboard', compact('enrollments'));
    }
}
