<?php namespace App\Http\Controllers\Api\v100;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UsersController extends ApiController {
	protected $service_user;
	protected $service_auth;

	public function __construct( UserService $userService, AuthService $auth_service ) {
		$this->service_user = $userService;
		$this->service_auth = $auth_service;
	}

	public function update( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'id' => [ 'required', 'integer' ],
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$data   = $this->service_user->update( $request->all() );
		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	public function get( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'id' => [ 'required', 'integer' ],
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$id     = $request->get( "id" );
		$data   = $this->service_user->get( $id );
		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	public function delete( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'id' => [ 'required', 'integer' ],
		] );

		if ( $validator->fails() ) {
			return $this->createErrorResponse( $validator->messages()->all(), Response::HTTP_UNPROCESSABLE_ENTITY );
		}

		$id     = $request->get( "id" );
		$data   = $this->service_user->delete( $id );
		$output = [ 'data' => $data, 'error' => null ];

		return $this->createSuccessResponse( $output );
	}

	# TODO Done
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
