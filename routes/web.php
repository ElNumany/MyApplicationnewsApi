<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/authors', 'App\Http\Controllers\Api\UserController@index');

// /**
//  * @User Related
//  */
// Route::get('/authors', 'App\Http\Controllers\Api\UserController@index');
// Route::get('/authors/{id}', 'App\Http\Controllers\Api\UserController@show');
// Route::get('/posts/author/{id}',  'App\Http\Controllers\Api\UserController@posts');
// Route::get('comments/author/{id}', 'App\Http\Controllers\Api\UserController@comments');

// // End User Related

// /**
//  * @Post related
//  */

// Route::get('categories', 'Api\CategoryController@index');
// Route::get('posts/categories/{id}', 'Api\CategoryController@posts');
// Route::get('posts', 'Api\PostController@index');
// Route::get('posts/{id}', 'Api\PostController@show');
// Route::get('comments/posts/{id}', 'Api\PostController@comments');

// // End Post Related

// Route::post('register', 'Api\UserController@store');
// Route::post('token', 'Api\UserController@getToken');

// Route::middleware('auth:api')->group( function(){

//     Route::post( 'update-user/{id}' , 'Api\UserController@update' );
//     Route::post( 'posts' , 'Api\PostController@store' );
//     Route::post( 'posts/{id}' , 'Api\PostController@update'  );
//     Route::delete( 'posts/{id}' , 'Api\PostController@destroy'  );

//     Route::post( 'comments/posts/{id}' , 'Api\CommentController@store' );

//     Route::post( 'votes/posts/{id}' , 'Api\PostController@votes' );

// } ) ;

// // Route::get('authors', function () {
// //     $user = User::find(25);
// //     return $user->posts;
// // });
