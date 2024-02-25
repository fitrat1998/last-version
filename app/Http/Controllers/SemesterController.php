<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\User;
use App\Models\Faculty;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('semseter.show');

        $faculties = Faculty::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $semesters = Semester::all();

        return view('pages.semesters.index',compact('users','semesters'));
    }

    public function add()
    {
        abort_if_forbidden('semester.create');

        return view('pages.semesters.add');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('semester.create');

        $this->validate($request,[
            'semester_number' => ['required'],
        ]);

        $semester_number = Semester::create([
            'semester_number' => $request->get('semester_number'),

        ]);

        return redirect()->route('semesterIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSemesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSemesterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Semester  $Semester
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $Semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('semester.edit');

        $semester = Semester::find($id);

        return view('pages.semesters.edit',compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSemesterRequest  $request
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if_forbidden('semester.destroy');

        $semester = Semester::find($id);
        $semester->fill($request->all());
        $semester->update([
            'semester_number' => $request->semester_number,
        ]);

        return redirect()->route('semesterIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('semester.destroy');

        $ids = $request->ids;
        
        $res = Semester::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('semseter.destroy');

        Semester::find($id)->delete();
        return redirect()->back();
    }
}
