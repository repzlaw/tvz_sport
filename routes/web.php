<?php

use App\Http\Controllers\Admin\AdminForumController;
use App\Http\Controllers\Admin\AdminForumPostController;
use App\Http\Controllers\Admin\AdminForumThreadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Google2faController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ForumController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Editor\TeamsController;
use App\Http\Controllers\User\FriendsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\TeamFollowersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Editor\PlayersController;
use App\Http\Controllers\User\ForumPostController;
use App\Http\Controllers\Admin\BanPolicyController;
use App\Http\Controllers\Admin\LoginLogsController;
use App\Http\Controllers\PlayerFollowersController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Comment\CommentsController;
use App\Http\Controllers\User\ForumThreadController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\FailedLoginsController;
use App\Http\Controllers\User\UserTwoFactorController;
use App\Http\Controllers\CompetitionFollowersController;
use App\Http\Controllers\Admin\ForumCategoriesController;
use App\Http\Controllers\Admin\SupportDepartmentsController;
use App\Http\Controllers\Admin\AdminPasswordSecurityController;
use App\Http\Controllers\Admin\ReportedController;
use App\Http\Controllers\Admin\UserSuspensionHistoriesController;
use App\Http\Controllers\Editor\EditorPasswordSecurityController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\Editor\HomeController as EditorHomeController;
use App\Http\Controllers\Editor\NewsController as EditorNewsController;
use App\Http\Controllers\Auth\ProfileController as UserProfileController;
use App\Http\Controllers\User\SettingsController as UserSettingsController;
use App\Http\Controllers\Editor\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Editor\SettingsController as EditorSettingsController;

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
Route::post('/2faVerify',[Google2faController::class,'g2faVerify'])->name('2faVerify');
Route::post('/2fa-logout',[Google2faController::class,'logout'])->name('2fa.logout');

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
    Route::post('/save-comment', [TeamController::class,'saveComment'])->name('comment.create')->middleware(['auth','verified','spam']);

    //create team comment reply
    Route::post('/save-reply', [TeamController::class,'saveReply'])->name('comment.reply.create')->middleware(['auth','verified','spam']);

    //report comment route
    Route::get('/report/{id}', [TeamController::class,'reportComment'])->name('report')->middleware(['verified']);
    Route::post('/report/create', [TeamController::class,'createReport'])->name('report.create')->middleware(['verified']);

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
    Route::post('/save-comment', [PlayerController::class,'saveComment'])->name('comment.create')->middleware(['auth','verified','spam']);

    //create player comment reply
    Route::post('/save-reply', [PlayerController::class,'saveReply'])->name('comment.reply.create')->middleware(['auth','verified','spam']);

    //report comment route
    Route::get('/report/{id}', [TeamController::class,'reportComment'])->name('report')->middleware(['verified']);
    Route::post('/report/create', [TeamController::class,'createReport'])->name('report.create')->middleware(['verified']);

});

//individual news route
Route::prefix('/news')->name('news.')->group(function(){
    //get news page
    Route::get('/{news_slug}', [NewsController::class,'getSingleNews'])->name('get.single');

    //create news comment
    Route::post('/save-comment', [NewsController::class,'saveComment'])->name('comment.create')->middleware(['verified','spam']);

    //create news comment reply
    Route::post('/save-reply', [NewsController::class,'saveReply'])->name('comment.reply.create')->middleware(['verified','spam']);

    //report comment route
    Route::get('/report/{id}', [NewsController::class,'reportComment'])->name('report')->middleware(['verified']);
    Route::post('/report/create', [NewsController::class,'createReport'])->name('report.create')->middleware(['verified']);

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
    Route::get('/individual', [CommentsController::class,'getUserComment'])->name('single.user')->middleware(['verified']);

});

