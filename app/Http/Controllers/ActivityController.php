<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ActivityController extends Controller
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

        $activity = new Activity;

        $activity->activity_type = $request->activity_type;
        $activity->route_id = 1;
        $activity->start_lat = floatval($request->start_lat);
        $activity->start_lng = floatval($request->start_lng);
        $activity->end_lat = floatval($request->end_lat);
        $activity->end_lng = floatval($request->end_lng);
        $activity->highest_altitude = 0;
        $activity->total_distance = floatval($request->total_distance);
        $activity->total_duration = Carbon::createFromFormat('H:i:s', $request->total_duration)->format('H:i:s');
        $activity->calories_burned = 0;
        $activity->start_dt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_dt)->format('Y-m-d H:i:s');
        $activity->end_dt = Carbon::now();

        $activity->save();

        $useractivity = new UserActivity;
        $useractivity->user_id = $request->user_ID;
        $latest = Activity::OrderBy('id', 'desc')->first();
        $useractivity->activity_id = $latest->id;
        $useractivity->save();

        $userevents = UserEvent::where('user_id',  $request->user_ID)->get();

        error_log($userevents);

        foreach($userevents as $userevent){
            $added_distance = $userevent->distance_ran + floatval($request->total_distance);

            if ($added_distance > $userevent->distance){
                $userevent->distance_ran = $userevent->distance;
                $userevent->status = "completed";
                error_log("1");
            }

            else{
                $userevent->distance_ran = $added_distance;
                error_log("2");
            }

            $userevent->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Event succesfully edited']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }

    public function showUserActivities(Request $request, User $user)
    {

        $activities = DB::table('user_activities')->OrderBy('id', 'desc')->where('user_id', $user->id)->get();

        $arr = array();

        foreach($activities as $activity){
            array_push($arr, $activity->activity_id);
        }

        $useractivities = DB::table('activities')->OrderBy('id', 'desc')->whereIn('id', $arr)->take(3)->get();

        return $useractivities->toJson();
    }

    public function showAllUserActivities(Request $request, User $user)
    {

        $activities = DB::table('user_activities')->OrderBy('id', 'desc')->where('user_id', $user->id)->get();

        $arr = array();

        foreach($activities as $activity){
            array_push($arr, $activity->activity_id);
        }

        $useractivities = DB::table('activities')->OrderBy('id', 'desc')->whereIn('id', $arr)->get();

        return $useractivities->toJson();
    }
}
