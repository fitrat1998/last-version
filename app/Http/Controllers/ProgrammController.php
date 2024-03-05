<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Programm;
use App\Http\Requests\StoreProgrammRequest;
use App\Http\Requests\UpdateProgrammRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Faculty;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProgrammController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('programm.show');

        $faculties = Faculty::all();
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $programms = Programm::all();

        return view('pages.programms.index', compact('users', 'programms', 'faculties'));
    }

    public function add()
    {
        abort_if_forbidden('programm.create');

        $faculties = Faculty::all();
        return view('pages.programms.add', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('programm.create');

        $this->validate($request, [
            'programm' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required'],
        ]);


        $programm = Programm::create([
            'programm_name' => $request->get('programm'),
            'faculty_id' => $request->get('faculty_id'),
        ]);

        // $user->assignRole($request->get('roles'));

        // $activity = "\nCreated by: ".json_encode(auth()->user())
        //     ."\nNew User: ".json_encode($user)
        //     ."\nRoles: ".implode(", ",$request->get('roles') ?? []);

        // LogWriter::user_activity($activity,'AddingUsers');

        return redirect()->route('programmIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProgrammRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgrammRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Programm $programm
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = intval($request->input('id'));

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();



        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }



        return response()->json($groups);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Programm $programm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('programm.edit');

        $programm = Programm::find($id);
        $programms = Programm::all();
        $faculties = Faculty::all();

        return view('pages.programms.edit', compact('programm', 'programms', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProgrammRequest $request
     * @param \App\Models\Programm $programm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programm $programm, $id)
    {
        abort_if_forbidden('programm.edit');

        $programm = Programm::find($id);
        $programm->fill($request->all());
        $programm->update([
            'programm_name' => $request->programm_name,
            'faculty_id' => $request->faculty_id,
        ]);

        return redirect()->route('programmIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Programm $programm
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('programm.destroy');

        $ids = $request->ids;

        $res = Programm::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('programm.destroy');

        Programm::where('id', $id)->delete();
        return redirect()->back();
    }


}
