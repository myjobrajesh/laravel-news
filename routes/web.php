<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* This Routes are used without auth
 * public routes
 */

Route::group(['middleware' => ['web']], function () {

    //tested
    //Route::get('/', 'LoginController@showLogin');
    Route::get('/', ['as'=>'newsstand' , 'uses'=>'NewsController@newsStandShow']);

    Route::get('login', ['as'=>'login' , 'uses'=>'LoginController@showLogin']);
    
    Route::post('signin', ['as'=>'signin' , 'uses'=>'LoginController@postLogin']);
    
    Route::post('signup', ['as'=>'signup' , 'uses'=>'LoginController@postRegister']);
    
    Route::get('activateuser/{code}', ['as'=>'activateuser' , 'uses'=>'LoginController@activateUser']);
    
    Route::post('resetpwd', ['as'=>'resetpwd' , 'uses'=>'LoginController@resetPwd']);
    
    // news detail
    Route::get('news/{slug}', ['as'=>'newsdetail' , 'uses'=>'NewsController@showNews']);
   
    //download pdf
    Route::get('news/{slug}/download', ['as'=>'newsdownload' , 'uses'=>'NewsController@downloadNews']);
   
    // news rss feed
    Route::get('rss', ['as'=>'newsrss' , 'uses'=>'NewsController@newsRss']);
    
});

/* These are for authenticated
 */
Route::group(['middleware' => ['web', 'auth']], function () {

    // logout
    Route::get('signout', array('as' => 'signout', function () {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }));
   
    // user daashboard 
    Route::get('dashboard', ['as'=>'dashboard' , 'uses'=>'UserController@showDashboard']);
    
    //add news
    Route::post('addnews', ['as'=>'addnews' , 'uses'=>'NewsController@saveNews']);
    
    //delete news
    Route::post('newsdelete', ['as'=>'newsdelete' , 'uses'=>'NewsController@deleteNews']);

});

