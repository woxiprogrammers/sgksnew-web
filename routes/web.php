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

Route::group(['prefix' => 'member'], function() {
    Route::get('/manage',array('uses' => 'Member\MemberController@manageMembers'));
    Route::get('/create',array('uses' => 'Member\MemberController@createView'));
    Route::post('/create',array('uses' => 'Member\MemberController@create'));
    Route::post('/listing',array('uses' => 'Member\MemberController@memberListing'));
    Route::get('/edit/{member}',array('uses' => 'Member\MemberController@editView'));
    Route::post('/edit/{member}',array('uses' => 'Member\MemberController@edit'));
    Route::get('/get-all-states/{id}',array('uses' => 'Member\MemberController@getAllStates'));
    Route::get('/get-all-city/{id}',array('uses' => 'Member\MemberController@getAllCities'));
    Route::get('change-status/{member}',array('uses' => 'Member\MemberController@changeStatus'));
});

Route::group(['prefix' => 'committee'], function() {
    Route::get('/manage',array('uses' => 'Committee\CommitteeController@manageCommittee'));
    Route::get('/create',array('uses' => 'Committee\CommitteeController@createCommitteeView'));
    Route::post('/create',array('uses' => 'Committee\CommitteeController@createCommittee'));
    Route::post('/listing',array('uses' => 'Committee\CommitteeController@committeeListing'));
    Route::get('/edit/{id}',array('uses' => 'Committee\CommitteeController@editCommitteeView'));
    Route::post('/edit/{id}',array('uses' => 'Committee\CommitteeController@editCommittee'));
    Route::get('/get-all-states/{id}',array('uses' => 'Committee\CommitteeController@getAllStates'));
    Route::get('/get-all-cities/{id}',array('uses' => 'Committee\CommitteeController@getAllCities'));
    Route::get('/change-status/{id}',array('uses' => 'Committee\CommitteeController@changeCommitteeStatus'));
});

Route::group(['prefix' => 'committee-members'], function() {
    Route::get('/manage/{id}',array('uses' => 'Committee\CommitteeController@manageMembers'));
    Route::post('/listing/{id}',array('uses' => 'Committee\CommitteeController@committeeMemberListing'));
    Route::get('/create/{id}',array('uses' => 'Committee\CommitteeController@createMemberView'));
    Route::post('/create/{id}',array('uses' => 'Committee\CommitteeController@createMember'));
    Route::get('/edit/{id}',array('uses' => 'Committee\CommitteeController@editMemberView'));
    Route::post('/edit/{id}',array('uses' => 'Committee\CommitteeController@editMember'));
});

Route::group(['prefix' => 'event'], function (){
    Route::get('/manage', array('uses' => 'Event\EventController@manageEvents'));
    Route::get('/create', array('uses' => 'Event\EventController@createView'));
    Route::post('/create', array('uses' => 'Event\EventController@create'));
    Route::post('/listing', array('uses' => 'Event\EventController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Event\EventController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Event\EventController@edit'));
    Route::get('/get-all-states/{id}', array('uses' => 'Event\EventController@getAllStates'));
    Route::get('/get-all-cities/{id}', array('uses' => 'Event\EventController@getAllCities'));
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
    Route::get('/get-all-states/{id}', array('uses' => 'Account\AccountController@getAllStates'));
    Route::get('/get-all-cities/{id}', array('uses' => 'Account\AccountController@getAllCities'));
    Route::get('/delete-image/{id}',array('uses' => 'Account\AccountController@deleteAccountImage'));
});

Route::group(['prefix' => 'message'], function() {
    Route::get('/manage', array('uses' => 'Message\MessageController@manage'));
    Route::get('/create', array('uses' => 'Message\MessageController@createView'));
    Route::post('/create', array('uses' => 'Message\MessageController@create'));
    Route::post('/listing', array('uses' => 'Message\MessageController@listing'));
    Route::get('/edit/{id}', array('uses' => 'Message\MessageController@editView'));
    Route::post('/edit/{id}', array('uses' => 'Message\MessageController@edit'));
    Route::get('/delete-image/{id}', array('uses' => 'Message\MessageController@deleteImage'));
    Route::get('/get-all-states/{id}', array('uses' => 'Message\MessageController@getAllStates'));
    Route::get('/get-all-cities/{id}', array('uses' => 'Message\MessageController@getAllCities'));
    Route::get('/change-status/{id}', array('uses' => 'Message\MessageController@changeStatus'));
});