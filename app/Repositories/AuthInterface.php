<?php namespace App\Repositories;

interface AuthInterface {

	public function login( $data );

	public function logout();

	public function register( $data );

	public function social( $data );

	public function email_check( $email );

	public function password_forgot( $email );

	public function password_reset( $email );

	public function index();
}