<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<title>Document</title>
</head>
<body>

	<style>

		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body{
			display: flex;

			justify-content: center;
			min-height: 100vh;
		}

		.form-wrapper{
			margin-top: 200px;
			width: 700px;
			height: 600px;
		}
	</style>


	<div class="form-wrapper">
		<div id="editor_holder"></div>
	</div>

	{{-- <script src="https://cdn.jsdelivr.net/npm/@json-editor/json-editor@latest/dist/jsoneditor.min.js"></script> --}}
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('assets/js/schema.js') }}"></script>
	<!-- JavaScript Bundle with Popper -->

	<script>

		const element = document.getElementById('editor_holder');

		// Set an option globally
		// JSONEditor.defaults.options.theme = 'bootstrap4';

		// Set an option during instantiation
		const editor = new JSONEditor(element, {
		  schema:schema,
		  theme: 'bootstrap4',
		  disable_array_delete:false,
		  disable_array_delete_last_row:false,
		  disable_collapse:true,
		  disable_edit_json:false,
		  disable_edit_json:true
		});

	</script>

</body>
</html>
