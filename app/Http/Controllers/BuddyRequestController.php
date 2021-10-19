<?php

namespace App\Http\Controllers;

use App\Models\Buddy;
use App\Models\User;
use App\Models\BuddyRequest;
use Illuminate\Http\Request;

class BuddyRequestController extends Controller
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
        $buddyReq=new BuddyRequest();
        //reciever id
        $buddyReq->userID = $request->userID;
        //sender id
        $buddyReq->buddyID = $request->buddyID;
        $buddyReq->status = "pending";
        return $buddyReq->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuddyRequest  $buddyRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BuddyRequest $buddyRequest)
    {
        //
        return $buddyRequest->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuddyRequest  $buddyRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuddyRequest $buddyRequest)
    {
        //
        $buddyRequest->userID = $request->userID;
        $buddyRequest->buddyID = $request->buddyID;
        $buddyRequest->status = $request->status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuddyRequest  $buddyRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuddyRequest $buddyRequest)
    {
        //

        error_log($buddyRequest);
        $status = $buddyRequest->delete();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }
    public function searchUserBuddyReqList(User $user)
    {
        
        $userID = $user->id;
        $buddies=BuddyRequest::where("buddyID","=",$userID)->get();
        // 
        $idList=array();
        foreach($buddies as $buddy){
            array_push($idList,$buddy->userID);
        }
        $buddyList = User::whereIn('id', $idList)->get();
        return $buddyList;
    }
    public function getID(User $user,User $buddy)
    {
        $userID=$user->id;

        $buddyID=$buddy->id;

        $buddyReqGet=BuddyRequest::where("buddyID","=",$buddyID)->where("userID","=",$userID)->first();

        return $buddyReqGet->toJson();
    }
    // public function deleteBuddyReqByID(User $buddy,User $user)
    // {

    //     $userID=$user->id;

    //     $buddyID=$buddy->id;

    //     $buddyReqGet=BuddyRequest::where("buddyID","=",$buddyID)->where("userID","=",$userID)->get();

    //     $buddyReqGet->delete();

    //     return $buddy->toJson();
    // }
    public function deleteBuddyReqByID($id)
    {
        

        $buddyRequest=BuddyRequest::where("id",$id)->first();
        $status = $buddyRequest->delete();
        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }

    
    }
}
