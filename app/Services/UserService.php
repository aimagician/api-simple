<?php namespace App\Services;


use App\Models\User;
use App\Repositories\UserInterface;
use Auth;
use Exception;
use Illuminate\Database\QueryException;
use Laravel\Socialite\Facades\Socialite;

class UserService implements UserInterface {

	public function create( $data ) {
		$user = false;
		try {
			$user = User::create( $data );
		} catch ( QueryException $e ) {
			return false;
		} catch ( Exception $e ) {
			return false;
		} finally {
			return $user;
		}
	}

	public function delete( $id ) {
		try {
			User::where( "id", "=", $id )->delete();
		} catch ( QueryException $e ) {
			return false;
		} catch ( Exception $e ) {
			return false;
		} finally {
			return true;
		}
	}

	#TODO what to update
	public function update( $data ) {
		$id = $data["id"];
		try {
			User::where( "id", "=", $id )->update();
		} catch ( QueryException $e ) {
			return false;
		} catch ( Exception $e ) {
			return false;
		} finally {
			return true;
		}
	}

	public function get( $id ) {
		return User::find( $id );
	}

	public function index() {
		return User::all();
	}

}