<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<title>Document</title>
</head>

<body>

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			display: flex;

			justify-content: center;
			min-height: 100vh;
		}

		.form-wrapper {
			margin-top: 200px;
			width: 700px;
			height: 600px;
		}

		.btn-center {
			position: relative;
			left: 50%;
			transform: translateX(-50%);
		}
	</style>


	<div class="form-wrapper">
		<div id="editor_holder"></div>
	</div>

	{{-- <script src="https://cdn.jsdelivr.net/npm/@json-editor/json-editor@latest/dist/jsoneditor.min.js"></script>
	--}}
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
	</script>

	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('assets/js/schema.js') }}"></script>
	<!-- JavaScript Bundle with Popper -->

	<script defer>

		function init(){

			const element = document.getElementById('editor_holder');

			JSONEditor.prototype.showErrors = function() {
  				this.setOption('show_errors','always');
			}
			JSONEditor.prototype.hideErrors = function() {
			  this.setOption('show_errors','never');
			}

			JSONEditor.defaults.callbacks = {
				button : {
				submitForm : function (jseditor, e) {
						const errors = jseditor.jsoneditor.validate()
						console.log(errors)
						if(errors.length !== 0){
							jseditor.jsoneditor.showErrors()
						}else{
							console.log(jseditor)
							//Post form Data
							const data = jseditor.jsoneditor.getValue()
							postForm(JSON.stringify(data))

						}
					}
				}
			}

			JSONEditor.defaults.custom_validators.push((schema, value, path)=>{
				const errors = []


				if(schema.type == 'string'  && value.length < 1){
					errors.push({
					path: path,
					property: 'format',
					message: `Campul ${schema.title} trebuie completat`
					});
				}
				return errors
			})

			const getSchemaData = async function(){

				try {
					const response = await fetch('/get-form-schema')
					if(!response?.ok) throw new Error('Schema could not be fetched!')
					const schemaData = await response.json()
					const schema = schemaData.schema
					return schema
				} catch (error) {
					console.error(error)
					return ''
				}


			}

			const createForm = async function () {

				try {
					const schema = await  getSchemaData()
					if(!schema) throw new Error('No schema to build form')

					const parsedSchema = JSON.parse(schema)

					console.log(parsedSchema)

					const editor = new JSONEditor(element, {
					  schema:parsedSchema,
					  theme: 'bootstrap4',
					  disable_array_delete:false,
					  disable_array_delete_last_row:false,
					  disable_collapse:true,
					  required_by_default:false,
					  disable_edit_json:true,
					  disable_properties:true
					});


				} catch (error) {
					console.error(error)
				}



			}

			async function postForm(data){

				const rawResponse = await fetch('/json-forms/create', {
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
						},
					body: data
				});
				const content = await rawResponse.json();

				console.log(content);
			}

			createForm()

		}

		init()


		// override class method
		// JSONEditor.defaults.editors.integer.prototype.sanitize = function(value) {
		// 	console.log(value)
		//   return value
		// };



	</script>

</body>

</html>
