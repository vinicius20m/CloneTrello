<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('App\Http\Controllers\Api')->group(function(){

    // MOVE
    Route::post('moveCard/{lane}', 'InteractionController@moveCard')->name('api-move-card') ;
    Route::post('moveLane/{board}', 'InteractionController@moveLane')->name('api-move-lane') ;

    // CARD
    Route::post('create-Card', 'CardController@store')->name('api-create-card') ;
    Route::post('edit-Card/{card}', 'CardController@update')->name('api-edit-card') ;
    Route::get('destroy-Card/{card}', 'CardController@destroy')->name('api-destroy-card') ;

    // LANE
    Route::post('create-Lane', 'LaneController@store')->name('api-create-lane') ;
    Route::post('edit-Lane/{lane}', 'LaneController@update')->name('api-edit-lane') ;
    Route::get('destroy-Lane/{lane}', 'LaneController@destroy')->name('api-destroy-lane') ;

    // PERMISSION
    Route::post('create-Permission', 'BoardPermissionController@store')->name('api-create-permission') ;
    Route::post('invite-Permission', 'BoardPermissionController@invite')->name('api-invite-permission') ;
    Route::post('edit-Permission/{user_permission}', 'BoardPermissionController@update')->name('api-edit-permission') ;
    Route::get('destroy-Permission/{user_permission}', 'BoardPermissionController@destroy')->name('api-destroy-permission') ;

    // COMMENT
    Route::post('create-Comment', 'CardCommentController@store')->name('api-create-comment') ;
    Route::post('edit-Comment/{comment}', 'CardCommentController@update')->name('api-edit-comment') ;
    Route::get('destroy-Comment/{comment}', 'CardCommentController@destroy')->name('api-destroy-comment') ;

    // CHECKLIST
    Route::post('create-Checklist', 'CardChecklistController@store')->name('api-create-checklist') ;
    Route::post('edit-Checklist/{checklist}', 'CardChecklistController@update')->name('api-edit-checklist') ;
    Route::get('destroy-Checklist/{checklist}', 'CardChecklistController@destroy')->name('api-destroy-checklist') ;

    // CHECKLIST_ITEM
    Route::post('create-ChecklistItem', 'ChecklistItemController@store')->name('api-create-checklist_item') ;
    Route::post('edit-ChecklistItem/{checklist_item}', 'ChecklistItemController@update')->name('api-edit-checklist_item') ;
    Route::get('destroy-ChecklistItem/{checklist_item}', 'ChecklistItemController@destroy')->name('api-destroy-checklist_item') ;
    Route::post('check-ChecklistItem/{checklist_item}', 'ChecklistItemController@check')->name('api-check-checklist_item') ;

}) ;
