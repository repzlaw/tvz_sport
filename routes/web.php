<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\TeamFollowersController;
use App\Http\Controllers\PlayerFollowersController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\CompetitionFollowersController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController as ControllersHomeController;

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

//websites homepage
Route::get('/', [ControllersHomeController::class,'index'])->name('home');

//event routes
Route::prefix('/event')->name('event.')->group(function(){
    //get individual event details
    Route::get('/get/{eventname}/{id}', [EventsController::class,'index'])->name('get.single');

    //follow or unfollow event
    Route::get('/followers/{id}', [CompetitionFollowersController::class,'followCompetition'])->name('follow');

});

//team routes
Route::prefix('/team')->name('team.')->group(function(){

    //follow or unfollow team
    Route::get('/followers/{id}', [TeamFollowersController::class,'followTeam'])->name('follow');

});

//players routes
Route::prefix('/player')->name('player.')->group(function(){

    //follow or unfollow player
    Route::get('/followers/{id}', [PlayerFollowersController::class,'followPlayer'])->name('follow');

});


//websites events page
Route::get('/events', function () {
    return view('events');
});

//websites matches page
Route::get('/matches', function () {
    return view('matches');
});

//websites players page
Route::get('/players', function () {
    return view('players');
});


//individual match page
Route::get('/poland-vs-belguim-1', function () {
    return view('individual-match');
});


Route::view('home','home')->middleware(['verified']);;

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    //All the admin routes will be defined here...
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class,'login']);
        Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    });
    
    // admin home
    Route::get('/home', [HomeController::class, 'index'])->name('home');


  });
