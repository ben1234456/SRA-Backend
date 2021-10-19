<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use App\Models\User;
use Illuminate\Http\Request;

class PostLikeController extends Controller
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
        $like=new PostLike();
        //reciever id
        $like->user_id = $request->user_id;
        //sender id
        $like->post_id = $request->post_id;
        $status = $like->save();

        if($status){
            return response()->json(['status' => 'success']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function show(PostLike $postLike)
    {
        return $postLike->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function edit(PostLike $postLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostLike $postLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostLike  $postLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostLike $postLike)
    {
        //
        error_log($postLike);
        $status = $postLike->delete();

        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }
    public function searchLikeId($user, $post){

        $likeGet=PostLike::where("post_id","=",$post)->where("user_id","=",$user)->first();

        

        return $likeGet->toJson();
    }
    public function deleteLikeById($id)
    {
        

        $like=PostLike::where("id",$id)->first();
        $status = $like->delete();
        if($status){
            return response()->json(['status' => 'success', 'message' => 'Post like succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }

    
    }
}
