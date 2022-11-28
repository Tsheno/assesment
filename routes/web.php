<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
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

    $all = User::all();

    if((count($all)> 0)):
        return view('welcome');
    else:
        return view('/setup');
    endif;
});

Route::get('/editCompany/{id}', 'HomeController@editCompany');
Route::get('/deleteCompany/{id}', 'HomeController@deleteCompany');
Route::get('/createCompany/', 'HomeController@createCompany');

Route::get('/createUser/', 'HomeController@createUser');
Route::get('/editUser/{id}', 'HomeController@editUser');
Route::get('/deleteUser/{id}', 'HomeController@deleteUser');

Route::resource('company', 'CompanyController');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');
Route::get('/companies', [App\Http\Controllers\HomeController::class, 'companies'])->name('companies');
Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');
Route::post('/change-company-details', [App\Http\Controllers\HomeController::class, 'updateCompanyDetails'])->name('update-company-details');
Route::post('/change-details', [App\Http\Controllers\HomeController::class, 'updateUserDetails'])->name('update-details');
Route::post('/create-company', [App\Http\Controllers\HomeController::class, 'storeCompanyDetails'])->name('create-company');

Route::post('/create-user', [App\Http\Controllers\HomeController::class, 'storeUserDetails'])->name('create-user');
Route::post('/change-user-details', [App\Http\Controllers\HomeController::class, 'updateDetails'])->name('update-user-details');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function () {

    Route::get('permissions-all-users',['middleware'=>'check-permission:user|admin|superadmin','uses'=>'HomeController@allUsers']);

    Route::get('permissions-admin-superadmin',['middleware'=>'check-permission:admin|superadmin','uses'=>'HomeController@adminSuperadmin']);

    Route::get('permissions-superadmin',['middleware'=>'check-permission:superadmin','uses'=>'HomeController@superadmin']);

});
