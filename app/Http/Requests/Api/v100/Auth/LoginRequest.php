<?php namespace App\Http\Requests\Api\v100\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request {

	protected $default_rules = [
		"email"    => [ "required", "email" ],
		"password" => [ "required", "between:6,1000" ]
	];

	public function authorize() {
		return true;
	}

	public function rules() {
//		return parent::rulesByMethod();
		return $this->default_rules;
	}


	public function withValidator( $validator ) {
		$validator->after( function ( $validator ) {
		} );
	}
}
