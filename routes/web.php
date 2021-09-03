<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Editor\TeamsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\TeamFollowersController;
use App\Http\Controllers\Editor\PlayersController;
use App\Http\Controllers\Admin\BanPolicyController;
use App\Http\Controllers\Admin\LoginLogsController;
use App\Http\Controllers\PlayerFollowersController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\CompetitionFollowersController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\SupportDepartmentsController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\FailedLoginsController;
use App\Http\Controllers\Admin\UserSuspensionHistoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\Editor\HomeController as EditorHomeController;
use App\Http\Controllers\Editor\NewsController as EditorNewsController;
use App\Http\Controllers\Editor\Auth\LoginController as AuthLoginController;

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

    //get individual team news
    Route::get('/{team_slug}/news', [TeamController::class,'getTeamNews'])->name('get-news');

    //create team comment
    Route::post('/save-comment', [TeamController::class,'saveComment'])->name('comment.create')->middleware(['auth','verified']);

    //create team comment reply
    Route::post('/save-reply', [TeamController::class,'saveReply'])->name('comment.reply.create')->middleware(['auth','verified']);

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

    //get individual player news
    Route::get('/{player_slug}/news', [PlayerController::class,'getPlayerNews'])->name('get-news');

    //create player comment
    Route::post('/save-comment', [PlayerController::class,'saveComment'])->name('comment.create')->middleware(['auth','verified']);

    //create player comment reply
    Route::post('/save-reply', [PlayerController::class,'saveReply'])->name('comment.reply.create')->middleware(['auth','verified']);

});

//individual news route
Route::prefix('/news')->name('news.')->group(function(){
    //get news page
    Route::get('/{news_slug}', [NewsController::class,'getSingleNews'])->name('get.single');

    //create news comment
    Route::post('/save-comment', [NewsController::class,'saveComment'])->name('comment.create')->middleware(['auth','verified']);

    //create news comment reply
    Route::post('/save-reply', [NewsController::class,'saveReply'])->name('comment.reply.create')->middleware(['auth','verified']);
});

//websites events page
Route::get('/events', function () {
    return view('events');
});

//websites matches page
Route::get('/matches', function () {
    return view('matches');
});

//comment routes
Route::prefix('/v1/comments')->name('comment.')->group(function(){
    Route::get('/', [CommentsController::class,'getComments'])->name('get');
    Route::get('/delete', [CommentsController::class,'deleteComment'])->name('delete');
    Route::get('/reply/delete', [CommentsController::class,'deleteReply'])->name('reply.delete');
    Route::get('/check-upvote', [CommentsController::class,'checkUpvote'])->name('check.upvote');
    Route::get('/upvote', [CommentsController::class,'upvoteComment'])->name('upvote');
    Route::get('/individual', [CommentsController::class,'getUserComment'])->name('single.user')->middleware(['auth','verified']);

});


//individual match page
Route::get('/poland-vs-belguim-1', function () {
    return view('individual-match');
});


Route::view('home','home')->middleware(['verified']);

//logout route
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

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

        //edit sport
        Route::post('/edit', [SportsController::class,'editSport'])->name('edit');

        
        //get individual sport details
        // Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    });

    //competitions routes
    Route::prefix('/competitions')->name('competition.')->middleware('admin')->group(function(){

        // get all competitions
        Route::get('/', [CompetitionController::class, 'index'])->name('all');

        //create competition
        Route::post('/create', [CompetitionController::class,'createCompetition'])->name('create');

        //edit competition
        Route::post('/edit', [CompetitionController::class,'editCompetition'])->name('edit');

        //delete Competition
        // Route::get('/delete/{id}', [CompetitionController::class,'deleteCompetition'])->name('delete');
        
        //get individual competition details
        // Route::get('/{team_slug}', [TeamController::class,'getSingle'])->name('get.single');

    });

    //users routes
    Route::prefix('/users')->name('user.')->middleware('admin')->group(function(){

        // get users page
        Route::get('/', [UserController::class, 'index'])->name('all');

        // get all users
        Route::get('/get', [UserController::class, 'getUser'])->name('get');

        // search users
        Route::get('/search', [UserController::class, 'searchUser'])->name('search');

        //create user
        Route::post('/create', [UserController::class,'createuser'])->name('create');

        //edit user
        Route::post('/edit', [UserController::class,'edituser'])->name('edit');

        //ban user
        Route::get('/{id}/ban', [UserController::class,'banUser'])->name('ban-user');

        //unban user
        Route::get('/{id}/unban', [UserController::class,'unbanUser'])->name('unban-user');

        //user profile page
        Route::get('/{id}', [ProfileController::class,'profile'])->name('profile');

        //user login logs
        Route::get('/{id}/login-logs', [ProfileController::class,'loginLogs'])->name('log');

    });

    //Editors routes
    Route::prefix('/editors')->name('editor.')->middleware('admin')->group(function(){

        // get Editors page
        Route::get('/', [EditorController::class, 'index'])->name('all');

        // get all Editors
        Route::get('/get', [EditorController::class, 'getEditor'])->name('get');

        // search Editors
        Route::get('/search', [EditorController::class, 'searchEditor'])->name('search');

        //create Editor
        Route::post('/create', [EditorController::class,'createEditor'])->name('create');

        //edit Editor
        Route::post('/edit', [EditorController::class,'editEditor'])->name('edit');

        //ban Editor
        Route::get('/{id}/ban', [EditorController::class,'banEditor'])->name('ban-Editor');

        //unban Editor
        Route::get('/{id}/unban', [EditorController::class,'unbanEditor'])->name('unban-Editor');

        //Editor profile page
        Route::get('/{id}', [ProfileController::class,'profile'])->name('profile');

        //Editor login logs
        Route::get('/{id}/login-logs', [ProfileController::class,'loginLogs'])->name('log');

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
    Route::prefix('/support-departments')->name('support-department.')->middleware('admin')->group(function(){

        // get support department page
        Route::get('/', [SupportDepartmentsController::class, 'index'])->name('all');

        //create support department
        Route::post('/create', [SupportDepartmentsController::class,'createSupportDepartment'])->name('create');

        //edit support department
        Route::post('/edit', [SupportDepartmentsController::class,'editSupportDepartment'])->name('edit');
        
    });

    //suspension history routes
    Route::prefix('/suspension-histories')->name('history.')->group(function(){
        //get suspensionhistory page
        Route::get('/', [UserSuspensionHistoriesController::class, 'index'])->name('all');
    
        //search suspensionhistory
        Route::get('/search', [UserSuspensionHistoriesController::class, 'searchHistory'])->name('search');
    });

    //login logs routes
    Route::prefix('/login-logs')->name('login-log.')->group(function(){
        //get admin login logs
        Route::get('/admin', [LoginLogsController::class, 'adminView'])->name('admin');
    
        // get editor login logs
        Route::get('/editor', [LoginLogsController::class, 'editorView'])->name('editor');
    });

    //failed login routes
    Route::prefix('/failed-logins')->name('failed-login.')->group(function(){
        //get suspensionhistory page
        Route::get('/admin', [FailedLoginsController::class, 'adminView'])->name('admin');
    
        //search suspensionhistory
        Route::get('/editor', [FailedLoginsController::class, 'editorView'])->name('editor');
    });

});

