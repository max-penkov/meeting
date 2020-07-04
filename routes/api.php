<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'as'        => 'api.',
    'namespace' => 'Api',
    'prefix'    => 'api',
], function () {
    Route::get('/members/{event?}', 'MemberController@index')->name('members');
    Route::post('/{event}/members', 'MemberController@create')->name('members.create');
    Route::put('/members/{member}', 'MemberController@edit')->name('members.edit');
    Route::delete('/members/{member}', 'MemberController@delete')->name('members.delete');
});
