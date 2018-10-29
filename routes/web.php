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
    Route::get('/edit/{id}',array('uses' => 'Member\MemberController@editView'));
    Route::post('/edit/{id}',array('uses' => 'Member\MemberController@edit'));
    Route::get('/get-all-states/{id}',array('uses' => 'Member\MemberController@getAllStates'));
    Route::get('/get-all-city/{id}',array('uses' => 'Member\MemberController@getAllCities'));
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

});

Route::group(['prefix' => 'committee-members'], function() {
    Route::get('/manage/{id}',array('uses' => 'Committee\CommitteeController@manageMembers'));
    Route::post('/listing',array('uses' => 'Committee\CommitteeController@committeeMemberListing'));
    Route::get('/create/{id}',array('uses' => 'Committee\CommitteeController@createMemberView'));
    Route::post('/create/{id}',array('uses' => 'Committee\CommitteeController@createMember'));
});