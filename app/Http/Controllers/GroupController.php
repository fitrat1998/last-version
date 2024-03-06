<?php

namespace App\Http\Controllers;

use App\Models\Attendancecheck;
use App\Models\Exercise;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Formofeducation;
use App\Models\Programm;
use App\Models\Educationtype;
use App\Models\Educationyear;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('group.show');

        $users = User::where('id', '!=', auth()->user()->id)->get();

        $faculties = Faculty::all();
        $programms = Programm::all();
        $educationyears = Educationyear::all();
        $educationtypes = Educationtype::all();
        $educationforms = Formofeducation::all();

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }


        return view('pages.groups.index', compact('users', 'groups', 'faculties', 'programms', 'educationyears', 'educationtypes', 'educationforms'));
    }

    public function add()
    {
        abort_if_forbidden('group.create');

        $faculties = Faculty::all();
        $programms = Programm::all();
        $educationyears = Educationyear::all();
        $educationtypes = Educationtype::all();
        $educationforms = Formofeducation::all();


        return view('pages.groups.add', compact('faculties', 'programms', 'educationyears', 'educationtypes', 'educationforms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('group.create');

        $this->validate($request, [
            'group' => ['required'],
        ]);

        $user = auth()->user()->id;

        $group = Group::create([
            'user_id' => $user,
            'name' => $request->get('group'),
        ]);

        return redirect()->route('groupIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

            $idArray = $groups->pluck('id')->toArray();


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
            $idArray = $groups->pluck('id')->toArray();


        }


        $subjects = DB::table('subject_has_group')
            ->whereIn('groups_id', $idArray)
            ->get('subjects_id')
            ->pluck('subjects_id')
            ->toArray();

        if (!empty($subjects)) {
            $subjectDetails = Subject::whereIn('id', $subjects)
                ->get();
            return response()->json($subjectDetails)->header('Content-Type', 'application/json');
        } else {

            return response()->json(['error' => 'Ma\'lumot topilmadi'])->header('Content-Type', 'application/json');
        }

    }

    public function show2(Request $request)
    {
        $id = intval($request->input('id'));

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

            $idArray = $groups->pluck('id')->toArray();


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }


        $id = $groups->pluck('id')->toArray();

        $subjects = DB::table('subject_has_group')
            ->whereIn('groups_id', $id)
            ->get('subjects_id')
            ->pluck('subjects_id')
            ->toArray();

        if (!empty($subjects)) {
            $subjectDetails = Subject::whereIn('id', $subjects)
                ->get();
            return response()->json($subjectDetails)->header('Content-Type', 'application/json');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('group.edit');

        $group = Group::find($id);
        $faculties = Faculty::all();
        $programms = Programm::all();
        $educationyears = Educationyear::all();
        $educationtypes = Educationtype::all();
        $educationforms = Formofeducation::all();

        return view('pages.groups.edit', compact('group', 'faculties', 'programms', 'educationyears', 'educationtypes', 'educationforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateGroupRequest $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if_forbidden('group.edit');

        $group = Group::find($id);
        $group->fill($request->all());
        $group->update([
            'name' => $request->group
        ]);

        return redirect()->route('groupIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('group.destroy');

        $ids = $request->ids;

        $res = Group::whereIn('id', $ids)->delete();
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
        abort_if_forbidden('group.destroy');

        Group::find($id)->delete();
        return redirect()->back();
    }
}
