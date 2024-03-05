<?php

namespace App\Http\Controllers;

use App\Models\Examtype;
use App\Http\Requests\StoreExamtypeRequest;
use App\Http\Requests\UpdateExamtypeRequest;
use Illuminate\Http\Request;


class ExamtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('examtype.show');

        $examtypes = Examtype::all();
        return view('pages.examtypes.index',compact('examtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('examtype.create');

        return view('pages.examtypes.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExamtypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamtypeRequest $request)
    {
        abort_if_forbidden('examtype.create');

        $examtypes = Examtype::create([
            'name' => $request->get('examtypes'),
        ]);

        return redirect()->route('examtypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examtype  $examtype
     * @return \Illuminate\Http\Response
     */
    public function show(Examtype $examtype)
    {
        //
    }

    public function show2(Request $request)
    {
        return response()->json($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examtype  $examtype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('examtype.edit');

        $examtypes = Examtype::find($id);
        return view('pages.examtypes.edit', compact('examtypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExamtypeRequest  $request
     * @param  \App\Models\Examtype  $examtype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamtypeRequest $request,$id)
    {
        abort_if_forbidden('examtype.edit');

        $examtypes = Examtype::find($id);
        $examtypes->fill($request->all());
        $examtypes->update([
            'name' => $request->examtypes,
        ]);

        return redirect()->route('examtypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examtype  $examtype
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('examtype.destroy');


        $ids = $request->ids;

        $res = Examtype::whereIn('id',$ids)->delete();
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

    public function destroy(Examtype $examtype)
    {
        abort_if_forbidden('examtype.destroy');

        Examtype::find($id)->delete();
        return redirect()->back();
    }
}
