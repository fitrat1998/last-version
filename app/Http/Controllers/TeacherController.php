<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use App\Models\Topic;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Imports\ImportTeacher;
use Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('teacher.show');

        $teachers = Teacher::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $topics = Topic::all();
        $subjects = Subject::all();
        $groups = Group::all();
        $faculties = Faculty::all();

        return view('pages.teachers.index',compact('teachers','groups','subjects','faculties','topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('teacher.create');

        $faculties = Faculty::all();

        return view('pages.teachers.add',compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeacherRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTeacherRequest $request)
    {
        abort_if_forbidden('teacher.create');

        $name = "";

        if($request->hasfile('photo')){
            $name = $request->file('photo')->getClientOriginalName();
            $photo = $request->file('photo')->storeAs('public/teacher-photos',$name);
        }

        $teacher = Teacher::create([
            'fullname' => $request->get('fullname'),
            'faculties_id' => $request->get('faculties_id'),
            'status' => $request->get('status'),
            'photo' => $name ?? null,
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'login' => $request->get('login'),
            'password' => Hash::make($request->get('password')),
        ]);

        User::create([
            'login'     => $request->get('login'),
            'password'  => Hash::make($request->get('password')),
            'name'      => $request->get('fullname'),
            'teacher_id'=> $teacher->id,
            'theme'     => 'default'
        ]);

        return redirect()->route('teachers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('teacher.edit');

        $teacher = Teacher::find($id);
        $faculties = Faculty::all();

        return view('pages.teachers.edit',compact('teacher','faculties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeacherRequest  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, $id)
    {
        abort_if_forbidden('teacher.edit');

        $teacher = Teacher::find($id);
        $name = $teacher->photo;
        if($request->hasfile('photo')){

            if(isset($teacher->photo)){
                Storage::delete('public/user-photos/' . $teacher->photo);
            }

            $name = $request->file('photo')->getClientOriginalName();
            $photo = $request->file('photo')->storeAs('public/teacher-photos',$name);
        }


        $teacher = Teacher::find($id);
        $teacher->fill($request->all());
        $teacher->update([
            'fullname' => $request->fullname,
            'status' => $request->status,
            'faculties_id' => $request->faculties_id,
            'photo' => $name,
            'email' => $request->email,
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ]);

        User::where('teacher_id',$teacher->id)->update([
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('fullname'),
            'student_id' => $teacher->id,
            'theme' => 'default'
        ]);

        return redirect()->route('teachers.index');
    }

     public function import(Request $request)
    {
        abort_if_forbidden('teacher.create');

        $teachers = Excel::import(new ImportTeacher,$request->file('excel'));

        if($teachers){
            return redirect()->route('teachers.index')->with('success', 'O`qituvchilar muvvafaqiyatli yuklandi');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('teacher.destroy');

        $ids = $request->ids;

        $res = Teacher::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('teacher.destroy');

        Teacher::find($id)->delete();
        return redirect()->back();
    }
}
