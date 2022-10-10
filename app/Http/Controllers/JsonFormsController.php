<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

use function PHPSTORM_META\type;

class JsonFormsController extends Controller
{
	public function index()
	{
		return view('jsonForm');
	}

	public function create(Request $request)
	{

		$data = $request->all();


		// return response()->json(gettype($data));

		$formCreated = Form::create([
			'data' => \json_encode($data)
		]);



		return response()->json($formCreated);
	}
}
