<?php namespace App\Http\Requests\Site;

use App\Http\Requests\Request;

class RegisterRequest extends Request {

	protected $default_rules = [
		"email"   => [ "required", "email", "max:255" ]
	];

	protected $post_rules = [
	];

	protected $patch_rules = [
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

	public function rules() {
		return $this->default_rules;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
		});
	}

}
