<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = ForumPost::orderBy('created_at','desc')->get();

        foreach ($posts as $post){
            //get user information
            $userid = $post->user_id;
            $user = User::where('id', $userid)->first();
            $post->name = $user->first_name;

            //get no of like
            $likes = PostLike::where('post_id', '=', $post->id)->get();
            $noOfLikes = count($likes);
            $post->noLike = $noOfLikes;

            //get no of comment
            $comments = PostComment::where('post_id', '=', $post->id)->get();
            $noOfComments = count($comments);
            $post->comments = $noOfComments;

            //add other details
            $post->img= 'profileImage';
            $post->like = 'heart-o';

            $dt = strval($post->created_at);
            $datetime = substr($dt,0,10) . " " . substr($dt,10,9);
            $post->datetime = $datetime;
        }

        return $posts->toJson();
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

        $post = new ForumPost;

        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->description = $request->description;

        $status = $post->save();

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
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function show(ForumPost $forumPost)
    {
        return $forumPost->toJson();
    }

    public function showPost($forumPost)
    {
        error_log($forumPost);
        
        $post = ForumPost::where('id', '=', $forumPost)->first();

        //get user information
        $userid = $post->user_id;
        $user = User::where('id', $userid)->first();
        $post->name = $user->first_name;

        //get no of like
        $likes = PostLike::where('post_id', '=', $post->id)->get();
        $noOfLikes = count($likes);
        $post->noLike = $noOfLikes;

        //get no of comment
        $comments = PostComment::where('post_id', '=', $post->id)->get();
        $noOfComments = count($comments);
        $post->comments = $noOfComments;

        //add other details
        $post->img= 'profileImage';
        $post->like = 'heart-o';

        $dt = strval($post->created_at);
        $datetime = substr($dt,0,10) . " " . substr($dt,10,9);
        $post->datetime = $datetime;

        return $post->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function edit(ForumPost $forumPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ForumPost $forumPost)
    {
        //

        // $forumPost->user_id = $request->user_id;
        // $forumPost->title = $request->title;
        // $forumPost->description = $request->description;
        
        $status = $forumPost->update($request->all());
        
        if($status){
            return response()->json(['status' => 'success']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumPost $forumPost)
    {
        //
        return $forumPost->delete();
    }

    public function showComments( $forumPost)
    {
        $comments = PostComment::where('post_id', '=', $forumPost)->orderBy('created_at','desc')->get();

        foreach ($comments as $comment){
            //get user information
            $userid = $comment->user_id;
            $user = User::where('id', $userid)->first();
            $comment->name = $user->first_name;

            //add other details
            $comment->img= 'profileImage';
            $comment->like = 'heart-o';

            $dt = strval($comment->created_at);
            $datetime = substr($dt,0,10) . " " . substr($dt,10,9);
            $comment->datetime = $datetime;
        }

        return $comments->toJson();
    }
    public function deletePostById($id)
    {
    
        $post=ForumPost::where("id",$id)->first();
        $status = $post->delete();
        if($status){
            return response()->json(['status' => 'success', 'message' => 'Buddy request succesfully soft deleted']);
        }
        else{
            return response()->json(['status' => 'fail']);
        }

    
    }
    public function editPost($id, Request $request){

        error_log("editing");
        ForumPost::where("id",$id)->update($request->all());

        return response()->json(['status' => 'success']);
        
    }
    public function showAllPost($id){
        $posts = ForumPost::orderBy('created_at','desc')->get();

        foreach ($posts as $post){
            //get user information
            $userid = $post->user_id;
            $user = User::where('id', $userid)->first();
            $post->name = $user->first_name;

            //get no of like
            $likes = PostLike::where('post_id', '=', $post->id)->get();
            $noOfLikes = count($likes);
            $post->noLike = $noOfLikes;
            $likeStatus = PostLike::where('post_id', '=', $post->id)->where ('user_id', '=', $id)->first();
            if($likeStatus){
                $post->liked=true;
            }
            else{
                $post->liked=false;
            }

            //get no of comment
            $comments = PostComment::where('post_id', '=', $post->id)->get();
            $noOfComments = count($comments);
            $post->comments = $noOfComments;

            //add other details
            $post->img= 'profileImage';
            $post->like = 'heart-o';

            $dt = strval($post->created_at);
            $datetime = substr($dt,0,10) . " " . substr($dt,10,9);
            $post->datetime = $datetime;
        }

        return $posts->toJson();
    }
}

