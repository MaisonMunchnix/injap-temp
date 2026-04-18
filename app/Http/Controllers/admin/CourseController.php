<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Course;
use App\Enrollment;
use App\User;
use App\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function allEnrollments()
    {
        $enrollments = Enrollment::with('course.instructor')->latest()->get();
        $courses = Course::orderBy('title')->get(['id', 'title']);
        return view('admin.courses.enrollments', compact('enrollments', 'courses'));
    }

    public function updateEnrollmentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,refunded',
            'payment_method' => 'nullable|string',
        ]);

        $oldStatus = $enrollment->payment_status;
        $newStatus = $request->status;

        DB::transaction(function () use ($request, $enrollment, $oldStatus, $newStatus) {
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                // Provision student account
                $user = User::where('email', $enrollment->email)->first();

                if (!$user) {
                    $user = User::create([
                        'username' => $enrollment->email,
                        'email' => $enrollment->email,
                        'password' => Hash::make('Student@2026'),
                        'userType' => 'student',
                        'status' => 1,
                        'must_change_password' => true,
                    ]);

                    StudentProfile::create([
                        'user_id' => $user->id,
                        'phone' => $enrollment->phone,
                        'age' => $enrollment->age,
                        'guardian_name' => $enrollment->guardian_name,
                        'guardian_contact' => $enrollment->guardian_contact,
                    ]);
                } else {
                    // Force repair for existing testing accounts
                    $user->update([
                        'status' => 1,
                        'userType' => 'student',
                        'password' => Hash::make('Student@2026'),
                        'must_change_password' => true
                    ]);
                }

                $enrollment->update([
                    'user_id' => $user->id,
                    'payment_status' => $newStatus,
                    'payment_method' => $request->payment_method
                ]);
            } elseif ($newStatus === 'refunded') {
                $this->handleEnrollmentRemoval($enrollment);
            } else {
                $enrollment->update([
                    'payment_status' => $newStatus,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        return redirect()->back()->with('success', 'Enrollment payment status updated successfully.');
    }

    public function destroyEnrollment(Enrollment $enrollment)
    {
        $this->handleEnrollmentRemoval($enrollment);
        return redirect()->back()->with('success', 'Enrollment deleted successfully.');
    }

    private function handleEnrollmentRemoval(Enrollment $enrollment)
    {
        DB::transaction(function () use ($enrollment) {
            $user = $enrollment->user;
            $enrollment->delete();

            if ($user) {
                // Check if user has any other active/paid enrollments
                $hasOtherEnrollments = Enrollment::where('user_id', $user->id)
                    ->where('payment_status', 'paid')
                    ->exists();

                if (!$hasOtherEnrollments) {
                    $profile = $user->studentProfile;
                    if ($profile) {
                        $profile->update(['status' => 'suspended']);
                    }
                }
            }
        });
    }

    public function updateStatus(Request $request, Course $course)
    {
        $request->validate([
            'status' => 'required|in:pending,published,rejected',
        ]);

        $course->update(['status' => $request->status]);

        // Auto-approve pending materials if course is specifically being approved (published)
        if ($request->status === 'published') {
            \App\CourseMaterial::where('course_id', $course->id)
                ->where('status', 'pending')
                ->update(['status' => 'approved', 'admin_note' => 'Auto-approved alongside course publication.']);
        }

        return redirect()->back()->with('success', 'Course status updated successfully.');
    }

    public function updatePrice(Request $request, Course $course)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:PHP,JPY',
        ]);

        $course->update([
            'price' => $request->price,
            'currency' => $request->currency,
            'price_source' => 'admin',
            'price_updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Course price and currency updated successfully.');
    }

    public function show(Course $course)
    {
        return response()->json($course->load(['instructor', 'materials']));
    }

    public function allMaterials()
    {
        $materials = \App\CourseMaterial::with(['course', 'instructor'])->latest()->get();
        $courses = Course::orderBy('title')->get(['id', 'title']);
        return view('admin.courses.materials', compact('materials', 'courses'));
    }

    public function updateMaterialStatus(Request $request, \App\CourseMaterial $material)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $material->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->back()->with('success', 'Material status updated successfully.');
    }

    public function downloadMaterial(\App\CourseMaterial $material)
    {
        if ($material->type !== 'file' || empty($material->file_path)) {
            return back()->with('error', 'Invalid material or no file associated.');
        }

        $path = storage_path('app/public/' . $material->file_path);

        if (!file_exists($path)) {
            return back()->with('error', 'File not found on server.');
        }

        return response()->download($path, $material->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
