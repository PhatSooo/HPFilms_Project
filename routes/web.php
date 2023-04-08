<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use TCG\Voyager\Facades\Voyager;

use App\Http\Middleware\CheckLogin;
use GuzzleHttp\Middleware;

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

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('index');

    Route::get('/movies', [HomeController::class,'movie_list'])->name('movies');
    Route::get('/movie-single/{slug}', [MovieController::class,'movie_single'])->name('movie_single');
    Route::get('/movie-single/{slug}/favorite/{action}', [MovieController::class,'favorite'])->name('favorite');
    Route::post('/movie-single/{slug}/rate', [MovieController::class,'rating_movie'])->name('rating');
    Route::post('/movie-single/{slug}/review', [MovieController::class,'review'])->name('review');
    Route::post('/movie-single/watch/{slug}', [MovieController::class, 'history'])->name('history');

    Route::get('/series', [HomeController::class,'series_list'])->name('series');
    Route::get('/series-single/{slug}', [SeriesController::class,'series_single'])->name('series_single');
    Route::get('/series-single/{slug}/favorite/{action}', [SeriesController::class,'favorite'])->name('series_favorite');
    Route::post('/series-single/{slug}/rate', [SeriesController::class,'rating'])->name('series_rating');
    Route::post('/series-single/{slug}/review', [SeriesController::class,'review'])->name('series_review');

    Route::get('/celebrity/{search?}', [HomeController::class,'celeb_list'])->name('celeb_list');
    Route::post('/celebrity/search', [CrewController::class,'celeb_search'])->name('celeb_search');

    Route::get('/404', [HomeController::class,'error'])->name('404');

    Route::post('/login', [AuthController::class,'login'])->name('login');
    Route::post('/register', [AuthController::class,'register'])->name('register');
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');

    Route::get('search/{category}/{term}', [SearchController::class,'movies'])->name('search');
    Route::get('crews-search/{category}/{term}', [SearchController::class,'celebs'])->name('celeb_search');
    Route::post('movie-search', [SearchController::class,'movie_search'])->name('movie_search');
    Route::post('crews-search', [SearchController::class,'crews_search'])->name('crews_search');

});

Route::middleware(['auth'])->prefix('user/{id}')->group(function () {
    Route::get('/profile', [UserController::class,'user_profile'])->name('user_profile');
    Route::get('/rate', [UserController::class,'user_rate'])->name('user_rate');
    Route::get('/favorite-list', [UserController::class,'favorite_list'])->name('user_favorite_list');
    Route::get('/histories', [UserController::class,'history'])->name('user_histories');
    Route::patch('/profile/change-password', [UserController::class,'change_pass'])->middleware(['email.verify'])->name('change_pass');
    Route::put('/profile/update-info', [UserController::class,'change_info'])->name('update_info');
    Route::put('histories/remove/{his_id}',[UserController::class,'remove_history'])->name('remove_history');
    Route::put('/profile', [UserController::class, 'change_img'])->name('change_img');
});

Route::get('/email/verify-send/{isSent?}', [EmailController::class,'verify_email'])->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{token}', [EmailController::class,'verify_email_request'])->name('verification.request');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
