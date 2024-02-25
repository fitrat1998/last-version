<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lessontype;
use App\Http\Requests\StoreLessontypeRequest;
use App\Http\Requests\UpdateLessontypeRequest;

class LessontypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('lessontype.show');

        $users = User::where('id','!=',auth()->user()->id)->get();
        $lessontypes = Lessontype::all();
        return view('pages.lessontypes.index',compact('users','lessontypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('lessontype.create');

        $users = User::where('id','!=',auth()->user()->id)->get();
        return view('pages.lessontypes.add',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessontypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessontypeRequest $request)
    {
        abort_if_forbidden('lessontype.create');

        $lessontype = Lessontype::create([
            'name' => $request->get('lessontypes'),
        ]);

        return redirect()->route('lessontypes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lessontype  $lessontype
     * @return \Illuminate\Http\Response
     */
    public function show(Lessontype $lessontype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lessontype  $lessontype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('lessontype.edit');

        $lessontypes = Lessontype::find($id);
        return view('pages.lessontypes.edit',compact('lessontypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLessontypeRequest  $request
     * @param  \App\Models\Lessontype  $lessontype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessontypeRequest $request,$id)
    {
        abort_if_forbidden('lessontype.edit');

        $lessontypes = Lessontype::find($id);
        $lessontypes->fill($request->all());
        $lessontypes->update([
            'name' => $request->lessontypes,
        ]);

        return redirect()->route('lessontypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lessontype  $lessontype
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if_forbidden('lessontype.destroy');

        Lessontype::find($id)->delete();
        return redirect()->back();
    }
}
