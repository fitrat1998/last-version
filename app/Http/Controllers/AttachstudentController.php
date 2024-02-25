<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Programm;
use App\Models\Semester;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use App\Models\Attachstudent;
use App\Models\Educationtype;
use App\Models\Educationyear;
use App\Models\Formofeducation;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAttachstudentRequest;
use App\Http\Requests\UpdateAttachstudentRequest;

class AttachstudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('student.show');

        $students = Student::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $faculties = Faculty::all();
        $groups = Group::all();
        $semesters = Semester::all();
        $programms = Programm::all();
        $educationforms = Formofeducation::all();
        $educationtypes = Educationtype::all();
        $educationyears = Educationyear::all();
        // $topics = Topic::all();

        return view('pages.students.attach',compact('semesters','educationyears','users','students','faculties','groups','educationforms','educationtypes','programms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttachstudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachstudentRequest $request)
    {
        abort_if_forbidden('student.create');

        $students = $request->input('students_id');
        $faculties = $request->input('faculties_id');
        $educationTypes = $request->input('educationtypes_id');
        $groups = $request->input('groups_id');
        $educationYears = $request->input('educationyears_id');
        $semesters = $request->input('semesters_id');


        foreach ($students as $student) {
            DB::table('student_has_attach')->insert([
                'students_id' => $student,
                'faculties_id' => $faculties, // Faqatgina birinchi elementni olish
                'educationtypes_id' => $educationTypes,
                'groups_id' => $groups,
                'educationyears_id' => $educationYears,
                'semesters_id' => $semesters,
            ]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attachstudent  $attachstudent
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $students = Student::where('programm_id', $id)
            ->select('id', 'fullname', 'programm_id')
            ->get();

        $studentIds = [];

        foreach ($students as $student) {
            $studentIds[] = $student->id;
        }

        $exists = DB::table('student_has_attach')
            ->whereIn('students_id',$studentIds)
            ->get();

        // if (!empty($students) && array_intersect($students->pluck('id')->toArray(), $exists)){

        if (!empty($students)){
            foreach ($students as $s) {
                $programName = Programm::find($s->programm_id)->programm_name;
                $s->programm_id = $programName;  
            }

            return response()->json($students);
        }
         else {
            $data = ['id' => 'student yuq','id' => 'student yuq','id' => 'student yuq','id' => 'student yuq'];
            return response()->json($data);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attachstudent  $attachstudent
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachstudent $attachstudent)
    {
               abort_if_forbidden('announcement.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttachstudentRequest  $request
     * @param  \App\Models\Attachstudent  $attachstudent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttachstudentRequest $request, Attachstudent $attachstudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attachstudent  $attachstudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachstudent $attachstudent)
    {
        abort_if_forbidden('announcement.destroy');
    }
}
