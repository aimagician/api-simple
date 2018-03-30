<?php namespace App\Services;


use App\Models\User;
use App\Repositories\AuthInterface;
use Auth;
use Exception;
use Socialite;

class AuthService implements AuthInterface {
	protected $service_user;

	public function __construct( UserService $user_service ) {
		$this->service_user = $user_service;
	}

	public function password_forgot( $email ) {
		// TODO: Implement forgot_password() method.
	}

	public function password_reset( $email ) {
		// TODO: Implement reset_password() method.
	}

	public function email_check( $email ) {
		$result = User::where( "email", "=", $email )->first( [ 'id' ] );

		if ( isset( $result->id ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function register( $data ) {

		$email    = $data["email"];
		$password = bcrypt( $data["password"] );
		$provider = "email";

		$obj = [
			'email'    => $email,
			'name'     => $email,
//			'username' => $email,
//			'provider' => $provider,
			'password' => $password,
		];

		$user = $this->service_user->create( $obj );

		if ( ! $user ) {
			return false;
		} else {
			Auth::loginUsingId( $user->id );
		}


		return $user;
	}

	public function login( $data ) {
		$attempt = Auth::attempt( [
			"email"    => $data["email"],
			"password" => $data["password"],
		] );

		if ( $attempt == true ) {
			return true;
		} else {
			return false;
		}
	}

	public function social( $data ) {
		$email    = $data["email"];
		$name     = $data["email"];
		$type     = $data["type"];
		$token    = $data["token"];
		$password = bcrypt( $email );

		try {
			$user = Socialite::driver( $type )->userFromToken( $token );
			if ( $user ) {
				if ( $user->email != $email ) {
					return false;
				}
			}
		} catch ( Exception $e ) {
			dd( $e );

			return false;
		}

		if ( User::where( "email", "=", $data["email"] )->count() == 0 ) {

			$provider = $type;

			$obj = [
				'email'    => $email,
				'name'     => $email,
//				'username' => $email,
//				'provider' => $provider,
				'password' => $password,
			];

			$user = $this->service_user->create( $obj );

			if ( ! $user ) {
				return false;
			} else {
				Auth::loginUsingId( $user->id );
			}

			return $user;
		} else {
			$user = User::where( "email", "=", $data["email"] )->first();
			Auth::loginUsingId( $user->id );

			return $user;
		}

	}

	public function logout() {
		Auth::logout();

		return true;
	}

	public function index() {
		return true;
	}
}