//user profile routes
Route::prefix('/profile')->name('profile.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('index')->middleware(['verified']);
    Route::post('/update-profile', [UserProfileController::class, 'updateProfile'])->name('edit')->middleware(['verified']);
    Route::post('/update-image', [UserProfileController::class, 'updateImage'])->name('edit.image')->middleware(['verified']);
    Route::get('/{user_slug}', [UserProfileController::class, 'userProfile'])->name('user-profile');
    Route::get('/follow/{id}', [UserProfileController::class,'followUser'])->name('follow')->middleware(['verified']);
    //change password
    Route::post('/change-password', [UserProfileController::class, 'changePassword'])->name('change-password')->middleware(['verified']);
    Route::get('/change-password/verify', [UserTwoFactorController::class, 'passwordTwoFaIndex'])->name('verify.change-password')->middleware(['verified']);
    Route::post('/password-token-verify', [UserTwoFactorController::class, 'verifyPassword'])->name('password-token.confirm')->middleware(['verified']);
    Route::get('/password-resend-token', [UserTwoFactorController::class, 'resendPasswordToken'])->name('token.resend')->middleware(['verified']);
});

//user post, edit and delete news route
Route::prefix('/user')->middleware(['verified'])->group(function () {
    Route::prefix('/news')->middleware(['author'])->name('user.news.')->group(function(){
        //get news page
        Route::get('/', [UserNewsController::class,'index'])->name('all');

        //get create news page
        Route::get('/add-new', [UserNewsController::class,'createNewsView'])->name('create-view');

        //create news
        Route::post('/create', [UserNewsController::class,'createNews'])->name('create');

        //get edit news page
        Route::get('/edit/{news_id}', [UserNewsController::class,'editNewsView'])->name('edit-view');

        //edit news
        Route::post('/edit', [UserNewsController::class,'editNews'])->name('edit');

        //delete news
        Route::get('/delete/{id}', [UserNewsController::class,'deleteNews'])->name('delete');

        //player search
        Route::post('/player-search', [UserNewsController::class,'searchPlayer'])->name('search.player');

        //team search
        Route::post('/team-search', [UserNewsController::class,'searchTeam'])->name('search.team');

        //delete player related to news
        Route::get('/player/delete/{id}', [UserNewsController::class,'deletePlayer'])->name('player.delete');

        //delete team related to news
        Route::get('/team/delete/{id}', [UserNewsController::class,'deleteTeam'])->name('team.delete');

        
    });

    //settings route
    Route::prefix('/settings')->name('setting.')->middleware(['auth'])->group(function(){
        Route::get('/', [UserSettingsController::class, 'index'])->name('all');
        Route::post('/save', [UserSettingsController::class, 'save'])->name('save');
        Route::post('/security', [UserSettingsController::class, 'security'])->name('security');

    });

});

//user friends routes
Route::prefix('/friends')->name('friend.')->middleware(['verified'])->group(function () {
    Route::get('/pending-requests', [FriendsController::class,'pendingRequest'])->name('pending-requests');
    Route::get('/friends-list', [FriendsController::class,'friendList'])->name('friends-list');
    Route::get('/accept-request/{friend_slug}', [FriendsController::class,'acceptRequest'])->name('accept.request');
    Route::get('/decline-request/{friend_slug}', [FriendsController::class,'declineRequest'])->name('decline-request');
    Route::post('/invite-friend', [FriendsController::class,'inviteFriend'])->name('invite');

});

