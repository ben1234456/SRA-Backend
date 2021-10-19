<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDistance;
use Illuminate\Http\Request;

class EventDistanceController extends Controller
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
        error_log($request);

        $latestevent = Event::latest()->first();
        $latestid = $latestevent->id;

        for ($i = 0; $i < count($request->distance); $i++){
            $eventDistance = new EventDistance;
            $eventDistance->event_id = $latestid;
            $eventDistance->distance = floatval($request->distance[$i]["text"]);
            $eventDistance->fee = floatval($request->fee[$i]["text"]);
            $eventDistance->save();
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventDistance  $eventDistance
     * @return \Illuminate\Http\Response
     */
    public function show(EventDistance $eventDistance)
    {
        return $eventDistance->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventDistance  $eventDistance
     * @return \Illuminate\Http\Response
     */
    public function edit(EventDistance $eventDistance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventDistance  $eventDistance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventDistance $eventDistance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventDistance  $eventDistance
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventDistance $eventDistance)
    {
        //
    }

    public function showEventDistances(Request $request, Event $event){
        $eventDistances = EventDistance::where('event_id', $event->id)->get();
        
        error_log($event);
        error_log($eventDistances);
        return $eventDistances->toJson();
    }

    public function updateDistanceFee(Request $request){

        error_log($request);

        for ($i = 0; $i < count($request->distanceFee); $i++){
            $eventDistance = EventDistance::where('id', $request->distanceFee[$i]["id"])->first();
            $eventDistance->distance = $request->distanceFee[$i]["distance"];
            $eventDistance->fee= $request->distanceFee[$i]["fee"];
            $eventDistance->save();
        }

        return response()->json(['status' => 'success']);
    }

    
}
