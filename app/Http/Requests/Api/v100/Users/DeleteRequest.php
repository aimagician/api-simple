<?php namespace App\Http\Requests\Manage;

use App\Http\Requests\Request;

class DeleteRequest extends Request {

	protected $default_rules = [
		"email"      => [ "required", "email", "unique:users,email" ],
		"username"   => [ "required", "between:3,100", "unique:users,username" ],
	];

	protected $post_rules = [
		"password"              => [ "required", "between:6,1000", "confirmed" ],
		"password_confirmation" => [ "required", "between:6,1000" ]
	];

	protected $patch_rules = [
		"id"       => [ "required", "integer", "min:1" ],
		"email"    => [ ],
		"username" => [ ]
	];

	protected $put_rules = [

	];


	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {


	}

}
