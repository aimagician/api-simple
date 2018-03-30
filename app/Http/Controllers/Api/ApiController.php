<?php namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Controllers\Controller;
use HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class ApiController extends Controller {

	public function index() {
		return [];
	}

	public function createSuccessResponse( $data ) {
		if ( Auth::check() ) {
			$user  = Auth::user();
			$token = $user->createToken( config( "app.name" ) )->accessToken;
		} else {
			$token = null;
		}

		return response()->json( array_merge( $data, [ "result" => true, "token" => $token ] ), Response::HTTP_OK );
	}

	public function createErrorResponse( $message, $code ) {
		return response()->json( [ 'data' => null, 'error' => [ 'code' => $code, 'message' => $message ], "result" => false, "token" => null ], $code );
	}

	protected function buildFailedValidationResponse( Request $request, array $errors ) {
		return $this->createErrorResponse( $errors, Response::HTTP_UNPROCESSABLE_ENTITY );
	}
}
