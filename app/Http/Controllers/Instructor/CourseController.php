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
            'level' => 'required|in:beginner,intermediate,advanced',
            'category' => 'nullable|string|max:255',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'min_slots' => 'nullable|integer|min:1',
            'max_slots' => 'nullable|integer|min:1',
            'schedule_start' => 'nullable|date',
            'schedule_end' => 'nullable|date|after_or_equal:schedule_start',
            'session_count' => 'nullable|integer|min:1',
            'session_duration_mins' => 'nullable|integer|min:1',
            'recurrence' => 'required|in:once,daily,weekly,custom',
            'meeting_link' => 'nullable|url',
            'location' => 'nullable|string|max:255',
            'suggested_price' => 'required|numeric|min:0',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $courseData = [
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level,
            'category' => $request->category,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            'min_slots' => $request->min_slots ?? 1,
            'max_slots' => $request->max_slots,
            'schedule_start' => $request->schedule_start,
            'schedule_end' => $request->schedule_end,
            'session_count' => $request->session_count ?? 1,
            'session_duration_mins' => $request->session_duration_mins ?? 60,
            'recurrence' => $request->recurrence,
            'meeting_link' => $request->meeting_link,
            'location' => $request->location,
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

        $updateData = $request->only([
            'title', 'description', 'level', 'category', 'min_age', 'max_age', 
            'min_slots', 'max_slots', 'schedule_start', 'schedule_end', 
            'session_count', 'session_duration_mins', 'recurrence', 
            'meeting_link', 'location', 'suggested_price'
        ]);

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
