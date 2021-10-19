<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        error_log($request);
        $calendar=new Calendar();
        $calendar->userID = $request->userID;
        $calendar->time = $request->time;
        
        $calendar->title = $request->title;
        $calendar->date = $request->date;
        return $calendar->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
        return $calendar->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
        $calendar->userID = $request->userID;
        $calendar->time = $request->time;
        $calendar->title = $request->title;
        $calendar->date = $request->date;
        return $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        //
        error_log($calendar);
        $status = $calendar->delete();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }
    public function searchUserCalendarList(User $user)
    {
        $userID=$user->id;

        $calendarGet=Calendar::where("userID","=",$userID)->orderBy("time","ASC")->get();

        return $calendarGet->toJson();
    }
}
