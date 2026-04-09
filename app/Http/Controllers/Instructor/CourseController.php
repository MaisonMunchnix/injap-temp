<?php
 
namespace App\Http\Controllers\Instructor;
 
use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'suggested_price' => 'required|numeric|min:0',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $courseData = [
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'suggested_price' => $request->suggested_price,
            'status' => 'draft',
        ];

        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/courses');
            $image->move($destinationPath, $name);
            $courseData['cover_photo'] = '/uploads/courses/' . $name;
        }

        Course::create($courseData);

        return redirect()->route('instructor.courses.index')->with('success', 'Course created as draft.');
    }

    public function edit(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'suggested_price' => 'required|numeric|min:0',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = $request->only(['title', 'description', 'suggested_price']);

        if ($request->hasFile('cover_photo')) {
            // Delete old photo if exists
            if ($course->cover_photo && file_exists(public_path($course->cover_photo))) {
                @unlink(public_path($course->cover_photo));
            }

            $image = $request->file('cover_photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/courses');
            $image->move($destinationPath, $name);
            $updateData['cover_photo'] = '/uploads/courses/' . $name;
        }

        $course->update($updateData);

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted.');
    }
}
