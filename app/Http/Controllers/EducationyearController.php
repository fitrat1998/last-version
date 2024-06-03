<?php

namespace App\Http\Controllers;

use App\Models\Educationyear;
use App\Http\Requests\StoreAdmissiondateRequest;
use App\Http\Requests\UpdateAdmissiondateRequest;
use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use App\Models\Faculty;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EducationyearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('educationyear.show');

        $faculties = Faculty::all();
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $educationyears = Educationyear::all();

        return view('pages.educationyears.index', compact('users', 'educationyears'));
    }

    public function add()
    {
        abort_if_forbidden('educationyear.create');

        return view('pages.educationyears.add');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('educationyear.create');

        $this->validate($request, [
            'education_year' => ['required'],
        ]);

        $education_year = Educationyear::create([
            'education_year' => $request->get('education_year'),

        ]);

        return redirect()->route('educationyearIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreAdmissiondateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmissiondateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Admissiondate $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $groups = Group::where('educationyear_id', '=', $id)->get();

        return response()->json($groups)->header('Content-Type', 'application/json');
    }

    public function show2(Request $request)
    {
        $subject_id = $request->input('id');
        $group_id = $request->input('group_id');
        $programm_id = $request->input('programm_id');
//        $groups = Group::where('educationyear_id', '=', $subject_id)->get();

      $groups = DB::table('subject_has_group')->where('subjects_id', $subject_id)
          ->where('groups_id',  $group_id)
          ->get()
          ->pluck('groups_id');

        $educationyear_id = DB::table('student_has_attach')
            ->where('groups_id', $group_id)
            ->pluck('educationyears_id')
            ->unique();

        $educationyear = Educationyear::whereIn('id',$educationyear_id)->get();

        return response()->json($educationyear)->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Admissiondate $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('educationyear.edit');

        $educationyear = Educationyear::find($id);

        return view('pages.educationyears.edit', compact('educationyear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAdmissiondateRequest $request
     * @param \App\Models\Admissiondate $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if_forbidden('educationyear.edit');

        $educationyear = Educationyear::find($id);
        $educationyear->fill($request->all());
        $educationyear->update([
            'education_year' => $request->education_year,
        ]);

        return redirect()->route('educationyearIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Admissiondate $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {

        abort_if_forbidden('educationyear.destroy');

        $ids = $request->ids;

        $res = Educationyear::whereIn('id', $ids)->delete();
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

    public function destroy($id)
    {
        abort_if_forbidden('educationyear.destroy');

        Educationyear::find($id)->delete();
        return redirect()->back();
    }
}
