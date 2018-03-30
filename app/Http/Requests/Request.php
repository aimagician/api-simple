<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

abstract class Request extends FormRequest {
	public function rulesByMethod() {
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE': {
				return [];
			}
			case 'POST': {
				return [
				];
			}
			case 'PUT':
			case 'PATCH': {
				return [
				];
			}
			default:
				break;
		}

		return [];
	}
}
