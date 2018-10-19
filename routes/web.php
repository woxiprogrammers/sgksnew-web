<?php

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

Route::get('/',array('uses' => 'Admin\AdminController@viewLogin'));
Route::post('/authenticate',array('uses' => 'Auth\LoginController@login'));
Route::get('/logout',array('uses' => 'Auth\LoginController@logout'));

Route::get('/dashboard',array('uses' => 'Admin\DashboardController@index'));

Route::group(['prefix' => 'members'], function() {
    Route::get('/manage-members',array('uses' => 'members\memberController@manageMembers'));
    Route::get('/createView',array('uses' => 'members\memberController@createMembersView'));
    Route::get('/create',array('uses' => 'members\memberController@createMembers'));
});

Route::group(['prefix' => 'committee'], function() {
    Route::get('/manage-committee',array('uses' => 'committee\committeeController@manageCommittee'));

});