<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Survey builder</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>

	<style>
		body,
		html {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			min-height: 100vh;
			height: 100%;
			background-color: #fff;
			font-family: sans-serif;
		}

		*, *:before, *:after {
  			box-sizing: inherit;
		}

		.wrapper {
			width: 100%;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.form-builder-container {
			height: 500px;
			width: 700px;
			border: 1px solid grey;
			overflow: auto;
		}

		.form-json {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			height: 500px;
			width: 500px;
			/* overflow-y: auto; */
		}

		.btn-update-schema {
			position: absolute;
			bottom: -40px;
			left: 50%;
			transform: translateX(-50%);
			font-size: 18px;
			padding: 4px 8px;
			color: #eeeeee;
			border-radius: 5px;
			background: #47a547;
			cursor: pointer;
		}

		.form-builder-container{
			padding: 20px;
		}

		.form-field{
			border: 1px solid #ccc;
			padding: 10px;
		}

		.form-group{
			margin-top: 10px;

		}

		.form-builder .form-field:not(:first-child){
			margin-top: 20px;
		}

		.field-label{
			color: #5e5e5e;
			margin-bottom: 5px;
		}

		.form-control{
			display: block;
    		width: 100%;
    		padding: 0.375rem 0.75rem;
    		font-size: 1rem;
    		font-weight: 400;
    		line-height: 1.5;
    		color: #212529;
    		background-color: #fff;
    		background-clip: padding-box;
    		border: 1px solid #ced4da;
    		-webkit-appearance: none;
    		-moz-appearance: none;
    		appearance: none;
    		border-radius: 0.375rem;
    		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		}



	</style>


	<div class="wrapper">
		<div class="form-json">

			<div class="btn-update-schema">Update</div>
		</div>
		<div class="form-builder-container">
			<div class="form-builder">

			</div>
		</div>
	</div>






	<script defer>

	// form-builder
	// 		form-field
	// 			form-group

		let formSchemaData
		let globalSchemaProps

		const jsonStructureDom = document.querySelector('.form-json')
		const formBuilderContainer = document.querySelector('.form-builder-container')
		const updateSchemaBtn = document.querySelector('.btn-update-schema')
		const getSchemaInput = function(){
			return jsonStructureDom.querySelector('textarea')
		}

		const getFormSchema = async function(){

			try {
				const res = await fetch('/get-form-schema')
				if(!res?.ok) throw new Error('Could not get form schema')
				const formSchema  = await res.json()

				return formSchema
				} catch (error) {
				console.log(error)
			}
		}

		const displayFormStructure = async function(){
			const schemaStruct = await getFormSchema()
			const schema = schemaStruct.schema
			formSchemaData = schemaStruct

			const formDiv = document.createElement('textarea')
			Object.assign(formDiv.style,{
				width:'100%',
				height:'100%'
			})
			formDiv.append(schema)
			jsonStructureDom.append(formDiv)

		}

		const createSurveyBuilder = async function(callback){
			const schemaStruct = await getFormSchema()
			const schema = schemaStruct.schema

			const formDiv = document.createElement('div')
			formDiv.append(schema)
			// formBuilderContainer.append(formDiv)

			const schemaProp = JSON.parse(schema).properties
			globalSchemaProps = schemaProp

			for (const [key, value] of Object.entries(schemaProp)) {

				createFormField(value)

			}

			if(callback && typeof(callback) === "function"){
				callback()
			}


		}




		function createFormField(schemaProp){


			const html = `
				<div class='form-field'>
					<label class="field-label"> ${schemaProp.title} </label>
					<div class="form-group">
						${addInput(schemaProp)}
					</div>
				</div>
			`

			document.querySelector('.form-builder').insertAdjacentHTML('beforeend',html)
		}

		function addInput(schemaProp){
			if(schemaProp.type === 'select'){

				const selectHtml = `
					<select class="form-control">
						${schemaProp.enum.reduce((acc,curr,index)=>{
							return acc +
								`<option value=${curr}>
									${schemaProp.options.enum_titles[index - 1] ?? curr}
								</option>`
						})}
					<select>
				`

				return selectHtml

			}

			if(schemaProp.type === 'string' || schemaProp.type === 'integer'){

				const inputHtml = `
					<input  type='${schemaProp.type}' class="form-control">
				`

				return inputHtml
			}

		}


		//Update json schema

		updateSchemaBtn.addEventListener('click', updateSchema)

		async function updateSchema(e){

			const schemaData = getSchemaInput().value
			const formId = formSchemaData.id

			try {
				const res = await fetch('/update-schema', {
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
					},
					body: JSON.stringify({
						id:formId,
						schemaData
					}) ,
				})

				const data = await res.json()
				console.log(data)


			} catch (error) {
				console.log(error)
			}

		}


		createSurveyBuilder(function(){
			console.log('it rendered')
		})
		displayFormStructure()


	</script>

</body>

</html>
