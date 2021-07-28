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
use App\Http\Controllers\admin\BanPolicyController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\UserController;
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
    Route::get('/follow/{id}', [CompetitionFollowersController::class,'followCompetition'])->name('follow')->middleware(['auth','verified']);

});

//team routes 
Route::prefix('/teams')->name('team.')->group(function(){
    //get all teams
    Route::get('/', [TeamController::class,'index'])->name('get.all');

    //create team
    Route::post('/create', [TeamController::class,'create'])->name('create')->middleware(['auth','verified']);

    //edit team
    Route::post('/edit', [TeamController::class,'edit'])->name('edit')->middleware(['auth','verified']);

    //edit team image
    Route::post('/edit-image', [TeamController::class,'editImage'])->name('edit.image')->middleware(['auth','verified']);

    //get individual team details
    Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    //follow or unfollow team
    Route::get('/follow/{id}', [TeamFollowersController::class,'followTeam'])->name('follow')->middleware(['auth','verified']);

    //user editing team info
    Route::post('user/edit', [TeamController::class,'edit'])->name('user.edit')->middleware(['auth','verified']);

});

//players routes
Route::prefix('/players')->name('player.')->group(function(){
    //get all players
    Route::get('/', [PlayerController::class,'index'])->name('get.all');

    //create player
    Route::post('/create', [PlayerController::class,'create'])->name('create')->middleware(['auth','verified']);

    //edit player
    Route::post('/edit', [PlayerController::class,'edit'])->name('edit')->middleware(['auth','verified']);

    //edit player image
    Route::post('/edit-image', [PlayerController::class,'editImage'])->name('edit.image')->middleware(['auth','verified']);

    //get individual player details
    Route::get('/{player_slug}', [PlayerController::class,'getSingle'])->name('get.single');

    //follow or unfollow player
    Route::get('/follow/{id}', [PlayerFollowersController::class,'followPlayer'])->name('follow')->middleware(['auth','verified']);

    //user editing player info
    Route::post('user/edit', [PlayerController::class,'edit'])->name('user.edit')->middleware(['auth','verified']);
});

//editors post, edit and delete news route
Route::prefix('/news/editor')->name('news.')->group(function(){
    //get news page
    Route::get('/', [NewsController::class,'index'])->name('editor.all')->middleware(['auth','verified']);

    //create news
    Route::post('/create', [NewsController::class,'createNews'])->name('editor.create')->middleware(['auth','verified']);

    //edit news
    Route::post('/edit', [NewsController::class,'editNews'])->name('editor.edit')->middleware(['auth','verified']);

    //delete news
    Route::get('/delete/{id}', [NewsController::class,'deleteNews'])->name('editor.delete')->middleware(['auth','verified']);

    //player search
    Route::post('/player-search', [NewsController::class,'searchPlayer'])->name('editor.search.player');

    //team search
    Route::post('/team-search', [NewsController::class,'searchTeam'])->name('editor.search.team');

    //delete player related to news
    Route::get('/player/delete/{id}', [NewsController::class,'deletePlayer'])->name('editor.player.delete')->middleware(['auth','verified']);

    //delete team related to news
    Route::get('/team/delete/{id}', [NewsController::class,'deleteTeam'])->name('editor.team.delete')->middleware(['auth','verified']);

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

//All the admin routes will be defined here...
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){

    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class,'login']);
        Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    });
    
    // admin home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //sports routes
    Route::prefix('/sports')->name('sport.')->middleware('admin')->group(function(){

        // get all sports
        Route::get('/', [SportsController::class, 'index'])->name('all');

        //create sport
        Route::post('/create', [SportsController::class,'createSport'])->name('create');

        
        //get individual sport details
        // Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    });

    //competitions routes
    Route::prefix('/competitions')->name('competition.')->middleware('admin')->group(function(){

        // get all competitions
        Route::get('/', [CompetitionController::class, 'index'])->name('all');

        //create competition
        Route::post('/create', [CompetitionController::class,'createCompetition'])->name('create');

        
        //get individual competition details
        // Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    });

    //users routes
    Route::prefix('/users')->name('user.')->middleware('admin')->group(function(){

        // get users page
        Route::get('/', [UserController::class, 'index'])->name('all');

        // get all users
        Route::get('/get', [UserController::class, 'getUser'])->name('get');

        //create user
        Route::post('/create', [UserController::class,'createuser'])->name('create');

        //edit user
        Route::post('/edit', [UserController::class,'edituser'])->name('edit');

        //ban/unban user
        Route::post('/status', [UserController::class,'editStatus'])->name('status');

        //get individual user details
        // Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    });

    //banpolicys routes
    Route::prefix('/ban-policy')->name('ban-policy.')->middleware('admin')->group(function(){

        // get banpolicys page
        Route::get('/', [BanPolicyController::class, 'index'])->name('all');

        //create banpolicy
        Route::post('/create', [BanPolicyController::class,'createpolicy'])->name('create');

        //edit policy
        Route::post('/edit', [BanPolicyController::class,'editPolicy'])->name('edit');

        
    });

    //support department routes
    Route::prefix('/support-department')->name('support-department.')->middleware('admin')->group(function(){

        // get support department page
        Route::get('/', [BanPolicyController::class, 'index'])->name('all');

        //create support department
        Route::post('/create', [BanPolicyController::class,'createpolicy'])->name('create');

        //edit support department
        Route::post('/edit', [UserController::class,'editPolicy'])->name('edit');

        
    });
});
