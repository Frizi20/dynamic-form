<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Getting started with JSON Form</title>
	<link rel="stylesheet" style="text/css" href="{{asset('assets/js/jsonForm/deps/opt/bootstrap.css')}}" />
</head>

<body>

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			min-height: 100vh;
			display: flex;
			justify-content: space-around;
			align-items: center;
		}

		.form-container {
			width: 500px;
		}

		.jsonform-required>label:after {
			content: ' xxxxxxxxxxxxxxxxxx*';
			color: red;
		}

		.jsonform-hasrequired:after {
			content: '*xxxxxxx Required field';
			display: block;
			color: red;
			padding-top: 1em;
		}
	</style>

	<h1>Getting started with JSON Form</h1>

	<div class="form-container">
		<form></form>
	</div>

	<div id="res" class="alert"></div>



	<script type="text/javascript" src="{{ asset('assets/js/jsonForm/deps/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jsonForm/deps/underscore.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jsonForm/deps/opt/jsv.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jsonForm/lib/jsonform.js')}}"></script>

	<script type="text/javascript" src="{{ asset('assets/js/jsonForm/deps/opt/jsv.js')}}"></script>

	{{-- form schema --}}
	<script type="text/javascript" src="{{asset('assets/js/jsonFormSchema.js')}}"></script>


	<script type="text/javascript">
		let json

     const form = $('form').jsonForm(schema);
	 $('form').attr('novalidate', 'novalidate')

	 function submitForm(err,values){
		console.log(err)
		const report = JSV.createEnvironment('json-schema-draft-03').validate(values, schema);
		console.log({
			values,
			schema,
			report
		})
	 }


	 

	</script>


</body>

</html>
