<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseManagementController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();

        return view('admin.settings.courses', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
        ]);

        Course::create([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
        ]);

        return back()->with('success', 'Course added successfully.');
    }

    public function update(Request $request,int $id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
        ]);

        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(int $id)
    {
        Course::findOrFail($id)->delete();

        return back()->with('success', 'Course deleted successfully.');
    }
}