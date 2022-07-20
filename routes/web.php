<?php

use App\Http\Controllers\Auth\SocialController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->namespace('App\Http\Controllers')->group(function(){

    //          HOME
    Route::get('/', 'BoardController@index')->name('home') ;
    // Route::get('/home', 'MainController@index')->name('home') ;

    //          CARD
    Route::get('/cards', 'CardController@index')->name('card-index') ;
    Route::get('/create-Card', 'CardController@create')->name('card-create') ;
    Route::post('/create-Card', 'CardController@store')->name('card-create') ;
    Route::get('/edit-Card/{card}', 'CardController@edit')->name('card-edit') ;
    Route::post('/edit-Card/{card}', 'CardController@update')->name('card-edit') ;
    Route::get('/destroy-Card/{card}', 'CardController@destroy')->name('card-destroy') ;

    //          LANE
    Route::get('/lanes', 'LaneController@index')->name('lane-index') ;
    Route::get('/create-Lane', 'LaneController@create')->name('lane-create') ;
    Route::post('/create-Lane', 'LaneController@store')->name('lane-create') ;
    Route::get('/edit-Lane/{lane}', 'LaneController@edit')->name('lane-edit') ;
    Route::post('/edit-Lane/{lane}', 'LaneController@update')->name('lane-edit') ;
    Route::get('/destroy-Lane/{lane}', 'LaneController@destroy')->name('lane-destroy') ;

    //          BOARD
    Route::get('/boards', 'BoardController@index')->name('board-index') ;
    Route::get('/board/{board}', 'MainController@index')->name('board-show') ;
    Route::get('/create-Board', 'BoardController@create')->name('board-create') ;
    Route::post('/create-Board', 'BoardController@store')->name('board-create') ;
    Route::get('/edit-Board/{board}', 'BoardController@edit')->name('board-edit') ;
    Route::post('/edit-Board/{board}', 'BoardController@update')->name('board-edit') ;
    Route::get('/destroy-Board/{board}', 'BoardController@destroy')->name('board-destroy') ;
}) ;

//  ACCEPT INVITE
Route::get('accept-invite/{permission}', 'App\Http\Controllers\Api\BoardPermissionController@acceptInvite')->name('accept-invite') ;

//  SOCIALITE
Route::get('login-social/{provider}', [SocialController::class, 'redirectToProvider'])
->name('login-social');

Route::get('login-social/{provider}/callback', [SocialController::class, 'handleProviderCallback'])
->name('login-social-callback');
//

Auth::routes();

Route::get('/home', [App\Http\Controllers\BoardController::class, 'index'])->name('home');
