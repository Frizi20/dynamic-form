<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormSchema;
use Illuminate\Support\Facades\Schema;

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

		$formCreated = Form::create([
			'data' => \json_encode($data)
		]);



		return response()->json($formCreated);
	}

	public function getFormSchema()
	{
		$schema = new FormSchema();

		return response()->json($schema->first());
	}



	public function buildSurvey(){
		return view('surveyBuilder');
	}



	public function updateSchema(Request $request){

		$formId = $request->id;
		$schemaData = $request->schemaData;



		$formSchema = FormSchema::findOrFail($formId);
		$updatedFormSchema = $formSchema->update([
			'schema' => $schemaData
		]);


		if($updatedFormSchema) return response()->json([
			'status'  => 'ok',
			'message' => 'Form Updated'
		]);




	}


}
