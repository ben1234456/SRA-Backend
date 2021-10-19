<?php

namespace App\Http\Controllers;

date_default_timezone_set("Asia/Kuala_Lumpur");

use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allEvents = Event::All();
        $eventList = [];
        foreach ($allEvents as $event) {
            $currentDate =  date("Y-m-d");
            if ($event->registration_start <= $currentDate){
                array_push($eventList,$event);
            }
        }
        
        return $eventList;
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
        error_log($request);

        $event = new Event;

        $event->event_name = $request->event_name;
        $event->no_of_participants = 0;
        // $event->start =  Carbon::createFromFormat('Y-m-d', $request->start)->format('Y-m-d');
        // $event->end =  Carbon::createFromFormat('Y-m-d', $request->end)->format('Y-m-d');
        // $event->registration_start =  Carbon::createFromFormat('Y-m-d', $request->regisDate)->format('Y-m-d');
        // $event->registration_end =  Carbon::createFromFormat('Y-m-d', $request->regisDueDate)->format('Y-m-d');
        $event->start =  $request->start;
        $event->end =  $request->end;
        $event->registration_start =  $request->registration_start;
        $event->registration_end =  $request->registration_end;
        $event->description =  $request->description;


        $status = $event->save();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Event succesfully added']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return $event->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->event_name = $request->event_name;
        $event->start =  Carbon::createFromFormat('Y-m-d', $request->start)->format('Y-m-d');
        $event->end =  Carbon::createFromFormat('Y-m-d', $request->end)->format('Y-m-d');
        $event->registration_start =  Carbon::createFromFormat('Y-m-d', $request->regisDate)->format('Y-m-d');
        $event->registration_end =  Carbon::createFromFormat('Y-m-d', $request->regisDueDate)->format('Y-m-d');
        $event->description =  $request->description;


        $status = $event->save();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Event succesfully edited']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {

        error_log("????" + $event);
        
        $status = $event->delete();

        return $event->toJson();
    }

    //get events (excluded registered)
    public function showUserExclusiveEvents(User $user)
    {
        $eventList = [];
        $userID = $user->id;
        $user_events = UserEvent::where('user_id','=', $userID)->get();
        //
        $idList=array();
        foreach($user_events as $event){
        array_push($idList,$event->event_id);
        }
        $user_exclusive_events = Event::whereNotIn('id', $idList)->get();
        foreach ($user_exclusive_events as $event) {
            $currentDate =  date("Y-m-d");
            if ($event->registration_start <= $currentDate){
                array_push($eventList,$event);
            }
        }

        

        // $user_id = $user->id;

        // $user_events = UserEvent::where('user_id', $user_id)->get();

        // $user_exclusive_events = Event::whereNotIn('id', $user_events)->get();

        

        return $eventList;

    }

    //Get coming soon events
    public function showComingSoonEvents()
    {

        $allEvents = Event::All();
        $eventList = [];
        foreach ($allEvents as $event) {
            $currentDate =  date("Y-m-d");
            if ($event->registration_start > $currentDate){
                array_push($eventList,$event);
            }
        }
        
        return $eventList;

    }
    

}
