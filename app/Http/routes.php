<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
    Route::get('/a/{art_id}.html','Home\IndexController@article');

    Route::any('admin/login','Admin\LoginController@login');
    Route::get('admin/code','Admin\LoginController@code');
    Route::get('admin/crypt','Admin\LoginController@crypt');
    Route::any('/message','Home\IndexController@message');

});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    
    Route::get('/','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');
    Route::any('root','RootController@index');
    Route::any('article/search','ArticleController@search');

    Route::resource('mes','MessageController');

    Route::post('cate/changeOrder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');


    Route::resource('article','ArticleController');

    Route::post('links/changeOrder','LinksController@changeOrder');
    Route::resource('links','LinksController');

    Route::post('navs/changeOrder','NavsController@changeOrder');
    Route::resource('navs','NavsController');

    Route::post('config/changeOrder','ConfigController@changeOrder');
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::get('config/putfile','ConfigController@putFile');
    Route::resource('config','ConfigController');


    Route::any('upload','CommonController@upload');
});
