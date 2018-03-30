<?php namespace App\Repositories;

interface UserInterface {

	public function create( $data );

	public function update( $data );

	public function delete( $id );

	public function get( $id );

	public function index();
}