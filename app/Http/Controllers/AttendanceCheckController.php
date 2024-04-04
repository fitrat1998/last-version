<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Attendancecheck;
use App\Http\Requests\StoreAttendancecheckRequest;
use App\Http\Requests\UpdateAttendancecheckRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('attendance_log.show');

        return redirect()->route('attendance_logs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('attendance_log.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttendancecheckRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendancecheckRequest $request)
    {
        abort_if_forbidden('attendance_log.create');

        $studentId = $request->input('students_id');
        $exerciseId = $request->input('exercise_id');

        $exercise = Exercise::find($exerciseId);


        if(!empty($studentId) && !empty($exerciseId)){
            $students = is_array($studentId) ? $studentId : [$studentId];

           $existingAttendance = Attendancecheck::whereIn('students_id', $students)
                                        ->where('exercises_id',$exerciseId)
                                        ->where('topics_id',$exercise->topics_id)
                                        ->where('subjects_id',$exercise->subjects_id)
                                        ->where('absent', 1)
                                        ->get();

            if ($existingAttendance->isEmpty()) {
                foreach ($students as $student) {
                    Attendancecheck::create([
                        'absent' => 1,
                        'students_id' => $student,
                        'exercises_id' => $exerciseId,
                        'topics_id' => $exercise->topics_id,
                        'subjects_id' => $exercise->subjects_id,
                        'created_at' => now()
                    ]);
                }
            }

            return redirect()->back();

        }
        else {
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendancecheck  $attendance_check
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            // foreach ($exercises as $exercise) {
            //     $group_id = $exercise->groups_id;

            //     $student_ids = DB::table('student_has_attach')
            //         ->where('groups_id', $group_id)
            //         ->pluck('students_id')
            //         ->toArray();

            //     $students = Student::whereIn('id', $student_ids)->get();
            // }
            $now = Carbon::now();
            $exercise = Exercise::find($id);
            $students = collect();

            // dd($exercise);

             if($exercise) {
                $group_id = $exercise->groups_id;

                $student_ids = DB::table('student_has_attach')
                    ->where('groups_id', $group_id)
                    ->pluck('students_id')
                    ->toArray();
                $user = auth()->user()->id;
                $students = Student::whereIn('id', $student_ids)
                    ->where('user_id',$user)
                    ->get();
            }

            $ids = $students->pluck('id');
            // $exercises_id = $exercise->pluck('id');



        if (!empty($students)) {
            $status = Attendancecheck::where('exercises_id', $exercise->id)
                              ->whereIn('students_id', $ids)
                              ->where('topics_id',$exercise->topics_id)
                              ->where('subjects_id',$exercise->subjects_id)
                              ->where('absent', 1)
                              ->get();


        }
        else {
            $status = [];
        }

       // return [$status,$exercise->id];


        if(!empty($students)){
            return view('pages.attendance_logs.check',compact('exercise','students','status','now'));
        }
        else{
            $students = ['Bu guruhda talabalar mavjud emas!!!'];
            return view('pages.attendance_logs.check',compact('exercise','students','now'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendancecheck  $attendance_check
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendancecheck $attendance_check)
    {
        abort_if_forbidden('attendance_log.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendancecheckRequest  $request
     * @param  \App\Models\Attendancecheck  $attendance_check
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendance_checkRequest $request, Attendancecheck $attendance_check)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendancecheck  $attendance_check
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendancecheck $attendance_check)
    {
        abort_if_forbidden('attendance_log.destroy');
    }
}
