<?php

namespace App\Http\Controllers;

use App\Models\Attendancecheck;
use App\Models\Exercise;
use App\Models\Lessontype;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Group;
use App\Services\LogWriter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use function PHPUnit\Framework\isNull;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('subject.show');


        $users = User::where('id', '!=', auth()->user()->id)->get();
        $subjects = Subject::all();

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if ($role[0] == 'teacher') {
            $subjects = Subject::where('user_id', $user)->get();
        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $subjects = Subject::all();
        }


        return view('pages.subjects.index', compact('users', 'subjects'));
    }


    public function add()
    {
        abort_if_forbidden('subject.create');

          $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }

        return view('pages.subjects.add', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('subject.create');

        $this->validate($request, [
            'subject_name' => ['required'],
        ]);

        $user = auth()->user()->id;

        $exists = Subject::where('subject_name', trim($request->subject_name))->first();

        if (!$exists) {
            $subject = Subject::create([
                'user_id' => $user,
                'subject_name' => $request->get('subject_name'),
            ]);
        } else {
            return redirect()->route('subjectIndex')->with('success', "Bu fan allaqachon kiritilgan");
        }


        if ($request->groups_id) {
            foreach ($request->groups_id as $g) {
                DB::table('subject_has_group')->insert([
                    'groups_id' => $g,
                    'subjects_id' => $subject->id
                ]);
            }
        }

        return redirect()->route('subjectIndex');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSubjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $exercises = Exercise::where('subjects_id', $id)->select('id', 'title', 'lessontypes_id', 'teachers_id', 'subjects_id')->get();

        $exercises = Exercise::where('subjects_id', '=', $id)
            ->select('exercises.id', 'exercises.title', 'exercises.subjects_id', 'lessontypes.id as lessontypes_id', 'lessontypes.name', 'teachers.id as teachers_id', 'teachers.fullname as fullname')
            ->join('lessontypes', 'exercises.lessontypes_id', '=', 'lessontypes.id')
            ->join('teachers', 'exercises.teachers_id', '=', 'teachers.id')
            ->get();

        return response()->json($exercises);

    }

    public function show2(Request $request)
    {
        $id = $request->input('id');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if ($role[0] == 'teacher') {
            $exercises = Exercise::where('subjects_id', $id)
                ->where('user_id')
                ->select('id', 'title', 'lessontypes_id', 'teachers_id', 'subjects_id')
                ->get();
        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $exercises = Exercise::where('subjects_id', $id)
                ->select('id', 'title', 'lessontypes_id', 'teachers_id', 'subjects_id')
                ->get();
        }


        $exercise_id = Exercise::where('subjects_id', $id)->pluck('id');
        $subjects = Exercise::where('subjects_id', $id)->pluck('subjects_id');
//
//        $absent = Attendancecheck::where('exercises_id', $exercise_id)
//            ->where('subjects_id', $subjects)
//            ->get();
//
//        $student_id = Attendancecheck::where('exercises_id', $exercise_id)
//            ->where('subjects_id', $subjects)
//            ->get('students_id');
//
//        $student = Student::whereIn('id', $student_id)->get();
//
//        $absentArray = $absent->toArray();
//
//
//        $studentArray = $student->toArray();
//
//
//        $mergedArray = array_merge($absentArray, $studentArray);

        $absent_students = Attendancecheck::where('exercises_id', $exercise_id)
            ->where('subjects_id', $subjects)
            ->join('students', 'attendance_checks.students_id', '=', 'students.id')
            ->get();

        $merged_data = Attendancecheck::where('attendance_checks.subjects_id', $subjects)
            ->where('attendance_checks.exercises_id', $exercise_id)
            ->leftJoin('students', 'attendance_checks.students_id', '=', 'students.id')
            ->leftJoin('exercises', 'attendance_checks.exercises_id', '=', 'exercises.id')
            ->leftJoin('lessontypes', 'exercises.lessontypes_id', '=', 'lessontypes.id')
            ->leftJoin('teachers', 'exercises.teachers_id', '=', 'teachers.id')
            ->select(
                'attendance_checks.id as attendance_check_id',
                'students.id as student_id',
                'students.fullname as student_name',
                'exercises.id as exercise_id',
                'exercises.title as exercise_title',
                'exercises.lessontypes_id',
                'lessontypes.name as name',
                'teachers.fullname as teacher_name',
                'attendance_checks.absent as absent',
                'attendance_checks.created_at as absent_date',
            )
            ->get();


//        $exercises = Attendancecheck::where('subjects_id',$id);
//
//
        return response()->json($merged_data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        abort_if_forbidden('subject.edit');

        $groups = Group::all();
        $subject = Subject::findOrFail($id);

        return view('pages.subjects.edit', compact('subject', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSubjectRequest $request
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        abort_if_forbidden('subject.edit');

        $subject = Subject::find($id);
        $subject->fill($request->all());
        $subject->update([
            'subject_name' => $request->subject_name,
        ]);

        DB::table('subject_has_group')
            ->where('subjects_id', '=', $id)
            ->delete();

        if ($request->groups_id) {
            foreach ($request->groups_id as $g) {
                DB::table('subject_has_group')->insert([
                    'groups_id' => $g,
                    'subjects_id' => $id
                ]);
            }
        }

        return redirect()->route('subjectIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function deleteAll(Request $request)
    {

        $ids = $request->ids;


        $res = subject::whereIn('id', $ids)->delete();
        if ($res) {
            return response()->json([
                'success' => true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "This delete action failed!"
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        Subject::find($id)->delete();
        return redirect()->back();
    }
}
