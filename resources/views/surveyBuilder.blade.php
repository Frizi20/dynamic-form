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
		body,
		html {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			min-height: 1000px;
			height: 100%;
			background-color: #fff;
			font-family: sans-serif;
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
			padding: 5px;
			right: 0;
		}

		.field-actions .remove-input i {
			cursor: pointer;
			font-size: 18px;
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






	<script defer>
		let formSchemaData
		let globalSchemaProps

		const jsonStructureDom = document.querySelector('.form-json')
		const formBuilderContainer = document.querySelector('.form-builder-container')
		const updateSchemaBtn = document.querySelector('.btn-update-schema')
		const addFormFieldBtn = document.querySelector('.add-form-field')

		const getSchemaInput = function(){
			return jsonStructureDom.querySelector('textarea')
		}

		class allDraggables {

			static draggableElements = []
			static lastDraggedOverEl = ''

			constructor(){
				allDraggables.draggableElements.push(this)
			}

			static getDraggables(){
				return this.draggableElements
			}

		}

		//Draggable element class

		class Draggable extends allDraggables {

			 draggedElement
			 draggableIsClicked = false
			 pointerInitialX
			 pointerInitialY
			 elInitialX
			 elInitialY

			 lastDragged

			constructor(domElement){

				super()

				this.draggedElement = domElement

				//getCurrentCoords
				this.getCurrentCoordonates()
				//add event listeners
				this.addEventListeners()

			}

			addEventListeners(){
				this.draggedElement.addEventListener('mousedown', this.clickDown.bind(this), true)
				document.addEventListener('mousemove', this.move.bind(this),true)
				this.draggedElement.addEventListener('mouseup', this.clickUp.bind(this), true)
			}

			move(e){
				if (this.draggableIsClicked) {
					this.draggedElement.style.removeProperty('transform');

					const moveX = (this.pointerInitialX - e.pageX) * -1
					const moveY = (this.pointerInitialY - e.pageY) * -1
					const elementCurrentX = this.elInitialX + moveX
					const elementCurrentY = this.elInitialY + moveY



					this.draggedElement.style.left = (elementCurrentX) + 'px'
					this.draggedElement.style.top = (elementCurrentY) + 'px'

					this.checkCollision()

				}
			}

			checkCollision(){

				const draggableEls = allDraggables.getDraggables()

				// console.log(draggableEls)

				const draggableElsPos = draggableEls.map(el=>{
					if(el.draggedElement !== this.draggedElement){
						el.getCurrentCoordonates()

					}

					return {
						draggedElement:el.draggedElement,
						x:el.elInitialX,
						y:el.elInitialY,
						width:el.draggedElement.getBoundingClientRect().width,
						height:el.draggedElement.getBoundingClientRect().height
					}
				})

				const currElX = this.draggedElement.getBoundingClientRect().left + window.scrollX
				const currElY = this.draggedElement.getBoundingClientRect().top + window.scrollY
				const currElHeight = this.draggedElement.getBoundingClientRect().height
				const currElWidth = this.draggedElement.getBoundingClientRect().width


				draggableElsPos.forEach((draggable,i) => {
					if(draggable.draggedElement !== this.draggedElement){

						if(((currElHeight + currElY - 30)> draggable.y) &&
							currElY + 25 < draggable.y + draggable.height){

								allDraggables.lastDraggedOverEl = draggable.draggedElement
								this.lastDragged = draggable.draggedElement
								draggable.draggedElement.style.opacity = 0.5


						}else{
							draggable.draggedElement.style.opacity = 1
						}

					}
				});
				// console.log(this.draggedElement.getBoundingClientRect().left + window.scrollX)
				// console.log()
			}


			clickDown(e){
				if(!e.target.className.includes('form-field')) return

				const formField = e.target
				const {width,height,left,top} = formField.getBoundingClientRect()

				this.draggedElement = formField

				Object.assign(formField.style, {
					position:'absolute',
					width:`${ width}px`,
					height: `${height}px`,
					left: `${window.scrollX + left}px`,
					top: `${window.scrollY + top - 20}px`,
					zIndex:200
				})

				let {
						left: elementX,
						top: elementY
					} = e.target.getBoundingClientRect()

				this.pointerInitialX = e.clientX
				this.pointerInitialY = e.pageY

				this.elInitialX = elementX + window.scrollX
				this.elInitialY = elementY + document.documentElement.scrollTop - 20

				console.log(this.elInitialX)
				console.log(this.pointerInitialX)

				this.draggableIsClicked = true


				formField.style.opacity = 0.8
			}

			clickUp(e){
				if(!e.target.className.includes('form-field')) return

				Object.assign(this.draggedElement.style,{
					position:'relative',
					width:'auto',
					height:'auto',
					left:0,
					top:0,
					zIndex:0
				})

				this.draggableIsClicked = false
				e.target.style.opacity = 1

				if(this.lastDragged){
					this.lastDragged.style.opacity = 1
					this.lastDragged = undefined
				}
			}

			getCurrentCoordonates(){

				const {left: elementX,top: elementY} = this.draggedElement.getBoundingClientRect()

				this.elInitialX = elementX + window.scrollX
				this.elInitialY = elementY + window.scrollY

			}

		}






		//Get schema json from database
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

		//Display the json schema from the server
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


		// Add all inputs to the form builder wiht the data from schema
		const createSurveyBuilder = async function(callback){
			//schema data from database
			const schemaStruct = await getFormSchema()
			const schema = schemaStruct.schema

			const formDiv = document.createElement('div')
			formDiv.append(schema)
			// formBuilderContainer.append(formDiv)

			const schemaProp = JSON.parse(schema).properties

			// Sort the properties by "propertyOrder"

			// const x =Object.fromEntries(Object.entries(globalSchemaProps).sort(([,a],[,b])=>{
			// 	return a.propertyOrder - b.propertyOrder
			// }))


			//Sort inputs based on the propertyOrder property
			const sortedProps = Object.fromEntries(Object.entries(schemaProp).sort(([,a],[,b])=>{
				return a.propertyOrder - b.propertyOrder
			}))

			globalSchemaProps = sortedProps


			//Add each input with each property of the schema
			for (const [key, value] of Object.entries(globalSchemaProps)) {

				//id foreach input created so we can change the schema state propreties
				//schema properties in the globalSchemaProps will get an id that it's shared with the inputs created by them

				if(key !== 'submit') {
					value.id = createInputId(10)
					createFormField(value)
				}

			}

			//addEventListeners
			addEventListeners()

			// if(callback && typeof(callback) === "function"){
			// 	callback()
			// }


		}

		function addFormInputs(schemaProp){


			Array.from(document.querySelector('.form-builder').children).forEach(child=>{
				if(child.className.includes('form-field')){
					child.remove()
				}
			})
			// return



			//Sort inputs based on the propertyOrder property
				const sortedProps = Object.fromEntries(Object.entries(schemaProp).sort(([,a],[,b])=>{
				return a.propertyOrder - b.propertyOrder
			}))

			globalSchemaProps = sortedProps


			//Add each input with each property of the schema
			for (const [key, value] of Object.entries(globalSchemaProps)) {

				//id foreach input created so we can change the schema state propreties
				//schema properties in the globalSchemaProps will get an id that it's shared with the inputs created by them

				if(key !== 'submit') {
					value.id = createInputId(10)
					createFormField(value)
				}

			}

			//addEventListeners
			addEventListeners()
		}



		function addEventListeners(){
			const draggables = document.querySelectorAll('.form-field')
			draggables.forEach(draggable =>{
				const draggableInstance = new Draggable(draggable)

			})

		}



		//Create container of the inputs with the field actions
		function createFormField(schemaProp){

			const html = `
				<div class='form-field' data-input-id="${schemaProp.id}" draggable="false">
					<label class="field-label" > ${schemaProp.title} </label>
					<div class="field-actions">
						<span class="remove-input" data-input-id="${'del-'+schemaProp.id}">
							<i class="far fa-times-circle"></i>
						</span>
					</div>
					<div class="form-group">
						${addInput(schemaProp)}
					</div>
				</div>
			`
			//insert the formField to the DOM
			document.querySelector('.form-builder').insertAdjacentHTML('beforeend',html)

			//add listener for the deletion of the field via the ".remove-input" btn
			const removeBtn = document.querySelector(`[data-input-id ='${'del-'+schemaProp.id}']`)
			removeBtn.addEventListener('click', removeFormField)

		}

		//Remove form field and delete data from the objectSchema
		function removeFormField(e){

			const btnClicked = e.target.closest('.remove-input')
			if(!btnClicked) return

			const inputId = btnClicked.dataset.inputId.split('-')[1]

			console.log(globalSchemaProps)
			//remove attribute from globalSchema(schema state)
			for(const key  in globalSchemaProps ){
				const value = globalSchemaProps[key]

				if(value.id === inputId){
					delete globalSchemaProps[key]
				}

			}
			//remove form field
			const formField = document.querySelector(`.form-field[data-input-id="${inputId}"]`)

			//Add remove input animation
			formField.classList.add('removing')

			//Remove input from DOM
			setTimeout(() => {
				formField.remove()
			}, 250);

		}

		// Add input baset on the type
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

				const type = schemaProp.type === 'integer' ? 'number' : schemaProp.type
				const inputHtml = `
					<input  type='${type}' class="form-control">
				`
				return inputHtml
			}

			if(schemaProp.type === 'radio'){


				const x = schemaProp.enum.map((el, index, arr)=>{

					return `
						<label for=""> ${el} </label>
						<input type="radio" name=${el}/>
					`
				})

				// console.log(x)

				const inputHtml = `
					<radio-group>
						${schemaProp.enum}
					<radio-group>
				`


			}

		}


		//Add new fields

		addFormFieldBtn.addEventListener('click', function(e){

			globalSchemaProps['input'] = globalSchemaProps['city']

			addFormInputs(globalSchemaProps)

		})

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


		//Unique id for inputs to be synced with the schema state
		function createInputId(randStringLength){

			if(!randStringLength || randStringLength < 1) return

			const alphabet = [...Array(26).keys()].map(i => String.fromCharCode(i + 97));
			const nrs = [1,2,3,4,5,6,7,8,9]
			const hex = [...alphabet, ...nrs]
			const random = function(){
				return Math.floor(Math.random() * hex.length)
			}
			return [...Array(randStringLength)].map(()=>hex[random()]).join('')

		}



		// createSurveyBuilder(function(){
		// 	console.log('it rendered')
		// })

		createSurveyBuilder()

		displayFormStructure()


	</script>

</body>

</html>
