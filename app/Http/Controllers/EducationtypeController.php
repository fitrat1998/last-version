<?php

namespace App\Http\Controllers;

use App\Models\Educationtype;
use App\Http\Requests\StoreEducationtypeRequest;
use App\Http\Requests\UpdateEducationtypeRequest;
use App\Models\User;
use App\Models\Faculty;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EducationtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('educationtype.show')
        ;
        $faculties = Faculty::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $educationtypes = Educationtype::all();

        return view('pages.educationtypes.index',compact('users','educationtypes'));
    }

    public function add()
    {
        abort_if_forbidden('educationtype.create');

        return view('pages.educationtypes.add');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('educationtype.create');

        $this->validate($request,[
            'education_type' => ['required'],
        ]);

        $education_type = Educationtype::create([
            'education_type' => $request->get('education_type'),

        ]);

        return redirect()->route('educationtypeIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdmissiondateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmissiondateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admissiondate  $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function show(Admissiondate $admissiondate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admissiondate  $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('educationtype.edit');

        $educationtype = Educationtype::find($id);

        return view('pages.educationtypes.edit',compact('educationtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdmissiondateRequest  $request
     * @param  \App\Models\Admissiondate  $admissiondate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if_forbidden('educationtype.edit');

        $educationtype = Educationtype::find($id);
        $educationtype->fill($request->all());
        $educationtype->update([
            'education_type' => $request->education_type,
        ]);

        return redirect()->route('educationtypeIndex');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Educationtype  $educationtype
     * @return \Illuminate\Http\Response
     */
      public function deleteAll(Request $request)
      {
            abort_if_forbidden('educationtype.destroy');

            $ids = $request->ids;
            
            $res = Educationtype::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('educationtype.destroy');

        Educationtype::find($id)->delete();
        return redirect()->back();
    }
}
