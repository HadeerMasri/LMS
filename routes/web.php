<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['web']], function () {


    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

        Route::group(['middleware' => ['role:admin']], function () {
            //
            // Route::get('/', 'DashboardController@index')->name('dashboard.index');

            // Route::get('/', function () {
            // return redirect('admin/dashboard');
            // });
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');
            Route::resource('dashboard', 'DashboardController');

            Route::prefix('manage')->name('manage.')->group(function () {
               Route::resource('users', 'Admin\UserController');



            });
        });



    });


    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});

Auth::routes();

