<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Lessontype;
use App\Models\Educationyear;
use App\Models\Attendance_log;
use App\Http\Requests\StoreAttendance_logRequest;
use App\Http\Requests\UpdateAttendance_logRequest;

class AttendanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('attendance_log.show');

        $teachers = Teacher::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $faculties = Faculty::all();

        $educationyears = Educationyear::all();
        $lessontypes = Lessontype::all();
        $semesters = Semester::all();
        $attendance_logs = Attendance_log::all();

         $role =  auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if($role[0] == 'teacher'){
            $groups = Group::where('user_id',$user)->get();
        }
        else if(auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }


        return view('pages.attendance_logs.index',compact('users','teachers','attendance_logs','faculties','groups','semesters','lessontypes','educationyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('attendance_log.create');

        $subjects = Subject::all();

        $educationyears = Educationyear::all();
        $lessontypes = Lessontype::all();
        $semesters = Semester::all();
        $teachers = Teacher::all();

        $role =  auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if($role[0] == 'teacher'){
            $groups = Group::where('user_id',$user)->get();
        }
        else if(auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }

        return view('pages.attendance_logs.add',compact('teachers','subjects','groups','semesters','lessontypes','educationyears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttendance_logRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendance_logRequest $request)
    {
        abort_if_forbidden('attendance_log.create');

        $attendance_logs = Attendance_log::create([
            'groups_id' => $request->get('group_id'),
            'subjects_id' => $request->get('subject_id'),
            'educationyears_id' => $request->get('educationyear_id'),
            'semesters_id' => $request->get('semester_id'),
            'lessontypes_id' => $request->get('lessontype_id'),
            'teachers_id' => $request->get('teacher_id'),

        ]);

        return redirect()->route('attendance_logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {

        $group = Group::find($id);
        $subjects = $group->subject;
        $educationyears = Educationyear::all();

//        dd($subjects);

        return view('pages.attendance_logs.subjects',compact('subjects','group'));
    }

    public function results()
    {
        $teachers = Teacher::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $faculties = Faculty::all();

        $educationyears = Educationyear::all();
        $lessontypes = Lessontype::all();
        $semesters = Semester::all();
        $attendance_logs = Attendance_log::all();

        $role =  auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if($role[0] == 'teacher'){
            $groups = Group::where('user_id',$user)->get();
        }
        else if(auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }


        return view('pages.attendance_logs.result',compact('attendance_logs','faculties','groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('attendance_log.edit');

        $attendance_log = Attendance_log::find($id);
        $subjects = Subject::all();
        $groups = Group::all();
        $educationyears = Educationyear::all();
        $lessontypes = Lessontype::all();
        $semesters = Semester::all();
        $teachers = Teacher::all();

        return view('pages.attendance_logs.edit',compact('attendance_log','teachers','subjects','groups','semesters','lessontypes','educationyears'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendance_logRequest  $request
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendance_logRequest $request, $id)
    {
        abort_if_forbidden('attendance_log.edit');

        $attendance_log = Attendance_Log::find($id);
        $attendance_log->fill($request->all());
        $attendance_log->update([
            'groups_id' => $request->group_id,
            'subjects_id' => $request->subject_id,
            'educationyears_id' => $request->educationyear_id,
            'semesters_id' => $request->semester_id,
            'lessontypes_id' => $request->lessontype_id,
            'teachers_id' => $request->teacher_id,
        ]);

        return redirect()->route('attendance_logs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance_log $attendance_log)
    {
        abort_if_forbidden('attendance_log.destroy');
    }
}
