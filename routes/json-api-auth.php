<?php

use App\Http\Controllers\JsonApiAuth\ConfirmablePasswordController;
use App\Http\Controllers\JsonApiAuth\EmailVerificationNotificationController;
use App\Http\Controllers\JsonApiAuth\LoginController;
use App\Http\Controllers\JsonApiAuth\LogoutController;
use App\Http\Controllers\JsonApiAuth\NewPasswordController;
use App\Http\Controllers\JsonApiAuth\PasswordResetLinkController;
use App\Http\Controllers\JsonApiAuth\RegisterController;
use App\Http\Controllers\JsonApiAuth\VerifyEmailController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\EventDistanceController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\BuddyController;
use App\Http\Controllers\BuddyRequestController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'users'=> UserController::class,
    'activities'=> ActivityController::class,
    'events'=> EventController::class,
    'userevents'=> UserEventController::class,
    'eventdistances'=> EventDistanceController::class,
    'forumposts'=> ForumPostController::class,
    'postcomments'=> PostCommentController::class,
    'postlikes'=> PostLikeController::class,
    "buddyrequest"=>BuddyRequestController::class,
    "buddy"=>BuddyController::class,
    "calendar"=>CalendarController::class,
    "route"=>RouteController::class,
]);


Route::post('/register', RegisterController::class)->name('json-api-auth.register');

Route::post('/login', LoginController::class)->name('json-api-auth.login');

Route::get('/logout', LogoutController::class)
    ->middleware('auth:sanctum')
    ->name('json-api-auth.logout');

Route::post('/forgot-password', PasswordResetLinkController::class)
    ->name('json-api-auth.password.email');

Route::post('/reset-password', NewPasswordController::class)
    ->name('json-api-auth.password.update');

Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('json-api-auth.verification.send');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('json-api-auth.verification.verify');

Route::post('/confirm-password', ConfirmablePasswordController::class)
    ->middleware('auth:sanctum')
    ->name('json-api-auth.password.confirm');


Route::post('activity', [ActivityController::class, 'store']);

//Custom functions

//Forum Post
Route::get('/forumposts/{forumpost}', [ForumPostController::class, 'showPost']);

Route::get('/forumposts/{forumpost}/comments', [ForumPostController::class, 'showComments']);


//Activity
Route::get('/activity/users/{user}', [ActivityController::class, 'showUserActivities']);

//get user activities
Route::get('/activity/all/users/{user}', [ActivityController::class, 'showAllUserActivities']);

//Event
//get events registered by the user
Route::get('/events/users/{user}', [UserEventController::class, 'showUserEvents']);

//get events (excluded registered)
Route::get('/events/exclusive/{user}', [EventController::class, 'showUserExclusiveEvents']);

//get event distances
Route::get('/events/{event}/distance', [EventDistanceController::class, 'showEventDistances']);

//update event distances
Route::post('/eventdistances/update', [EventDistanceController::class, 'updateDistanceFee']);

//get coming soon events
Route::get('/events/comingsoon/all', [EventController::class, 'showComingSoonEvents']);


//User
//get user list exclude current user
Route::get('/users/list/{user}', [UserController::class, "showUserList"]);

//search user by name
Route::get('/users/list/{user}/{userName}', [UserController::class, "searchUserByName"]);

//search user by id
Route::get('/users/{user}', [UserController::class, "searchUserById"]);

//Buddy
//search user buddy list
Route::get('/buddy/buddyList/{user}', [BuddyController::class, "searchUserBuddyList"]);

//search buddy by name
Route::get('/buddy/buddyList/{user}/{userName}', [BuddyController::class, "searchBuddyByName"]);

//get buddy id
Route::get('/buddy/{user}/{buddy}', [BuddyController::class, "getID"]);

//search user buddy request list
Route::get('/buddyrequest/list/{user}', [BuddyRequestController::class, "searchUserBuddyReqList"]);

//get buddyrequest id
Route::get('/buddyrequest/{user}/{buddy}', [BuddyRequestController::class, "getID"]);

//custom delete buddy request by id
Route::delete('/buddyrequest/list/{id}', [BuddyRequestController::class, "deleteBuddyReqByID"]);

//Calendar
//get user calendar data
Route::get('/calendar/calendarList/{user}', [CalendarController::class, "searchUserCalendarList"]);

//get user calendar data
Route::get('/calendar/calendarList/{user}', [CalendarController::class, "searchUserCalendarList"]);

//Route
//get user route list data
Route::get('/route/routeList/{user}', [RouteController::class, "searchUserRouteList"]);

//get user route list data
Route::get('/route/routeList/details/{id}', [RouteController::class, "searchRoute"]);

//get admin route list data
Route::get('/admin/route/routeList', [RouteController::class, "searchAdminRoute"]);

//get like id
Route::get('/post/list/like/{user}/{post}', [PostLikeController::class, "searchLikeId"]);

//custom delete like
Route::delete('/post/list/like/{id}', [PostLikeController::class, "deleteLikeById"]);

//custom delete post
Route::delete('/post/list/user/{id}', [ForumPostController::class, "deletePostById"]);

//custom edit post
Route::put('/post/list/edit/{id}', [ForumPostController::class, "editPost"]);

//get whether like or not
Route::get('/forumposts/list/{user}', [ForumPostController::class, "showAllPost"]);

//get count of participate user city
Route::get('/event/joined', [UserEventController::class, "getEventParticipateCount"]);