<?php

$cnf     = config( "app.version_live" );
$version = "v{$cnf}";

// test case
//$this->get( '/index', [ "as" => "api.{$version}.index", "uses" => "Api\ApiController@index" ] )->middleware( 'auth:api' );
$this->get( '/index', [ "as" => "api.{$version}.index", "uses" => "Api\ApiController@index" ] );

Route::group( [ "group" => "api-{$version}", "prefix" => "{$version}", 'namespace' => "Api\\{$version}" ], function () use ( $version ) {

	//users
	Route::group( [ "prefix" => "users" ], function () use ( $version ) {
		Route::group( [ 'middleware' => 'auth:api' ], function () use ( $version ) {
			$this->get( '/list', [ "as" => "api.{$version}.users.index", "uses" => "UsersController@index" ] );
			$this->get( '/get', [ "as" => "api.{$version}.users.index", "uses" => "UsersController@get" ] );
			$this->get( '/delete', [ "as" => "api.{$version}.users.delete", "uses" => "UsersController@delete" ] );
			$this->post( '/update', [ "as" => "api.{$version}.users.index", "uses" => "UsersController@update" ] );

		} );
	} );

	Route::group( [ "prefix" => "auth" ], function () use ( $version ) {
		Route::group( [], function () use ( $version ) {
			$this->post( '/social', [ "as" => "api.{$version}.auth.social", "uses" => "AuthController@social" ] );
			$this->post( '/register', [ "as" => "api.{$version}.auth.register", "uses" => "AuthController@register" ] );
			$this->post( '/login', [ "as" => "api.{$version}.auth.login", "uses" => "AuthController@login" ] );
			$this->post( '/logout', [ "as" => "api.{$version}.auth.logout", "uses" => "AuthController@logout" ] );
			$this->get( '/password-forgot', [ "as" => "api.{$version}.auth.forgot-password", "uses" => "AuthController@password_forgot" ] );
			$this->get( '/password-reset', [ "as" => "api.{$version}.auth.reset-password", "uses" => "AuthController@password_reset" ] );
		} );
	} );

} );