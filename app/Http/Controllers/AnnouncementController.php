<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use Illuminate\Http\Request;


class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('announcement.show');

        $announcements = Announcement::all();
        return view('pages.announcements.index',compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('announcement.create');

        return view('pages.announcements.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnnouncementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnouncementRequest $request)
    {
        abort_if_forbidden('announcement.create');

        $announcemen = Announcement::create([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->route('announcements.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('announcement.edit');

        $announcement = Announcement::find($id);

        return view('pages.announcements.edit',compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnnouncementRequest  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnnouncementRequest $request,$id)
    {
        abort_if_forbidden('announcement.edit');

        $announcement = Announcement::find($id);

        $announcement->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->route('announcements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
    
        $ids = $request->ids;

        $res = Announcement::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('announcement.destroy');

        Announcement::find($id)->delete();
        return redirect()->back();
    }
}
