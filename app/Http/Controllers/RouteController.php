<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;

class RouteController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        error_log($request);
        $route=new Route();
        $route->userID = $request->userID;
        $route->name = $request->name;
        $route->start_lat = $request->start_lat;
        $route->end_lat = $request->end_lat;
        $route->start_lng = $request->start_lng;
        $route->end_lng = $request->end_lng;
        $route->check1_lat = $request->check1_lat;
        $route->check2_lat = $request->check2_lat;
        $route->check1_lng = $request->check1_lng;
        $route->check2_lng = $request->check2_lng;
        $route->total_distance = $request->total_distance;

        return $route->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        //
        return $route->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        //
        $route->userID = $request->userID;
        $route->name = $request->name;
        $route->start_lat = $request->start_lat;
        $route->end_lat = $request->end_lat;
        $route->start_lng = $request->start_lng;
        $route->end_lng = $request->end_lng;
        $route->check1_lat = $request->check1_lat;
        $route->check2_lat = $request->check2_lat;
        $route->check1_lng = $request->check1_lng;
        $route->check2_lng = $request->check2_lng;
        $route->total_distance = $request->total_distance;
        return $route->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        //
        error_log($route);
        $status = $route->delete();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }
    public function searchUserRouteList(User $user){

        $userID=$user->id;

        $routeGet=Route::where("userID","=",$userID)->get();

        return $routeGet->toJson();
    }
    public function searchRoute($id){
        
        

        $routeGet=Route::where("id","=",$id)->get();

        return $routeGet->toJson();
    }
    public function searchAdminRoute(){

        $adminGet=User::where("role","=","admin")->get();

        $idList=array();
        foreach($adminGet as $admin){
            array_push($idList,$admin->id);
        }
        $adminRoute = Route::whereIn('userID', $idList)->get();
        return $adminRoute->toJson();
    }
}
