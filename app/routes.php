<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//GET Requests
Route::get('/', array('uses' => 'HomeController@showWelcome'));
Route::get('main' , array('before' => 'auth' ,'uses' => 'HomeController@showMain'));
Route::get('profile', array('before' => 'auth' , 'uses'=> 'HomeController@showProfile'));
Route::get('orders', array('before' => 'auth' , 'uses'=> 'OrderController@showOrders'));
Route::get('tickets', array('before' => 'auth' ,'uses'=> 'TicketController@showTickets'));
Route::get('logout', array('before' => 'auth' ,'uses' => 'HomeController@doLogout'));
Route::get('register',array('uses'=>'HomeController@showRegister'));
Route::get('accounts',array('before' => 'auth' ,'uses'=>'HomeController@showAccounts'));
Route::get('viewOrder/{any}',array('before' => 'auth' ,'uses'=>'OrderController@viewOrder'));
Route::get('viewTicket/{any}',array('before' => 'auth' ,'uses'=>'TicketController@viewTicket'));
Route::get('password/activation/{any}',array('uses'=>'HomeController@passwordActivate'));
Route::get('password/forget',array('uses'=>'HomeController@showPasswordForget'));
Route::get('password/reset',array('uses'=>'HomeController@showPasswordForget'));
Route::get('password/reset/{any}',array('uses'=>'HomeController@passwordReset'));

//Admin GET Requests
Route::get('admin/tickets', array('before' => 'auth' ,'uses'=> 'TicketController@showTicketsAdmin'));
Route::get('admin/viewTicket/{any}',array('before' => 'auth' ,'uses'=>'TicketController@viewTicketAdmin'));
Route::get('admin/orders', array('before' => 'auth' ,'uses'=> 'OrderController@showOrdersAdmin'));
Route::get('admin/viewOrder/{any}',array('before' => 'auth' ,'uses'=>'OrderController@viewOrderAdmin'));

//POST Requests
Route::post('login', array('before' => 'csrf','uses' => 'HomeController@doLogin'));
Route::post('profile', array('before' => 'csrf','uses'=> 'HomeController@doProfile'));
Route::post('orders', array('before' => 'csrf','uses'=> 'OrderController@doOrders'));
Route::post('tickets', array('before' => 'csrf','uses'=> 'TicketController@doTickets'));
Route::post('updateProfile', array('before' => 'csrf','uses'=> 'HomeController@updateProfile'));
Route::post('answerCreate', array('before' => 'csrf','uses'=> 'TicketController@createAnswer'));
Route::post('updateTicket', array('before' => 'csrf','uses'=> 'TicketController@updateTicket'));
Route::post('password/reset',array('before' => 'csrf','uses'=>'HomeController@passwordUpdate'));
Route::post('password/createReset',array('before' => 'csrf','uses'=>'HomeController@createReset'));

//Admin POST Requests
Route::post('admin/updateOrder',array('before' => 'csrf','uses'=>'OrderController@updateOrderAdmin'));

//Social Connect
Route::get('connect/facebook',array('uses'=>'SocialLoginController@loginWithFacebook'));
Route::get('connect/twitter',array('uses'=>'SocialLoginController@loginWithTwitter'));
Route::get('connect/google',array('uses'=>'SocialLoginController@loginWithGoogle'));

Route::post('payment',array('uses'=>'PaypalController@prepareExpressCheckout','as'=>'payment'));
Route::get('payment_done/{any}',array('uses'=>'PaypalController@done','as'=>'payment_done'))->where('any', '.*');