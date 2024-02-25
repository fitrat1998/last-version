<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Lessontype;
use App\Models\Educationyear;
use App\Models\Attendance_log;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('lessontype.show');

        $teachers = Teacher::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $subjects = Subject::all();
        $groups = Group::all();
        $educationyears = Educationyear::all();
        $lessontypes = Lessontype::all();
        $semesters = Semester::all();
        $attendance_logs = Attendance_log::all();

        return view('pages.attendance_logs.attendance-lesson',compact('users','teachers','attendance_logs','subjects','groups','semesters','lessontypes','educationyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonRequest  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
