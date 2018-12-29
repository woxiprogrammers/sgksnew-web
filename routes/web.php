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
Route::post('/change-city',array('uses' => 'Auth\LoginController@changeCity'));

Route::get('/dashboard',array('uses' => 'Admin\DashboardController@index'));

Route::group(['prefix' => 'member'], function() {
    Route::get('/manage',array('uses' => 'Member\MemberController@manageMembers'));
    Route::get('/create',array('uses' => 'Member\MemberController@createView'));
    Route::post('/create',array('uses' => 'Member\MemberController@create'));
    Route::post('/listing',array('uses' => 'Member\MemberController@memberListing'));
    Route::get('/edit/{member}',array('uses' => 'Member\MemberController@editView'));
    Route::post('/edit/{member}',array('uses' => 'Member\MemberController@edit'));
    Route::get('change-status/{member}',array('uses' => 'Member\MemberController@changeStatus'));
});

Route::group(['prefix' => 'committee'], function() {
    Route::get('/manage',array('uses' => 'Committee\CommitteeController@manageCommittee'));
    Route::get('/create',array('uses' => 'Committee\CommitteeController@createCommitteeView'));
    Route::post('/create',array('uses' => 'Committee\CommitteeController@createCommittee'));
    Route::post('/listing',array('uses' => 'Committee\CommitteeController@committeeListing'));
    Route::get('/edit/{id}',array('uses' => 'Committee\CommitteeController@editCommitteeView'));
    Route::post('/edit/{id}',array('uses' => 'Committee\CommitteeController@editCommittee'));
    Route::get('/change-status/{id}',array('uses' => 'Committee\CommitteeController@changeCommitteeStatus'));
});

Route::group(['prefix' => 'committee-members'], function() {
    Route::get('/manage/{id}',array('uses' => 'Committee\CommitteeController@manageMembers'));
    Route::post('/listing/{id}',array('uses' => 'Committee\CommitteeController@committeeMemberListing'));
    Route::get('/create/{id}',array('uses' => 'Committee\CommitteeController@createMemberView'));
    Route::post('/create/{id}',array('uses' => 'Committee\CommitteeController@createMember'));
    Route::get('/edit/{id}',array('uses' => 'Committee\CommitteeController@editMemberView'));
    Route::post('/edit/{id}',array('uses' => 'Committee\CommitteeController@editMember'));
    Route::get('/change-status/{id}',array('uses' => 'Committee\CommitteeController@changeMemberStatus'));
});

Route::group(['prefix' => 'event'], function (){
    Route::get('/manage', array('uses' => 'Event\EventController@manageEvents'));
    Route::get('/create', array('uses' => 'Event\EventController@createView'));
    Route::post('/create', array('uses' => 'Event\EventController@create'));
    Route::post('/listing', array('uses' => 'Event\EventController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Event\EventController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Event\EventController@edit'));
    Route::get('/change-status/{id}',array('uses' => 'Event\EventController@changeStatus'));
    Route::get('/delete-image/{id}',array('uses' => 'Event\EventController@deleteEventImage'));
});

Route::group(['prefix' => 'account'], function() {
    Route::get('/manage', array('uses' => 'Account\AccountController@manage'));
    Route::get('/create', array('uses' => 'Account\AccountController@createView'));
    Route::post('/create', array('uses' => 'Account\AccountController@create'));
    Route::post('/listing', array('uses' => 'Account\AccountController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Account\AccountController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Account\AccountController@edit'));
    Route::get('/delete-image/{id}',array('uses' => 'Account\AccountController@deleteAccountImage'));
    Route::get('/change-status/{id}',array('uses' => 'Account\AccountController@changeStatus'));
});

Route::group(['prefix' => 'message'], function() {
    Route::get('/manage', array('uses' => 'Message\MessageController@manage'));
    Route::get('/create', array('uses' => 'Message\MessageController@createView'));
    Route::post('/create', array('uses' => 'Message\MessageController@create'));
    Route::post('/listing', array('uses' => 'Message\MessageController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Message\MessageController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Message\MessageController@edit'));
    Route::get('/delete-image/{id}', array('uses' => 'Message\MessageController@deleteImage'));
    Route::get('/change-status/{id}', array('uses' => 'Message\MessageController@changeStatus'));
});

Route::group(['prefix' => 'classified'], function() {
    Route::get('/manage', array('uses' => 'Classified\ClassifiedController@manage'));
    Route::get('/create', array('uses' => 'Classified\ClassifiedController@createView'));
    Route::post('/create', array('uses' => 'Classified\ClassifiedController@create'));
    Route::post('/listing', array('uses' => 'Classified\ClassifiedController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Classified\ClassifiedController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Classified\ClassifiedController@edit'));
    Route::get('/get-all-package/{id}', array('uses' => 'Classified\ClassifiedController@getAllPackageType'));
    Route::get('/change-status/{id}', array('uses' => 'Classified\ClassifiedController@changeStatus'));
    Route::get('/delete-image/{id}',array('uses' => 'Classified\ClassifiedController@deleteClassifiedImage'));
});

Route::group(['prefix' => 'cities'], function() {
    Route::get('/manage', array('uses' => 'Cities\CityController@manage'));
    Route::get('/create', array('uses' => 'Cities\CityController@createView'));
    Route::post('/create', array('uses' => 'Cities\CityController@create'));
    Route::post('/listing', array('uses' => 'Cities\CityController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Cities\CityController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Cities\CityController@edit'));
    Route::get('/change-status/{id}', array('uses' => 'Cities\CityController@changeStatus'));

});

Route::group(['prefix' => 'webview'], function() {
    Route::get('/manage', array('uses' => 'Webview\WebviewController@manage'));
    Route::get('/create', array('uses' => 'Webview\WebviewController@createView'));
    Route::post('/create', array('uses' => 'Webview\WebviewController@create'));
    Route::post('/listing', array('uses' => 'Webview\WebviewController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Webview\WebviewController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Webview\WebviewController@edit'));
});

Route::group(['prefix' => 'suggestion'], function() {
    Route::get('/manage', array('uses' => 'Suggestion\SuggestionController@manage'));
    Route::post('/listing', array('uses' => 'Suggestion\SuggestionController@listing'));
    Route::get('/view/{id}', array('uses' => 'Suggestion\SuggestionController@view'));
});