//All the editor routes will be defined here...
Route::prefix('/editor')->name('editor.')->namespace('Editor')->group(function(){
    Route::namespace('Auth')->group(function(){
        //Login Routes
        Route::get('/login', [AuthLoginController::class,'showLoginForm'])->name('login');
        Route::post('/login', [AuthLoginController::class,'login']);
        Route::get('/logout',[AuthLoginController::class,'logout'])->name('logout');
    });

    //editor homepage
    Route::get('/home', [EditorHomeController::class,'index'])->name('home');

    //editors post, edit and delete news route
    Route::prefix('/news')->name('news.')->middleware('editor')->group(function(){
        //get news page
        Route::get('/', [EditorNewsController::class,'index'])->name('all');

        //get create news page
        Route::get('/add-new', [EditorNewsController::class,'createNewsView'])->name('create-view');

        //create news
        Route::post('/create', [EditorNewsController::class,'createNews'])->name('create');

        //get edit news page
        Route::get('/edit/{news_id}', [EditorNewsController::class,'editNewsView'])->name('edit-view');

        //edit news
        Route::post('/edit', [EditorNewsController::class,'editNews'])->name('edit');

        //delete news
        Route::get('/delete/{id}', [EditorNewsController::class,'deleteNews'])->name('delete');

        //player search
        Route::post('/player-search', [EditorNewsController::class,'searchPlayer'])->name('search.player');

        //team search
        Route::post('/team-search', [EditorNewsController::class,'searchTeam'])->name('search.team');

        //delete player related to news
        Route::get('/player/delete/{id}', [EditorNewsController::class,'deletePlayer'])->name('player.delete');

        //delete team related to news
        Route::get('/team/delete/{id}', [EditorNewsController::class,'deleteTeam'])->name('team.delete');

        //individual news route
        // Route::get('/{news_slug}', [EditorNewsController::class,'getSingleNews'])->name('get.single');

    });

    //team routes 
    Route::prefix('/teams')->name('team.')->middleware('editor')->group(function(){
        //get all teams
        Route::get('/', [TeamsController::class,'index'])->name('get.all');

        //create team
        Route::post('/create', [TeamsController::class,'create'])->name('create');

        //edit team
        Route::post('/edit', [TeamsController::class,'edit'])->name('edit');

        //edit team image
        Route::post('/edit-image', [TeamsController::class,'editImage'])->name('edit.image');

        //get individual team details
        Route::get('/{team_slug}', [TeamsController::class,'getSingle'])->name('get.single');

        //get individual team news
        Route::get('/{team_slug}/news', [TeamsController::class,'getTeamNews'])->name('get-news');
    });

    //players routes
    Route::prefix('/players')->name('player.')->group(function(){
        //get all players
        Route::get('/', [PlayersController::class,'index'])->name('get.all');

        //create player
        Route::post('/create', [PlayersController::class,'create'])->name('create');

        //edit player
        Route::post('/edit', [PlayersController::class,'edit'])->name('edit');

        //edit player image
        Route::post('/edit-image', [PlayersController::class,'editImage'])->name('edit.image');

        //get individual player details
        Route::get('/{player_slug}', [PlayersController::class,'getSingle'])->name('get.single');

        //get individual player news
        Route::get('/{player_slug}/news', [PlayersController::class,'getPlayerNews'])->name('get-news');

    });

});
