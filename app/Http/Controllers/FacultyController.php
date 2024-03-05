<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('faculty.show');
        $users = User::where('id','!=',auth()->user()->id)->get();
        $faculties = Faculty::all();


        return view('pages.faculties.index',compact('users','faculties'));
    }

    public function add()
    {
        abort_if_forbidden('faculty.create');

        return view('pages.faculties.add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('faculty.create');

        $this->validate($request,[
            'faculty' => ['required', 'string', 'max:255'],
        ]);


        $faculty = Faculty::create([
            'faculty_name' => $request->get('faculty'),
        ]);

        // $user->assignRole($request->get('roles'));

        // $activity = "\nCreated by: ".json_encode(auth()->user())
        //     ."\nNew User: ".json_encode($user)
        //     ."\nRoles: ".implode(", ",$request->get('roles') ?? []);

        // LogWriter::user_activity($activity,'AddingUsers');

        return redirect()->route('facultyIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefacultyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefacultyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $test = DB::table('teacher_has_group')
            ->select('groups_id')
            ->where('faculties_id',$id)
            // ->where('teachers_id',$user)
            ->get();

        $id = $test->pluck('groups_id')->toArray();

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);

        if ($role[0] == 'teacher') {

        $group = DB::table('teacher_has_group')->where('teachers_id',$t_id->teacher_id)->pluck('groups_id');

        $groups = Group::whereIn('id',$id)->get();

        $idArray = $groups->pluck('id')->toArray();


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }

        return response()->json($groups);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('faculty.edit');

        $faculty = Faculty::find($id);
        return view('pages.faculties.edit',compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefacultyRequest  $request
     * @param  \App\Models\faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if_forbidden('faculty.edit');

        $faculty = Faculty::find($id);
        $faculty->fill($request->all());
        $faculty->update([
            'faculty_name' => $request->faculty,
        ]);

        return redirect()->route('facultyIndex');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\faculty  $faculty
     * @return \Illuminate\Http\Response
     */
      public function deleteAll(Request $request)
        {
            abort_if_forbidden('faculty.destroy');

            $ids = $request->ids;

            $res = Faculty::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('faculty.destroy');

        Faculty::find($id)->delete();
        return redirect()->back();
    }
}
