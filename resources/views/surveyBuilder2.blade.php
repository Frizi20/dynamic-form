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
			/* height: 100%; */
			background-color: #fff;
			font-family: sans-serif;
			font-family: 'Open Sans', sans-serif;

		}

		body {
			padding: 100px 0;
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
			border: 1px solid #e4e4e4;
			overflow: auto;
			position: relative;
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
			display: none;
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
			position: sticky;
			top: 0;
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
			/* max-height: 600px; */
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

		.form-group select {
			width: 100%;
			padding: 4px;
			font-size: 15px;
			display: block;
			width: 100%;
			padding: 0.175rem 0.75rem;
			font-size: 1rem;
			font-weight: 400;
			line-height: 1.5;
			color: #7b8085;
			background-color: #fff;
			background-clip: padding-box;
			border: 1px solid #ced4da;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			/* border-radius: 0.375rem; */
			transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
		}

		.form-group.hidden {
			display: none;
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
			word-spacing: 1px;
			letter-spacing: 0.5px;
			margin-left: 5px;
			display: block;
			max-height: 300px;
			/* transition: max-height opacity 5s; */


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
			padding: 0 9px;
		}

		.field-actions .remove-input i {
			cursor: pointer;
			font-size: 18px;
			vertical-align: middle;
		}

		.field-actions .edit-input i {
			cursor: pointer;
			font-size: 14px;
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

		/* Edit field options */

		.edit-field {
			display: flex;
			width: 100%;
			/* height: 200px; */
			background-color: #fff;
			display: block;
			position: relative;
			padding: 0;
			opacity: 0;

			/* padding-bottom: 60px; */
			max-height: 0;
			transition: max-height 0.3s, padding-bottom 0.3s, padding-top 0.3s, opacity 0.3s linear;
		}

		.edit-field.active {
			/* display: block; */
			max-height: 500px;
			padding: 20px 20px 60px 20px;
			/* padding-bottom: 60px; */
			opacity: 1;
		}

		.form-group.hidden {
			max-height: 0;
			/* display: none; */
			transition: all 0.3s linear;
		}

		.field-label.hidden {
			display: none;
			/* font-size: 0; */
			/* margin: 0 !important; */
			/* opacity: 0; */
			/* padding: 0; */
			/* max-height: 0; */
			/* fade out, then shrink */
			/* transition: all 0.3s linear; */
		}

		.edit-field-options,
		.edit-field-title {
			display: flex;
			/* padding: 10px; */
		}

		.edit-field-title .description {
			flex: 0 0 100px;
			padding-top: 10px;
		}

		.edit-field-title .title {
			flex: 1;
			padding: 5px;
		}


		.edit-field-title textarea {
			/* min-width: 100%; */
			/* min-height: 100%; */
			min-width: calc(100% - 10px);
			max-width: calc(100% - 10px);
			/* min-height: calc(100% - 10px); */
			/* max-height: 70px; */
			/* min-height: 70px; */
			height: 80px;
			border: 1px solid #c5c5c5;
			font-family: 'Open Sans', sans-serif;
			padding: 10px;
			resize: vertical;
			font-weight: 500;
			color: #737373;
			font-size: 14px;

		}

		.edit-field-options .options {
			width: 100%;
		}

		.edit-field-options .description {
			flex: 0 0 100px;
		}

		.edit-field-options .option {
			flex: 1;
			display: flex;
		}

		.edit-field-options .option:not(:first-child) {
			margin-top: 10px !important;

		}

		.edit-field-options .option>div {
			/* flex: 0 0 50%; */
			padding: 0 5px;
		}

		.edit-field-options input {
			width: 100%;
			padding: 6px 12px;
			border: 1px solid #c5c5c5;
			background-color: #fff;
		}

		.edit-field-options .remove-option {
			flex: 0 0 0;
			display: flex;
			align-items: center;

			justify-content: center;
		}

		.edit-field-options .remove-option:hover {
			cursor: pointer;
			color: red;
		}

		.edit-field-options .label,
		.edit-field-options .value {
			flex: 0 0 49%;
		}

		.edit-field-options .option-actions {
			position: relative;
			text-align: right;
			padding-top: 10px;
		}

		.edit-field-options .option-actions span {
			display: inline-block;
			margin-right: 10px;
			padding: 2px 4px;
			border: 1px solid #009dba;
			border-radius: 5px;
			font-size: 14px;
			color: #009dba;
			font-weight: 500;
			cursor: pointer;
		}

		.close-options {
			position: absolute;
			/* left: 0; */
			/* top: 0; */
			left: 50%;
			bottom: 0;
			transform: translateX(-50%);
			/* border: 1px solid #ff5959; */
			padding: 2px 16px;
			font-size: 15px;
			font-weight: 500;
			color: #737373;
			bottom: 1px;
			border-radius: 3px;
			cursor: pointer;
			border: none;
			bottom: -2px;
			background: whitesmoke;
			bottom: -2px;
			color: #505050;
			opacity: 0;
		}

		.edit-field.active .close-options {
			opacity: 1;
			transition: all 0.2s linear;
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

			draggedField
			fieldIsDragged = false
			pointerX
			pointerY
			fieldX
			fieldY

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

					//add delete option event
					this._addDeleteOptionEvent(createdField)

					//add edit event
					this._addEditEvent(createdField)

					//add the add+ option functionality
					this._addAugmentOpion(createdField)


					//add update description
					this._addUpdateTitleEvent(createdField)

					//add update option value event
					this._addUpdateOptionValue(createdField)


					//add update label event
					this._addUpdateOptionLabel(createdField)

					//add draggable functionality to every field
					this._addDraggingEvents(createdField)

				})
			}

			_addDraggingEvents(fieldDOM){
				fieldDOM.addEventListener('mousedown', this._clickDown.bind(this), true)
				document.addEventListener('mousemove', this._moveEl.bind(this),true)
				document.addEventListener('mouseup', this._clickUp.bind(this), true)
			}

			_clickDown(e){

				const element = e.target
				if(!element.className.includes('form-field')) return

				const {width,height,left,top} = element.getBoundingClientRect()

				this.fieldClone = element.cloneNode(true)
				this.fieldClone.style.filter = 'blur(50px)'

				element.insertAdjacentElement('beforebegin',this.fieldClone)

				Object.assign(element.style, {
					position:'fixed',
					width:`${ width}px`,
					height: `${height}px`,
					left: `${window.scrollX + left}px`,
					top: `${top - 20}px`,
					zIndex:200,
					opacity:0.8
				})

				this.pointerX = e.clientX
				this.pointerY = e.clientY
				this.elInitialX = left
				this.elInitialY = top  - 20

				this.fieldIsDragged = true
				this.draggedField = element


				console.log(top)

			}

			_moveEl(e){
				if(!this.fieldIsDragged) return

				const moveX = (this.pointerX - e.clientX) * -1
				const moveY = (this.pointerY - e.clientY) * -1


				const currX = this.pointerX
				const currY = this.pointerY
				const elementCurrentX = this.elInitialX + moveX
				const elementCurrentY = this.elInitialY + moveY
				const {left:currElX,top:currElY,height:currElHeight,width:currElWidth} = this.draggedField.getBoundingClientRect()

				this.draggedField.style.left = (elementCurrentX) + 'px'
				this.draggedField.style.top = (elementCurrentY) + 'px'
				// this.draggedField.style.position = 'fixed'
				// this.draggedField.style.transform = currY - e.clientY

				// this.draggedField.style.transform = 'translateX(-20px)'
				this.allFieldsDOM.map((draggable,i)=>{
					const {left:draggableX,top:draggableY,height:draggableHeight,width:draggableWidth} = draggable.getBoundingClientRect()

					if(draggable !== this.draggedField){

						if(((currElHeight + currElY - 30)> draggableX) &&
							currElY + 25 < draggableX + draggableHeight){

								draggable.style.opacity = 0.3
								// allDraggables.lastDraggedOverEl = draggable.draggedElement
								// this.lastDragged = draggable.draggedElement
								// draggable.draggedElement.style.opacity = 0.5
								console.log('da')


						}else{
							draggable.style.opacity = 1
						}

					}

				})
			}

			_clickUp(e){
				// if(!e.target.className.includes('form-field')) return
				this.fieldIsDragged = false
				if(!this.draggedField) return
				Object.assign(this.draggedField.style,{
					position:'relative',
					width:'auto',
					height:'auto',
					left:0,
					top:0,
					zIndex:0,
					opacity:1
				})
				this.fieldClone.remove()
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
					title:'(Descriere)',
					fieldOrder:newFieldOrder || 1,
					options:[
						{
							value:'valoare 1',
							label:'raspuns 1'
						},
						{
							value:'valoare 2',
							label:'raspuns 2'
						},
						{
							value:'valoare 2',
							label:'raspuns 3'
						}
					],
					id:newId
				}

				//Add new field to the dom
				const createdNewField = this._createField(fieldData, newId)


				//push new Dom to the dom fields list
				this.allFieldsDOM.push(createdNewField)

				//add deete option for the new field
				this._addDeleteEvent(createdNewField)

				//add delete option event
				this._addDeleteOptionEvent(createdNewField)

				//add edit option
				this._addEditEvent(createdNewField)

				//add data to the state
				this.allFields.push(fieldData)

				//add the add+ option functionality
				this._addAugmentOpion(createdNewField)

				//add update description
				this._addUpdateTitleEvent(createdNewField)

				//add update option value event
				this._addUpdateOptionValue(createdNewField)


				//add update label event
				this._addUpdateOptionLabel(createdNewField)

			}

			_addAugmentOpion(createdField){
				createdField.querySelector('.option-actions span').addEventListener('click',this._addOption.bind(this))

			}

			_addDeleteEvent(createdField){
				createdField.querySelector('.remove-input').addEventListener('click', this._deleteField.bind(this))
			}

			_addUpdateTitleEvent(createdField){
				createdField.querySelector('.edit-field-title .title').addEventListener('change',this._updateTitle.bind(this))
			}
			_addUpdateOptionValue(createdField){
				createdField.querySelectorAll('.option .value input').forEach(optLabel =>{
					optLabel.addEventListener('change',this._updateValue.bind(this))
				})
			}

			_addUpdateOptionLabel(createdField){
				createdField.querySelectorAll('.option .label input').forEach(optLabel =>{
					optLabel.addEventListener('change',this._updateLabel.bind(this))
				})
			}

			_addDeleteOptionEvent(createdField){
				createdField.querySelectorAll('.remove-option').forEach(delOption => {
					delOption.addEventListener('click',this._deleteOption.bind(this))
				});
			}

			_updateTitle(e){
				const descInput = e.target
				const currField = descInput.closest('.form-field')
				const fieldId = currField.dataset.inputId
				const fieldLabelDOM = currField.querySelector('.field-label')
				const currFieldState = this.allFields.find(field => fieldId == field.id)

				// change field state
				currFieldState.title = descInput.value

				//change field description Value
				fieldLabelDOM.textContent = descInput.value

			}

			_updateLabel(e){
				const labelInput = e.target
				const optionId = labelInput.closest('.option').dataset.optionId
				const currField = labelInput.closest('.form-field')
				const formFieldId = currField.dataset.inputId
				const currFieldState = this.allFields.find(field => field.id == formFieldId)
				const currOptionState = currFieldState.options.find(option=> option.id == optionId)

				const optionDOM = currField.querySelector(`.form-group [data-option-id="${optionId}"]`)

				console.log(optionDOM)
				//change the option label from state
				currOptionState.label = labelInput.value

				//change option label DOM
				optionDOM.textContent = labelInput.value

			}

			_updateValue(e){
				const valueInput = e.target

				const optionId = valueInput.closest('.option').dataset.optionId
				const currField = valueInput.closest('.form-field')
				const formFieldId = currField.dataset.inputId
				const currFieldState = this.allFields.find(field => field.id == formFieldId)
				const currOptionState = currFieldState.options.find(option=> option.id == optionId)

				const optionDOM = currField.querySelector(`.form-group [data-option-id="${optionId}"]`)

				console.log(valueInput)
				//change the option label from state
				currOptionState.value = valueInput.value

				//change option label DOM
				console.log(optionDOM)
				optionDOM.value = valueInput.value

			}

			_addOption(e){
				const addOptionBtn =  e.target.closest('.option-actions span')
				if(!addOptionBtn) return
				const fieldID = addOptionBtn.dataset.inputId
				const newOptionId = this._createInputId(10)
				const newOptionData = {
					value:'',
					label:'',
					id:newOptionId
				}


				const optionHTML = `<div class ="option" data-option-id="${newOptionId}">
										<div class="label">
											<input type="text" value="${''}" placeholder="label" >
										</div>
										<div class="value">
											<input type="text" value="${''}" placeholder="value">
										</div>
										<div class="remove-option" data-option-id="${newOptionId}">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>`

				//Add new option to the field schema
				this.allFields.find(field => fieldID == field.id).options.push(newOptionData)

				//Add option to the DOM
				// --- Add DOM option to the edit Modal
				addOptionBtn.parentElement.insertAdjacentHTML('beforebegin', optionHTML)
				// --- Add DOM option to the select input preview
                const currSelect = document.querySelector(`.form-field[data-input-id="${fieldID}"] .form-group select`)
				this._createSelectOption(currSelect,newOptionId)



				//add delete event to remove-option btn
				const removeBtn = document.querySelector(`.remove-option[data-option-id = "${newOptionId}"]`)
				removeBtn.addEventListener('click', this._deleteOption.bind(this))

				//add update value and label events to the new option DOM
				const optionDom = document.querySelector(`.option[data-option-id="${newOptionId}"]`)
				const updateLabelInput = optionDom.querySelector('.label input')
				const updateValueInput = optionDom.querySelector('.value input')

				updateLabelInput.addEventListener('change',this._updateLabel.bind(this))
				updateValueInput.addEventListener('change',this._updateValue.bind(this))
			}

			_createSelectOption(selectEl,newOptionId){
				const optionHTML = `<option value="5" data-option-id="${newOptionId}"> </option>`
				selectEl.insertAdjacentHTML('beforeend',optionHTML)
			}

			_deleteOption(e){
				const optionClicked = e.target.closest('.remove-option')
				if(!optionClicked) return
				const optionId = optionClicked.dataset.optionId
				const formFieldId = optionClicked.closest('.form-field').dataset.inputId

				//remove option from the edit DOM
				const currFieldState = this.allFields.filter(field =>{
					return field.id == formFieldId
				})

				//if there are less than one option stop removing the option
				if(currFieldState[0].options.length <= 2) return

				//remove option from the edit Modal DOM
				optionClicked.parentElement.remove()

				//remove option from the select preview
				document.querySelector(`option[data-option-id="${optionId}"]`).remove()

				//remove option from the field options in the schema
				const option = currFieldState[0].options.splice(currFieldState[0].options.findIndex(option => option.id == optionId),1)



				console.log(option)
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

				//remove from allFieldsDOM
				this.allFieldsDOM.splice(this.allFieldsDOM.findIndex(fieldDOM=> fieldDOM == formField),1)



			}

			_addEditEvent(createdField){

				createdField.querySelector('.edit-input').addEventListener('click', this._showEditModal.bind(this))
				createdField.querySelector('.close-options').addEventListener('click', this._showEditModal.bind(this))


			}

			_showEditModal(e){
				const btnClicked = e.target.closest('.edit-input')
				if(!btnClicked) return
				const id = btnClicked.dataset.inputId

				const formField = document.querySelector(`.form-field[data-input-id="${id}"]`)
				const input = formField.querySelector('.form-group')
				const label = formField.querySelector('.field-label')
				const editField = formField.querySelector('.edit-field')

				// hide input and label and show the edit modal

				input.classList.toggle('hidden')
				label.classList.toggle('hidden')
				editField.classList.toggle('active')


			}

			_createField(field,id){

				let optionsIds = []

				const html = `
				<div class="form-field" data-input-id="${id}"  >
					<label class="field-label"> ${field.title} </label>
					<div class="field-actions">
						<div class="edit-input" data-input-id="${id}">
							<i class="fas fa-pen"></i>
						</div>
						<div class="remove-input" data-input-id="${id}">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
					</div>
					<div class="form-group">
						<select>
							${field.options.map((option,index) =>{
								const optionId = this._createInputId(10)
								optionsIds.push(optionId)
								return `<option value="${option.value}" data-option-id="${optionId}">
											${option.label}
										</option>`
							}).join('')}
						</select>
					</div>
					<div class="edit-field">
						<div class="edit-field-title">
							<div class="description">
								Descriere
							</div>
							<div class="title">
								<textarea spellcheck="false">${field.title}</textarea>

							</div>
						</div>
						<div class="edit-field-options">
							<div class="description">
								Options
							</div>
							<div class="options">

								${field.options.map((option,index,optionsArr ) =>{

									const optionId = optionsIds[index]

									//Set option id to the schema
									optionsArr[index]['id'] = optionId

									return`<div class ="option" data-option-id="${optionId}">

										<div class="label">
											<input type="text" value="${option.label}" placeholder="label">
										</div>
										<div class="value">
											<input type="text" value="${option.value}" placeholder="value" >
										</div>
										<div class="remove-option" data-option-id="${optionId}">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>`
								}).join('')}

								<div class="option-actions">
									<span data-input-id="${id}"> Add Option + </span>
								</div>
							</div>
						</div>
						<div class="close-options">
							Close
						</div>
					</div>
				</div>`

				this.formBuilderDOM.insertAdjacentHTML('beforeend',html)

				return document.querySelector(`.form-field[data-input-id="${id}"]`)


			}

			_createInputId(randStringLength = 10){

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
