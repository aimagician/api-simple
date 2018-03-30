<?php namespace App\Http\Controllers\Api\v100;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class AuthController extends ApiController {
	protected $service_auth;
	protected $service_user;

	public function __construct( AuthService $auth_service, UserService $user_service ) {
		$this->service_auth = $auth_service;
		$this->service_user = $user_service;
	}

	public function logout() {
		$data = $this->service_auth->logout();

		if ( ! $data ) {
			$message = "Wrong request!";

			return $this->createErrorResponse( $message, Response::HTTP_OK );
		}

		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}


	public function login( Request $request ) {

		$validator = Validator::make( $request->all(), [
			'email'    => [ 'required', 'email' ],
			'password' => [ 'required', 'min:6', 'max:100' ]
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$data = $this->service_auth->login( [
			'email'    => $request->get( 'email' ),
			'password' => $request->get( 'password' )
		] );

		if ( ! $data ) {
			$message = 'Email/Password combination is not good';

			return $this->createErrorResponse( $message, Response::HTTP_OK );
		}

		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );

	}

	public function register( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'email'                 => [ 'required', 'email', 'unique:users' ],
			'password'              => [ 'required', 'min:6', 'max:100', 'confirmed' ],
			'password_confirmation' => [ 'required', 'min:6', 'max:100' ]
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$data = $this->service_auth->register( $request->all() );

		if ( ! $data ) {
			$message = 'Unable to register new account';

			return $this->createErrorResponse( $message, Response::HTTP_OK );
		}

		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	public function social( Request $request ) {

		$validator = Validator::make( $request->all(), [
			'email' => [ 'required', 'email' ],
			'token' => [ 'required' ],
			'type'  => [ 'required', 'in:facebook' ]
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$data = $this->service_auth->social(
			[
				'email' => $request->get( 'email' ),
				'token' => $request->get( 'token' ),
				'type'  => $request->get( 'type' )
			]
		);

		if ( ! $data ) {
			$message = 'Unable to access account';

			return $this->createErrorResponse( $message, Response::HTTP_OK );
		}

		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	public function email_check( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'email' => [ 'required', 'email' ],
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$email  = $request->get( "email" );
		$data   = $this->service_auth->email_check( $email );
		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	public function index() {
		$data = $this->service_user->index();

		if ( ! $data ) {
			$message = "Wrong request!";

			return $this->createErrorResponse( $message, Response::HTTP_OK );
		}

		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );

	}
}
