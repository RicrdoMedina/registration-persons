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

Route::group(['middleware' => ['web']], function () {
	Route::get('/', [
    	'as' => 'auth/login', 'uses' => 'LogController@index'
	]);

	Route::post('auth/login', [
    	'as' => 'auth/login', 'uses' => 'LogController@store'
	]);
  
	Route::get('auth/logout', [
    	'as' => 'auth/logout', 'uses' => 'LogController@logout'
	]);
	
});

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

Route::group(['namespace' => 'Admin','middleware' => ['web','auth']], function()
{
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('registrar/usuario', [
    	'as' => 'registrar/usuario', 'uses' => 'AdminController@create'
	]);

	Route::post('guardar/usuario', [
    	'as' => 'guardar/usuario', 'uses' => 'AdminController@store'
	]);

	Route::get('consultar/usuarios', [
    	'as' => 'consultar/usuarios', 'uses' => 'AdminController@users'
  ]);
  
  Route::post('consultar/usuarios', [
    'as' => 'consultar/usuarios', 'uses' => 'AdminController@filterUsers'
]);

	Route::post('editar/user', [
    	'as' => 'editar/user', 'uses' => 'AdminController@editUser'
	]);

	Route::post('editar/user', [
    	'as' => 'editar/user', 'uses' => 'AdminController@edit'
	]);

	Route::post('actualizar/user', [
    	'as' => 'actualizar/user', 'uses' => 'AdminController@update'
	]);

 	Route::group(['namespace' => 'User'], function()
 	{
        // Controllers Within The "App\Http\Controllers\Admin\User" Namespace
        Route::get('home', [
	    	'as' => 'home', 'uses' => 'UserController@home'
		]);

        Route::get('acceso/restringido', [
	    	'as' => 'access', 'uses' => 'UserController@noAccess'
		]);

        Route::get('registrar/visita', [
	    	'as' => 'registrar/visita', 'uses' => 'UserController@create'
		]);

		Route::post('guardar/visita', [
	    	'as' => 'guardar/visita', 'uses' => 'UserController@store'
		]);

		Route::any('consultar/visitas', [
    		'as' => 'consultar/visitas', 'uses' => 'UserController@visits'
		]);

		Route::any('consultar/visitantes', [
    		'as' => 'consultar/visitantes', 'uses' => 'UserController@users'
		]);

		Route::post('buscar', [
	    	'as' => 'buscar', 'uses' => 'UserController@searchUser'
		]);

		Route::get('total', [
    		'as' => 'total', 'uses' => 'UserController@totalRegistros'
		]);

		Route::any('usuario/{id}',[
    		'as' => 'usuarioVisitas', 'uses' => 'UserController@userVisits'
		]);

		Route::post('editar/usuario', [
	    	'as' => 'editar', 'uses' => 'UserController@editUser'
		]);

		Route::post('editar/visita', [
	    	'as' => 'editarVisita', 'uses' => 'UserController@editVisit'
		]);

		Route::post('actualizar/usuario', [
	    	'as' => 'actualizarUsuario', 'uses' => 'UserController@update'
		]);

		Route::post('actualizar/visita', [
	    	'as' => 'actualizarVisita', 'uses' => 'UserController@updateVisit'
		]);

 	});
});
