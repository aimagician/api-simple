<?php namespace App\Http\Controllers;

use View;

class HomeController extends Controller {
	public function __construct() {
	}

	public function index() {
		return View::make( 'home' );
	}
}
