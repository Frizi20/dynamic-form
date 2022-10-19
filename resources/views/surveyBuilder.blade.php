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
			min-height: 100vh;
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

				<div class="update-form btn"></div>
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

			console.log(JSON.parse(schemaStruct.schema))
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
			globalSchemaProps = schemaProp

			// Sort the properties by "propertyOrder"

			// const x =Object.fromEntries(Object.entries(globalSchemaProps).sort(([,a],[,b])=>{
			// 	return a.propertyOrder - b.propertyOrder
			// }))

			const arr = [
				['f',1],
				['a',4],
				['c',5],
				['d'],
				['e',0]
			]

			arr.sort((a,b)=>{
				const x = a[1] ?? 0
				const y = b[1] ?? 0

				return y-x
			})

			console.log(arr)

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

			if(callback && typeof(callback) === "function"){
				callback()
			}


		}

		let draggedElement
		let draggableIsClicked = false

		let pointerInitialX
		let pointerInitialY

		let elInitialX
		let elInitialY

		function addEventListeners(){
			const draggables = document.querySelectorAll('.form-field')



			draggables.forEach(draggable =>{

				draggable.addEventListener('click', clickedElement, true)
				draggable.addEventListener('mousemove', move,true)
				draggable.addEventListener('mousedown', clickDown, true)
				draggable.addEventListener('mouseup', clickUp, true)

  				// draggable.addEventListener('dragstart', drag);
  				// draggable.addEventListener('dragstart', dragStart);
  				// draggable.addEventListener('dragenter', dragEnter);
  				// draggable.addEventListener('dragover', dragOver);
  				// draggable.addEventListener('dragleave', dragLeave);
  				// draggable.addEventListener('drop', dragDrop);
  				// draggable.addEventListener('dragend', dragEnd);

			})

		}



		function move(e) {
			if (draggableIsClicked) {
                    draggedElement.style.removeProperty('transform');


                    let moveX = (pointerInitialX - e.pageX) * -1
                    let moveY = (pointerInitialY - e.pageY) * -1
                    const elementCurrentX = elInitialX + moveX
                    const elementCurrentY = elInitialY + moveY

					console.log(elementCurrentX)

                    draggedElement.style.left = (elementCurrentX) + 'px'
                    draggedElement.style.top = (elementCurrentY) + 'px'
                }
		}

		function clickedElement(e){

			// let {
            //         left: elementX,
            //         top: elementY
            //     } = e.target.getBoundingClientRect()

			// elInitialX = elementX + window.scrollX
			// elInitialY = elementY + document.documentElement.scrollTop


			// console.log(elInitialY)
			// console.log(originalRec)
			//hide original field
			// originalFormField.classList.add('hidden')



		}


		function clickDown(e){
			const formField = e.target
			const {width,height,left,top} = formField.getBoundingClientRect()

			console.log(formField.closest('.form-field'))
			// return

			draggedElement = formField
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

			pointerInitialX = e.clientX
			pointerInitialY = e.pageY

			elInitialX = elementX + window.scrollX
			elInitialY = elementY + document.documentElement.scrollTop

			console.log(elInitialX)
			console.log(pointerInitialX)

			draggableIsClicked = true


			formField.style.opacity = 1
			// const clonedFormField = e.target.cloneNode(true)


			// console.log('drag-start', e)
		}

		function clickUp(e){
			// if(!e.target.classList.includes('form-field')) return
			console.log(e.target.className.includes('form-field'))
			Object.assign(draggedElement.style,{
				position:'relative',
				width:'auto',
				height:'auto',
				left:0,
				top:0
			})
			draggableIsClicked = false
			e.target.style.opacity = 1
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



		createSurveyBuilder(function(){
			console.log('it rendered')
		})
		displayFormStructure()


	</script>

</body>

</html>
