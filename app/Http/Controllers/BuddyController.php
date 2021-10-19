<?php

namespace App\Http\Controllers;

use App\Models\Buddy;
use App\Models\User;
use Illuminate\Http\Request;

class BuddyController extends Controller
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
        $buddy=new Buddy;
        $buddy1=new Buddy;
        //current user id
        $buddy->userID = $request->userID;
        $buddy1->userID = $request->buddyID;
        //buddy user id
        $buddy->buddyID = $request->buddyID;
        $buddy1->buddyID = $request->userID;
        return ($buddy->save() and $buddy1->save());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buddy  $buddy
     * @return \Illuminate\Http\Response
     */
    public function show(Buddy $buddy)
    {
        //
        return $buddy->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buddy  $buddy
     * @return \Illuminate\Http\Response
     */
    public function edit(Buddy $buddy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buddy  $buddy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buddy $buddy)
    {
        //
        $buddy->buddyID = $request->buddyID;
        $buddy->userID = $request->userID;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buddy  $buddy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buddy $buddy)
    {
        //
        return $buddy->delete();
    }
    public function searchUserBuddyList(User $user)
    {
        
        $userID = $user->id;
        $buddies=Buddy::where("userID","=",$userID)->get();
        // 
        $idList=array();
        foreach($buddies as $buddy){
            array_push($idList,$buddy->buddyID);
        }
        $buddyList = User::whereIn('id', $idList)->get();
        return $buddyList;
    }
    public function searchBuddyByName(User $user,string $userName)
    {

        $userID = $user->id;
        $keyword="%".$userName."%";
        $buddies=Buddy::where("userID","=",$userID)->get();
        // 
        $idList=array();
        foreach($buddies as $buddy){
            array_push($idList,$buddy->buddyID);
        }
        $buddyList = User::where("first_name","LIKE",$keyword)->whereIn('id', $idList)->get();
        return $buddyList;

    }
    public function getID(User $user,User $buddy)
    {
        $userID=$user->id;

        $buddyID=$buddy->id;

        $buddyGet=Buddy::where("buddyID","=",$buddyID)->where("userID","=",$userID)->first();

        return $buddyGet->toJson();
    }
}