//forum routes
Route::prefix('/forums')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class,'index'])->name('all');
    Route::get('/{forum_slug}', [ForumController::class,'getSingleCategory'])->name('get.single');

    Route::prefix('/threads')->name('thread.')->group(function () {
        Route::get('/{thread_slug}', [ForumThreadController::class,'getSingleThread'])->name('get.single');
        Route::post('/create', [ForumThreadController::class,'create'])->name('create')->middleware(['verified','spam']);
        Route::post('/edit', [ForumThreadController::class,'edit'])->name('edit')->middleware(['verified','spam']);
        Route::post('/upvote', [ForumThreadController::class,'upvoteThread'])->name('upvote')->middleware(['verified']);
        Route::post('/downvote', [ForumThreadController::class,'downvoteThread'])->name('downvote')->middleware(['verified']);
        Route::get('/report/{thread_slug}', [ForumThreadController::class,'reportThread'])->name('report')->middleware(['verified']);
        Route::post('/report/create', [ForumThreadController::class,'createReport'])->name('report.create')->middleware(['verified']);

    });

    Route::prefix('/posts')->name('post.')->group(function () {
        Route::post('/create', [ForumPostController::class,'create'])->name('create')->middleware(['verified','spam']);
        Route::post('/edit', [ForumPostController::class,'edit'])->name('edit')->middleware(['verified','spam']);
        Route::post('/upvote', [ForumPostController::class,'upvotePost'])->name('upvote')->middleware(['verified']);
        Route::get('/report/{post_slug}', [ForumPostController::class,'reportPost'])->name('report')->middleware(['verified']);
        Route::post('/report/create', [ForumPostController::class,'createReport'])->name('report.create')->middleware(['verified']);

    });
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
        Route::get('/2fa',[AdminPasswordSecurityController::class,'show2faForm'])->name('2fa');
        Route::post('/generate-2fa-secret',[AdminPasswordSecurityController::class,'generate2faSecret'])->middleware(['admin','2fa'])->name('generate2faSecret');
        Route::post('/enale2fa',[AdminPasswordSecurityController::class,'enable2fa'])->middleware(['admin','2fa'])->name('enable2fa');
        Route::post('/disable2fa',[AdminPasswordSecurityController::class,'disable2fa'])->middleware(['admin','2fa'])->name('disable2fa');
    });
    
    // admin home
    Route::get('/home', [HomeController::class, 'index'])->middleware(['admin','2fa'])->name('home');

    //sports routes
    Route::prefix('/sports')->name('sport.')->middleware(['admin','2fa'])->group(function(){

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
    Route::prefix('/competitions')->name('competition.')->middleware(['admin','2fa'])->group(function(){

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
    Route::prefix('/users')->name('user.')->middleware(['admin','2fa'])->group(function(){

        // get users page
        Route::get('/', [UserController::class, 'index'])->name('all');

        // get all users
        Route::get('/get', [UserController::class, 'getUser'])->name('get');

        // search users
        Route::post('/search', [UserController::class, 'searchUser'])->name('search');

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
    Route::prefix('/editors')->name('editor.')->middleware(['admin','2fa'])->group(function(){

        // get Editors page
        Route::get('/', [EditorController::class, 'index'])->name('all');

        // get all Editors
        Route::get('/get', [EditorController::class, 'getEditor'])->name('get');

        // search Editors
        Route::post('/search', [EditorController::class, 'searchEditor'])->name('search');

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
    Route::prefix('/ban-policy')->name('ban-policy.')->middleware(['admin','2fa'])->group(function(){

        // get banpolicys page
        Route::get('/', [BanPolicyController::class, 'index'])->name('all');

        //create banpolicy
        Route::post('/create', [BanPolicyController::class,'createpolicy'])->name('create');

        //edit policy
        Route::post('/edit', [BanPolicyController::class,'editPolicy'])->name('edit');

    });

    //forum-categories routes
    Route::prefix('/forum-categories')->name('forum-category.')->middleware(['admin','2fa'])->group(function(){

        // get forum-categories page
        Route::get('/', [ForumCategoriesController::class, 'index'])->name('all');

        //create forum-categories
        Route::post('/create', [ForumCategoriesController::class,'createCategory'])->name('create');

        //edit policy
        Route::post('/edit', [ForumCategoriesController::class,'editCategory'])->name('edit');

    });

    //support department routes
    Route::prefix('/support-departments')->name('support-department.')->middleware(['admin','2fa'])->group(function(){

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

    //settings route
    Route::prefix('/settings')->name('setting.')->middleware(['admin','2fa'])->group(function(){
        Route::get('/', [SettingsController::class, 'index'])->name('all');
        Route::post('/save', [SettingsController::class, 'save'])->name('save');
        Route::post('/security', [SettingsController::class, 'security'])->name('security');

    });

    //forum routes
    Route::prefix('/forums')->name('forum.')->middleware(['admin'])->group(function () {
        Route::get('/', [AdminForumController::class,'index'])->name('all');
        Route::get('/{forum_slug}', [AdminForumController::class,'getSingleCategory'])->name('get.single');

        Route::prefix('/threads')->name('thread.')->group(function () {
            Route::get('/{thread_slug}', [AdminForumThreadController::class,'getSingleThread'])->name('get.single');
            Route::post('/create', [AdminForumThreadController::class,'create'])->name('create');
            Route::post('/edit', [AdminForumThreadController::class,'edit'])->name('edit');
            Route::post('/upvote', [AdminForumThreadController::class,'upvoteThread'])->name('upvote');
            Route::post('/downvote', [AdminForumThreadController::class,'downvoteThread'])->name('downvote');
        });

        Route::prefix('/posts')->name('post.')->group(function () {
            Route::post('/create', [AdminForumPostController::class,'create'])->name('create');
            Route::post('/edit', [AdminForumPostController::class,'edit'])->name('edit');
            Route::post('/upvote', [AdminForumPostController::class,'upvotePost'])->name('upvote');
            Route::post('/change-status', [AdminForumPostController::class,'changeStatus'])->name('status');
        });
    });

    //reported routes
    Route::prefix('/reported')->name('reported.')->middleware(['admin','2fa'])->group(function(){
        Route::get('/threads', [ReportedController::class, 'getThread'])->name('thread.get');
        Route::get('/posts', [ReportedController::class,'getPost'])->name('post.get');
        Route::get('/news-comment', [ReportedController::class,'getNewsComment'])->name('news.get');
        Route::get('/players-comment', [ReportedController::class,'getPlayersComment'])->name('player.get');
        Route::get('/teams-comment', [ReportedController::class,'getTeamsComment'])->name('team.get');

    });
});

//All the editor routes will be defined here...
Route::prefix('/editor')->name('editor.')->namespace('Editor')->group(function(){
    Route::namespace('Auth')->group(function(){
        //Login Routes
        Route::get('/login', [AuthLoginController::class,'showLoginForm'])->name('login');
        Route::post('/login', [AuthLoginController::class,'login']);
        Route::get('/logout',[AuthLoginController::class,'logout'])->name('logout');
        Route::get('/2fa',[EditorPasswordSecurityController::class,'show2faForm']);
        Route::post('/generate-2fa-secret',[EditorPasswordSecurityController::class,'generate2faSecret'])->name('generate2faSecret');
        Route::post('/enale2fa',[EditorPasswordSecurityController::class,'enable2fa'])->name('enable2fa');
        Route::post('/disable2fa',[EditorPasswordSecurityController::class,'disable2fa'])->name('disable2fa');
    });

    //editor homepage
    Route::get('/home', [EditorHomeController::class,'index'])->name('home')->middleware(['2fa']);

    //editors post, edit and delete news route
    Route::prefix('/news')->name('news.')->middleware(['editor','2fa'])->group(function(){
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

        // sort news by status
        Route::get('/search', [EditorNewsController::class,'newsSearch'])->name('search');

        // change news status
        Route::post('/change-status', [EditorNewsController::class,'changeStatus'])->name('status');

    });

    //team routes 
    Route::prefix('/teams')->name('team.')->middleware(['editor','2fa'])->group(function(){
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
    Route::prefix('/players')->name('player.')->middleware(['editor','2fa'])->group(function(){
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

    //settings route
    Route::prefix('/settings')->name('setting.')->middleware(['editor','2fa'])->group(function(){
        Route::get('/', [EditorSettingsController::class, 'index'])->name('all');
        Route::post('/save', [EditorSettingsController::class, 'save'])->name('save');

    });
});
