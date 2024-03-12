<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Programm;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use App\Models\Educationtype;
use App\Models\Formofeducation;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\ImportStudent;
use Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('student.show');


        $users = User::where('id', '!=', auth()->user()->id)->get();
        $faculties = Faculty::all();
        $groups = Group::all();
        $programms = Programm::all();
        $educationforms = Formofeducation::all();
        $educationtypes = Educationtype::all();
        // $topics = Topic::all();

        $role =  auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        if($role[0] == 'teacher'){
            $students = Student::where('user_id',$user)->get();
        }
        else if(auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $students = Student::all();
        }

        return view('pages.students.index', compact('users', 'students', 'faculties', 'groups', 'educationforms', 'educationtypes', 'programms'));
    }

    public function add()
    {
        abort_if_forbidden('student.create');

        $faculties = Faculty::all();
        $groups = Group::all();
        $programms = Programm::all();
        $educationforms = Formofeducation::all();
        $educationtypes = Educationtype::all();

        return view('pages.students.add', compact('faculties', 'groups', 'educationforms', 'educationtypes', 'programms'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(StoreStudentRequest $request)
    {
        abort_if_forbidden('student.create');

//         dd($request);

        $studentRole = Role::where('name', 'Student')->first();

        if (!$studentRole) {
            $studentRole = Role::create([
                'name' => 'Student',
                'title' => 'Role for student',
            ]);
        }
        $name = "";


        if ($request->hasfile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $photo = $request->file('photo')->storeAs('public/user-photos', $name);
        }

        $user = auth()->user()->id;

        $student = Student::create([
            'user_id' => $user ,
            'fullname' => $request->get('fullname'),
            'photo' => $name ?? null,
            'programm_id' => $request->get('programm_id'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'login' => $request->get('login'),
            'password' => Hash::make($request->get('password')),
        ]);



        $user = User::create([
            'login' => $request->get('login'),
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('fullname'),
            'student_id' => $student->id,
            'theme' => 'default'
        ]);

        $user->roles()->attach($studentRole->id);

        return redirect()->route('studentIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Student $student
     *
     */
    public function edit(Student $student, $id)
    {
        abort_if_forbidden('student.edit');

        $student = Student::find($id);
        $groups = Group::all();
        $faculties = Faculty::all();
        $programms = Programm::all();
        $educationtypes = Educationtype::all();
        $educationforms = Formofeducation::all();

        return view('pages.students.edit', compact('student', 'faculties', 'programms', 'groups', 'educationtypes', 'educationforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateStudentRequest $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateStudentRequest $request, Student $student, $id)
    {
        abort_if_forbidden('student.edit');

        $student = Student::find($id);
        $name = $student->photo;
        if ($request->hasfile('photo')) {

            if (isset($student->photo)) {
                Storage::delete('public/user-photos/' . $student->photo);
            }

            $name = $request->file('photo')->getClientOriginalName();
            $photo = $request->file('photo')->storeAs('public/user-photos', $name);
        }

        $student = Student::find($id);
        $student->fill($request->all());
        $student->update([
            'fullname'          => $request->get('fullname'),
            'photo'             => $name ?? null,
            'programm_id'       => $request->get('programm_id'),
            'email'             => $request->get('email'),
            'phone'             => $request->get('phone'),
            'login'             => $request->get('login'),
            'password'          => Hash::make($request->get('password')),
        ]);

        $u_id = User::where('student_id',$student->id)->first();

        User::where('student_id',$u_id->student_id)->update([
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('fullname'),
            'student_id' => $student->id,
            'theme' => 'default'
        ]);

        return redirect()->route('studentIndex')->with('success', "Student muofaqiyatli taxrirlandi");

    }

    public function import(Request $request)
    {
        abort_if_forbidden('student.create');

        $programm = Programm::all();

//        dd($request);
        $student = Excel::import(new ImportStudent,$request->file('excel'));


        if($student){
                    return redirect()->route('studentIndex')->with('success', 'Talabalar muvvafaqiyatli yuklandi');

        }
//
//        $data = Excel::toArray(new ImportStudent(), $request->file('excel')->getRealPath());
//
//        for ($i = 0; $i < count($data); $i++) {
//            for ($j = 0; $j < count($programm); $j++) {
//                if (isset($data[$i][$j]['yonalish']) && isset($programm[$j]['programm_name'])) {
//                    if ($data[$i][$j]['yonalish'] == $programm[$j]['programm_name']) {
//                        $data[$i][$j]['program_id'] = $programm[$j]['yonalish_id'];
//                    }
//                }
//            }
//        }
//
//        dd($data);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('student.destroy');

        $ids = $request->ids;

        $res = Student::whereIn('id',$ids)->delete();
        User::whereIn('student_id',$ids)->delete();

        DB::table('student_has_attach')->whereIn('students_id',$ids)->delete();

        if($res){
            return response()->json([
                'success'=>true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success'=>false,
            "message" => "This delete action failed!"
        ]);
    }

    public function destroy($id)
    {
        abort_if_forbidden('student.destroy');

        Student::find($id)->delete();
        User::where('student_id',$id)->delete();
        DB::table('student_has_attach')->where('students_id',$id)->delete();
        return redirect()->back();
    }
}
