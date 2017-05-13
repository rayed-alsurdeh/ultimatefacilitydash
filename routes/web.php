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

Route::get('/','HomeController@home');
Route::get('login','Auth\LoginController@showLoginForm');
Route::post('login','Auth\LoginController@login');
Route::get('logout','Auth\RegisterController@logout');

Route::get('users','Auth\RegisterController@showRegistrationForm');
Route::post('register','Auth\RegisterController@register');
Route::post('update_user','Auth\RegisterController@update_user');
Route::get('/','Home\HomeController@home');
Route::get('getUserInfo','AjaxHelper\AjaxHelper@getUserInfo');
Route::get('delUser','AjaxHelper\AjaxHelper@delUser');
Route::get('blockUser','AjaxHelper\AjaxHelper@blockUser');
Route::get('unblockUser','AjaxHelper\AjaxHelper@unBlockUser');

Route::get('getAllUsers','AjaxHelper\AjaxHelper@getAllUsers');
Route::get('getAllSites','AjaxHelper\AjaxHelper@getAllSites');
Route::get('getRooms','AjaxHelper\AjaxHelper@getRooms');

// Site Controller
Route::get('sites','Site\SiteController@sites');
Route::get('addsite','Site\AddSiteController@showAddSite');
Route::post('addsite','Site\AddSiteController@AddSite');
Route::post('updateSite','Site\AddSiteController@updateSite');
Route::post('addRoom','Site\AddSiteController@AddRoom');
Route::get('getSiteInfo','Site\AddSiteController@getSiteInfo');
Route::get('genrateInvoice','Site\SiteController@genrateInvoice');


//job Controller
Route::get('addjob','Site\JobController@showAddJobForm');
Route::get('editjob','Site\JobController@showEditJobForm');
Route::post('editjob','Site\JobController@editJob');
Route::post('addnewjob','Site\JobController@addJob');
Route::get('jobs','Site\JobController@showJobs');
Route::get('canceljob','Site\JobController@cancelJob');
Route::get('confirmjob','Site\JobController@confirmJob');
Route::get('finishJob','Site\JobController@finishJob');
Route::post('recordfinishjob','Site\JobController@recordFinishJob');
Route::get('editJobCost','Site\JobController@editJobCost');
Route::post('editJobCost','Site\JobController@editJobCost_post');
Auth::routes();
Route::get('/home', 'HomeController@index');
