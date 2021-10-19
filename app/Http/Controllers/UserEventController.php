<?php

namespace App\Http\Controllers;

use App\Models\UserEvent;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserEventController extends Controller
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

        $userevent = new UserEvent;

        $userevent->user_id = $request->user_id;
        $userevent->event_id = $request->event_id;
        $userevent->registration_dt = Carbon::now();
        $userevent->distance = floatval($request->distance);
        $userevent->distance_ran = 0;
        $userevent->status = 'in-progress';

        $userevent->save();

        $event = Event::where('id', $request->event_id)->first();
        $event->no_of_participants += 1;
        $event->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function show($userEvent)
    {
        $userevent = UserEvent::where('id',$userEvent)->first();
        return $userevent->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEvent $userEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserEvent $userEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserEvent $userEvent)
    {
        //
    }

    public function showUserEvents(Request $request, User $user)
    {

        $userevents = UserEvent::where('user_id', $user->id)->get();

        foreach($userevents as $userevent){
            $event = Event::where('id', '=', $userevent->event_id)->first();
            $userevent->event_id= $event->id;
            $userevent->start_date = $event->start;
            $userevent->end_date = $event->end;
            $userevent->event_name = $event->event_name;
        }

        return $userevents->toJson();
    }
    public function getEventParticipateCount()
    {

        $userevents = UserEvent::get();
        $countList=[];
        foreach($userevents as $userevent){
            $user = User::where('id', '=', $userevent->user_id)->first();
            array_push($countList,$user->city);
        }

        return $countList;
    }
}
