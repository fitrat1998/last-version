<?php

namespace App\Http\Controllers;

use App\Models\AttachTeacher;
use App\Http\Requests\StoreAttachTeacherRequest;
use App\Http\Requests\UpdateAttachTeacherRequest;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttachTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('teacherattach.show');

        $faculties = Faculty::all();

        $groups = Group::all();

        return view('pages.teachers.attach', compact('faculties', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if_forbidden('teacherattach.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreAttachTeacherRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachTeacherRequest $request)
    {

     abort_if_forbidden('teacherattach.create');


//        dd($request);
        $teachers = $request->input('teachers_id');
        $faculties = $request->input('faculty_id');
        $groups = $request->input('groups_id');

        $teacher = auth()->user()->id;


        foreach ($teachers as $teacher) {
            $existingTeacher = DB::table('teacher_has_group')
                ->where('teachers_id', $teacher)
                ->first();

            if (!$existingTeacher) {
                DB::table('teacher_has_group')->insert([
                    'teachers_id' => $teacher,
                    'faculties_id' => $faculties, // Bu qismni o'zingizga muvofiq o'zgartiring
                    'groups_id' => $groups,       // Bu qismni o'zingizga muvofiq o'zgartiring
                ]);
            }
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\AttachTeacher $attachTeacher
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $teachers = Teacher::where('faculties_id',$id)->get();

        $existsteachers = DB::table('teacher_has_group')
                ->where('faculties_id', $id)
                ->first();

        if (!$existsteachers) {
            foreach ($teachers as $teacher) {
                $faculty = Faculty::find($teacher->faculties_id);

                if ($faculty) {
                    $teacher->faculties_id = $faculty->faculty_name;
                }
            }
            return response()->json($teachers);
        } else {
            $data = ['id' => 'student yuq', 'id' => 'student yuq', 'id' => 'student yuq', 'id' => 'student yuq'];
            return response()->json($data);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\AttachTeacher $attachTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(AttachTeacher $attachTeacher)
    {
        abort_if_forbidden('teacherattach.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAttachTeacherRequest $request
     * @param \App\Models\AttachTeacher $attachTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttachTeacherRequest $request, AttachTeacher $attachTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\AttachTeacher $attachTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttachTeacher $attachTeacher)
    {
        abort_if_forbidden('teacherattach.destroy');

    }
}
