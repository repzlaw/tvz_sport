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
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;

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
    Route::get('/{eventslug}', [EventsController::class,'index'])->name('get.single');

    //follow or unfollow event
    Route::get('/follow/{id}', [CompetitionFollowersController::class,'followCompetition'])->name('follow');

});

//team routes 
Route::prefix('/teams')->name('team.')->group(function(){
    //get all teams
    Route::get('/', [TeamController::class,'index'])->name('get.all');

    //create team
    Route::post('/create', [TeamController::class,'create'])->name('create')->middleware(['auth']);

    //edit team
    Route::post('/edit', [TeamController::class,'edit'])->name('edit')->middleware(['auth']);

    //edit team image
    Route::post('/edit-image', [TeamController::class,'editImage'])->name('edit.image')->middleware(['auth']);

    //get individual team details
    Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    //follow or unfollow team
    Route::get('/follow/{id}', [TeamFollowersController::class,'followTeam'])->name('follow');

});

//players routes
Route::prefix('/players')->name('player.')->group(function(){
    //get all players
    Route::get('/', [PlayerController::class,'index'])->name('get.all');

    //create player
    Route::post('/create', [PlayerController::class,'create'])->name('create')->middleware(['auth']);

    //edit player
    Route::post('/edit', [PlayerController::class,'edit'])->name('edit')->middleware(['auth']);

    //edit player image
    Route::post('/edit-image', [PlayerController::class,'editImage'])->name('edit.image')->middleware(['auth']);

    //get individual player details
    Route::get('/{player_slug}', [PlayerController::class,'getSingle'])->name('get.single');

    //follow or unfollow player
    Route::get('/follow/{id}', [PlayerFollowersController::class,'followPlayer'])->name('follow');

});

//editors post, edit and delete news route
Route::prefix('/news/editor')->name('news.')->group(function(){
    //get news page
    Route::get('/', [NewsController::class,'index'])->name('editor.all');

    //create news
    Route::post('/create', [NewsController::class,'createNews'])->name('editor.create');

    //edit news
    Route::post('/edit', [NewsController::class,'editNews'])->name('editor.edit');

    //delete news
    Route::get('/delete/{id}', [NewsController::class,'deleteNews'])->name('editor.delete');

    //player search
    Route::post('/player-search', [NewsController::class,'searchPlayer'])->name('editor.search.player');

    //team search
    Route::post('/team-search', [NewsController::class,'searchTeam'])->name('editor.search.team');

    //delete player related to news
    Route::get('/player/delete/{id}', [NewsController::class,'deletePlayer'])->name('editor.player.delete');

    //delete team related to news
    Route::get('/team/delete/{id}', [NewsController::class,'deleteTeam'])->name('editor.team.delete');

});

//individual news route
Route::prefix('/news')->name('news.')->group(function(){
    //get news page
    Route::get('/{news_slug}', [NewsController::class,'getSingleNews'])->name('get.single');

});


//websites events page
Route::get('/events', function () {
    return view('events');
});

//websites matches page
Route::get('/matches', function () {
    return view('matches');
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
