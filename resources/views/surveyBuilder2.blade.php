<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Survey builder</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<script src="https://kit.fontawesome.com/1b1ad55713.js" crossorigin="anonymous"></script>

</head>

<body>

	<style>
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,700;0,800;1,400;1,500;1,600;1,700&family=Rubik:wght@300;400;500&display=swap');

		body,
		html {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			min-height: 1000px;
			height: 100%;
			background-color: #fff;
			font-family: sans-serif;
			font-family: 'Open Sans', sans-serif;

		}

		*,
		*:before,
		*:after {
			box-sizing: inherit;
		}

		.wrapper {
			width: 100%;
			min-height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.form-builder-container {
			min-height: 500px;
			width: 700px;
			border: 1px solid grey;
			overflow: auto;
		}

		.form-json {
			/* position: absolute; */
			/* right: 10px;
			top: 50%;
			transform: translateY(-50%);
			*/
			display: flex;
			flex-direction: column-reverse;
			width: 500px;
			height: 500px;
			margin-right: 15px;
			/* overflow-y: auto; */
		}

		.btn-update-schema {
			position: relative;
			bottom: -5px;
			left: 50%;
			transform: translateX(-50%);
			font-size: 18px;
			padding: 4px 8px;
			color: #eeeeee;
			border-radius: 5px;
			background: #47a547;
			cursor: pointer;
			width: fit-content;
		}

		.form-builder-header {
			display: flex;
			justify-content: flex-end;
		}

		.add-form-field {
			padding: 5px 10px;
			border-radius: 5px;
			outline: 1px solid grey;
			cursor: pointer;
			user-select: none;
			color: #6e6e6e;
			font-weight: 700;
			overflow: hidden;
			position: relative;
		}

		/*
		.add-form-field::after{
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: #0094ef70;
			transform: translateX(-100%);
			filter: invert(1);
			transition: all 0.1s linear;
		} */

		.add-form-field:hover {
			background-color: #f8f8f8;
		}

		.add-form-field:hover::after {
			transform: translateX(0)
		}

		.form-builder-container {
			padding: 20px;
		}

		.form-field {
			background-color: #f5f5f5;
			outline: 1px solid #ccc;
			padding: 10px;
			position: relative;
			max-height: 500px;
			overflow: hidden;
			/* clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%); */
			transition: font-size margin opacity padding max-height 0.3s linear;
			padding-top: 30px;
		}

		.form-field.removing {
			font-size: 0;
			margin: 0 !important;
			opacity: 0;
			padding: 0;
			max-height: 0;
			/* fade out, then shrink */
			transition: all 0.2s;
		}

		.form-filed.removing input {
			display: none;
		}

		.form-group {
			margin-top: 10px;

		}

		.form-builder .form-field:not(:first-child) {
			margin-top: 20px;
		}

		.field-label {
			color: #5e5e5e;
			line-height: 1.7rem;
			margin-bottom: 5px;
			-webkit-touch-callout: none;
			/* iOS Safari */
			-webkit-user-select: none;
			/* Safari */
			-khtml-user-select: none;
			/* Konqueror HTML */
			-moz-user-select: none;
			/* Old versions of Firefox */
			-ms-user-select: none;
			/* Internet Explorer/Edge */
			user-select: none;
			/* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */

		}

		.form-control {
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
			transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
		}

		.field-actions {
			position: absolute;
			top: 0;
			/* padding: 5px; */
			right: 0;
			display: flex;
			/* align-items: center; */
			/* width: 60px; */
			justify-content: space-between;
		}

		.field-actions>div {
			padding: 5px;
		}

		.field-actions .remove-input i {
			cursor: pointer;
			/* font-size: 18px; */
			vertical-align: middle;
		}

		.field-actions .edit-input i {
			cursor: pointer;
			font-size: 14.5px;
			vertical-align: middle;
		}

		.field-actions .edit-input i:hover {
			color: #1d9e28;

		}

		.field-actions .remove-input i:hover {
			color: #ff6464;

		}

		.form-field.hidden {
			opacity: 0;
		}
	</style>


	<div class="wrapper">
		<div class="form-json">

			<div class="btn-update-schema">Update</div>
		</div>
		<div class="form-builder-container">
			<div class="form-builder">

				<div class="form-builder-header">
					<div class="add-form-field btn">
						<span>Add +</span>
					</div>
				</div>

				<div class="update-form btn"></div>
			</div>
		</div>
	</div>



	<script type="text/javascript" src="{{asset('assets/js/multiFormSchema.js')}}"></script>



	<script defer>
		class surveyBuilder {

			allFields
			allFieldsDOM = []


			constructor(schema){
				this.formBuilderDOM = document.querySelector('.form-builder')
				this.addFormFieldBtn = document.querySelector('.add-form-field')

				this.addFormFieldBtn.addEventListener('click', this._addNewFeild.bind(this))

				this.allFields = this._sortFields(schema)

				this._createFields()

				this._sortFields(this.allFields)
			}

			_createFields(){
				this.allFields.forEach(field => {
					const id = this._createInputId(10)

					//Create DOM field with unique id to be synced with the allFieldsSchema
					const createdField = this._createField(field, id)

					//update each field prop with the unique id in the input DOM dataset
					field.id = id

					//store all created inputs
					this.allFieldsDOM.push(createdField)

					//add delete option for the field
					this._addDeleteEvent(createdField)

				})
			}

			_sortFields(fields){
				const sortedFields = fields.sort((a,b)=>{
					return   a.fieldOrder - b.fieldOrder
				})

				return sortedFields
			}

			_addNewFeild(e){
				const btnClicked = e.target.closest('.add-form-field')
				if(!btnClicked) return
				const newId = this._createInputId(10)
				const newFieldOrder = this.allFields[this.allFields.length - 1]?.fieldOrder + 1

				const fieldData = {
					title:'nedefinit',
					fieldOrder:newFieldOrder,
					options:[],
					id:newId
				}

				//Add new field to the dom
				const createdNewField = this._createField(fieldData, newId)


				//push new Dom to the dom fields list
				this.allFieldsDOM.push(createdNewField)

				//ad deete option for the new field
				this._addDeleteEvent(createdNewField)

				//add data to the state
				this.allFields.push(fieldData)

			}

			_addDeleteEvent(createdField){
				createdField.querySelector('.remove-input').addEventListener('click', this._deleteField.bind(this))
			}



			_deleteField(e){
				const btnClicked = e.target.closest('.remove-input')
				if(!btnClicked) return
				const id = btnClicked.dataset.inputId

				const formField = document.querySelector(`.form-field[data-input-id="${id}"]`)
				//Add remove input animation
				formField.classList.add('removing')

				//Remove input from DOM
				setTimeout(() => {
					formField.remove()
				}, 250);

				//remove fromAllFields array
				this.allFields.splice((this.allFields.findIndex(field=> field.id === id)),1)


			}

			_createField(field,id){

				const html = `
				<div class="form-field" data-input-id="${id}" draggable="true" >
					<label class="field-label"> ${field.title} </label>
					<div class="field-actions">
						<div class="edit-input" data-input-id="${id}">
							<i class="fas fa-pen"></i>
						</div>
						<div class="remove-input" data-input-id="${id}">
							<i class="far fa-times-circle" aria-hidden="true"></i>
						</div>
					</div>
					<div class="form-group">
						<input type="string" class="form-control">
					</div>
					<div class="edit-field">
						${field.options.map()}
					</div>
				</div>`

				this.formBuilderDOM.insertAdjacentHTML('beforeend',html)

				return document.querySelector(`.form-field[data-input-id="${id}"]`)


			}

			_createInputId(randStringLength){

				if(!randStringLength || randStringLength < 1) return

					const alphabet = [...Array(26).keys()].map(i => String.fromCharCode(i + 97));
					const nrs = [1,2,3,4,5,6,7,8,9]
					const hex = [...alphabet, ...nrs]
					const random = function(){
						return Math.floor(Math.random() * hex.length)
					}
					return [...Array(randStringLength)].map(()=>hex[random()]).join('')

				}

			}


		const sb = new surveyBuilder(jsonSchema.fields)

	</script>

</body>

</html>
