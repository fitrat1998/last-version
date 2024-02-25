<?php

namespace App\Http\Controllers;

use App\Models\Formofeducation;
use App\Http\Requests\StoreFormofeducationRequest;
use App\Http\Requests\UpdateFormofeducationRequest;
use App\Models\User;
use App\Models\Faculty;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FormofeducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('formofeducation.show');

        $faculties = Faculty::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $forms = Formofeducation::all();

        return view('pages.formofeducations.index',compact('users','forms'));
    }

    public function add()
    {
        abort_if_forbidden('formofeducation.create');

        return view('pages.formofeducations.add');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if_forbidden('formofeducation.create');

        $this->validate($request,[
            'form' => ['required'],

        ]);


        $group = Formofeducation::create([
            'form' => $request->get('form'),

        ]);

        // $user->assignRole($request->get('roles'));

        // $activity = "\nCreated by: ".json_encode(auth()->user())
        //     ."\nNew User: ".json_encode($user)
        //     ."\nRoles: ".implode(", ",$request->get('roles') ?? []);

        // LogWriter::user_activity($activity,'AddingUsers');

        return redirect()->route('formofeducationIndex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormofeducationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormofeducationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formofeducation  $formofeducation
     * @return \Illuminate\Http\Response
     */
    public function show(Formofeducation $formofeducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formofeducation  $formofeducation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('formofeducation.edit');

        $forms = Formofeducation::find($id);

        return view('pages.formofeducations.edit',compact('forms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormofeducationRequest  $request
     * @param  \App\Models\Formofeducation  $formofeducation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if_forbidden('formofeducation.edit');

        $form = Formofeducation::find($id);
        $form->fill($request->all());
        $form->update([
            'form' => $request->form,
        ]);

        return redirect()->route('formofeducationIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formofeducation  $formofeducation
     * @return \Illuminate\Http\Response
     */
      public function deleteAll(Request $request)
        {
            abort_if_forbidden('formofeducation.destroy');

            $ids = $request->ids;
            
            $res = Formofeducation::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('formofeducation.destroy');

        Formofeducation::find($id)->delete();
        return redirect()->back();
    }
}
