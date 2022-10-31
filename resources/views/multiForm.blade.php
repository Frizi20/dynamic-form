<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Multi part form</title>
</head>

<body>


	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: sans-serif;
		}

		body,
		html {
			min-height: 100vh;
			height: 100%;
		}

		.wrapper {
			height: 100%;
			background: rgb(247, 247, 247);
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.multi-form-container {
			/* height: 300px; */
			width: 500px;
			background: white;

		}

		.multi-form-container {
			padding: 20px;
			display: flex;
			flex-direction: column;
			box-shadow: rgb(0 0 0 / 10%) 0px 1px 30px;
		}

		.progress-bar-container {
			/* width: 100%;
			height: 10px;
			background: #9ad2f4;
			margin-top: 10px;
			position: relative;

			color: white;
			text-align: center;
			line-height: 75px;
			font-size: 35px;
			font-family: "Segoe UI";
			animation-direction: reverse; */

			height: 10px;
			/* margin: 50px 0px; */
			background: rgb(255, 255, 255);
			position: relative;
			/* relative here */

			/* background: #e5405e; */
			/* Old browsers */
			/* background: -moz-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
			/* FF3.6-15 */
			/* background: -webkit-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
			/* Chrome10-25,Safari5.1-6 */
			/* background: linear-gradient(to right, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
		}

		.progress-bar-indicator {
			/* position: absolute;	 */
			height: 100%;
			/* width: 100%; */
			/* overflow: hidden; */
			width: 10px;
			-webkit-mask: linear-gradient(#fff 0 0);
			mask: linear-gradient(#fff 0 0);
			border-radius: 5px;
			transition: width 0.2s linear;
		}

		.progress-bar-indicator::before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image: linear-gradient(to right, #166260, #07adce, #3b91ff);
			border-radius: 5px;
		}


		.multi-form-container .slider {
			position: relative;
			min-height: 180px;
			overflow: hidden;

		}

		.multi-form-container fieldset {
			width: 100%;
			flex: 1;
			border: none;
			padding-bottom: 30px;
			position: absolute;
			top: 0;
			left: 0;
			transition: all 0.3s ease-out;
		}

		.fs-title {
			font-size: 17px;
			/* text-transform: uppercase; */
			color: #63a2cb;
			margin-top: 20px;
			text-align: center;
		}

		.fs-input {
			/* margin-top: 50px; */
			margin-top: 20px;
			display: flex;
			align-items: center;
			display: flex;
			flex-direction: column;
		}

		.fs-input select {
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

		.fs-input .error {
			padding: 6px 0;
			width: 100%;
			font-size: 14px;
			color: #ff4949;
			text-align: center;
			display: none;
		}

		.fs-subtitle {
			font-weight: normal;
			font-size: 14px;
			color: #666;
			margin-top: 10px;
			text-align: center;
			font-family: system-ui;
			font-size: 15px;
		}

		.form-buttons {
			display: flex;
			justify-content: space-between;
			/* margin-top: 50px; */
		}

		.form-buttons div {
			cursor: pointer;
			outline: 1px solid #63a2cb;
			padding: 3px 8px;
			user-select: none;
			color: #0070bb;
		}

		.form-buttons .hide{
			display: none;
		}
	</style>


	<div class="wrapper">

		<div class="multi-form-container">
			<div class="progress-bar-container">
				<div class="progress-bar-indicator"></div>
			</div>
			<div class="slider">

				{{-- <fieldset>
					<div class="fs-title">Intrebarea 4</div>
					<div class="fs-subtitle">
						What postgraduate qualifications do you hold?
					</div>

					<div class="input-slider">
						<div class="fs-input">
							<select name="" id="">
								<option value="1">Bucuresti</option>
								<option value="2">Brasov</option>
								<option value="3">Cluj</option>
							</select>
						</div>

					</div>
				</fieldset> --}}

			</div>
			<div class="form-buttons">
				<div class="prev-btn">Previous</div>
				<div class="next-btn">Next</div>
				<div class="send-btn hide">Finish</div>
				{{-- <div class="-btn"></div> --}}
			</div>
		</div>


	</div>


	<script>
		// (function(){
			// document.querySelector('.slider').innerHTML =  document.querySelectorAll('.slider fieldset')[0].outerHTML.repeat(10)
		// })();

		const prevBtn = document.querySelector('.prev-btn');
		const nextBtn = document.querySelector('.next-btn');
		const questions =  document.querySelectorAll('.slider fieldset')
		const slider = document.querySelector('.slider')
		const progressBar = document.querySelector('.progress-bar-indicator')

		let currQuestion = 0
		let questionNr


		const schema = {
			fields:[
				{
					title:'Ai mai furat la locul de munca?',
					fieldOrder:1,
					options: [
						{
							value:2,
							label:'Da'
						},
						{
							value:3,
							label:'Nu'
						},
						{
							value:5,
							label:'Poate'
						}
					]
				},
				{
					title:'Ce faci?',
					fieldOrder:2,
					options: [
						{
							value:2,
							label:'Bine'
						},
						{
							value:3,
							label:'Rau'
						},
						{
							value:5,
							label:'Habar n-am'
						}
					]
				},
				{
					title:'Iti faci treaba?',
					fieldOrder:3,
					options: [
						{
							value:2,
							label:'Bine'
						},
						{
							value:3,
							label:'Rau'
						},
						{
							value:5,
							label:'Habar n-am'
						}
					]
				},
				{
					title:'Iti faci treaba?',
					fieldOrder:4,
					options: [
						{
							value:2,
							label:'Bine'
						},
						{
							value:3,
							label:'Rau'
						},
						{
							value:5,
							label:'Habar n-am'
						}
					]
				},
				{
					title:'Iti faci treaba?',
					fieldOrder:5,
					options: [
						{
							value:2,
							label:'Bine'
						},
						{
							value:3,
							label:'Rau'
						},
						{
							value:5,
							label:'Habar n-am'
						}
					]
				},
			]
		}

		class SurveyBuilder {

			fields
			fieldsLocationDOM
			nrQuestions
			currQuestion = 0
			currSelect
			outputSchema = []
			createdFieldsDOM = []

			constructor(schema, fieldsLocationDOM){
				//create copy of the fields
				this.fields = schema.fields
				this.fieldsLocationDOM = fieldsLocationDOM
				this.createAllFields()
				this.goToQuestion(0)
				this.nrQuestions = document.querySelectorAll('.slider fieldset').length
				this.updateProgressBar()

				this.sendBtnDOM = document.querySelector('.form-buttons .send-btn')
				document.querySelector('.form-buttons').addEventListener('click',(e)=>{
					if(e.target.className.includes('next-btn')) this.nextQuestion(e)
					if(e.target.className.includes('prev-btn')) this.prevQuestion(e)
					if(e.target.className.includes('send-btn')) this.sendSurvey(e)
				})

				console.log(this.fields)
			}

			createAllFields(){
				// console.log(schema.fields)
				this.fields.forEach((field,index)=>{

					//Add unique id to be synced with the schema
					const id = this._createInputId(10)
					//Add field as select dom element
					const createdField = this.createField(field,index, id)
					this.createdFieldsDOM.push(createdField)

					//Add props in outputSchema
					this.outputSchema.push({
						id:id,
						title:field.title,
						options:field.options
					})

					//Add events to each fields that updates the schema
					createdField.addEventListener('change',this.updateSchema.bind(this))
				})


			}

			updateSchema(e){
				const questionId = e.target.dataset.id
				const outputField = this.outputSchema.find(field=> field.id == questionId)
				const selectedValue = e.target.value

				if(!outputField) throw new Error('field not found')

				const valueAllowed = outputField.options.find(el=> el.value == selectedValue)
				if(!valueAllowed) throw new Error('value not allowed')

				outputField.value = selectedValue


			}


			createField(field,questionNr, id){
				const {title,options} = field

				let html = `<fieldset data-id='${id}'>
								<div class="fs-title">Intrebarea ${questionNr + 1}</div>
								<div class="fs-subtitle">
									${title}
								</div>

								<div class="input-slider">
									<div class="fs-input">
										<select name="" id="" data-id='${id}'>
											<option disabled hidden selected>

											</option>
											${options.map((opt,index)=>{
												return `<option value="${opt.value}">${opt.label}</option>`
											})}
										</select>
										<div class="error">
											Raspuns obligatoriu
										</div>
									</div>

								</div>
						</fieldset>`

				this.fieldsLocationDOM.insertAdjacentHTML('beforeend',html)

				// return created dom element
				return document.querySelector(`fieldset[data-id="${id}"]`)
			}



			goToQuestion(questionNr){
				Array.from(document.querySelectorAll('.slider fieldset')).forEach((question, i) => {

					const margin = 0
					const scale = questionNr == i ? 'scale(1)' : 'scale(0.5)'
					const opacity = questionNr == i ? '1'      : '0.2'

					question.style.transform = `translateX(${100 * (i - questionNr) + margin }%) ${scale}`
					question.style.opacity = opacity
				});
			}

			sendSurvey(e){
				console.log(
					this.outputSchema
				)
			}


			nextQuestion(e) {
				const nextBtn = e.target

				//Wait until option is selected
				const currSelect = this.createdFieldsDOM[this.currQuestion].querySelector('select')

				if(!currSelect.value) return

				if(this.currQuestion >= this.nrQuestions -1) return

				//Show SEND button and hide NEXT for the last question
				if(this.currQuestion >= this.nrQuestions -2){
					nextBtn.classList.add('hide')
					this.sendBtnDOM.classList.remove('hide')
				}



				this.currQuestion++

				console.log()

				//move UI to next question
				this.goToQuestion(this.currQuestion)
				this.updateProgressBar()

			}

			prevQuestion(){
				if(this.currQuestion === 0) return
				this.currQuestion--
				//move UI to prev question
				this.goToQuestion(this.currQuestion)
				this.updateProgressBar()

				nextBtn.classList.remove('hide')
				this.sendBtnDOM.classList.add('hide')

			}

			 updateProgressBar(){
				progressBar.style.width =( this.currQuestion + 1) / this.nrQuestions * 100 + '%'
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

		const surveyBuilder = new SurveyBuilder(schema, slider)



		//slider navigation
		// document.querySelector('.form-buttons').addEventListener('click',(e)=>{
		// 	if(e.target.className.includes('next-btn')) nextQuestion()
		// 	if(e.target.className.includes('prev-btn')) prevQuestion()
		// })

		// const goToQuestion = function(questionNr){
		// 	Array.from(document.querySelectorAll('.slider fieldset')).forEach((question, i) => {
		// 		// console.log(`translateX(${100 * (i - questionNr)})`)

		// 		// console.log(progressBar.style.width = '30%')

		// 		const margin = 0
		// 		const scale = questionNr == i ? 'scale(1)' : 'scale(0.5)'

		// 		question.style.transform = `translateX(${100 * (i - questionNr) + margin }%) ${scale}`

		// 		// progressBar.style.width = `${currQuestion / questionNr * 100}%`
		// 	});
		// }

		// function nextQuestion() {
		// 	console.log({
		// 		currQuestion,
		// 		questionNr
		// 	})
		// 	if(currQuestion >= questionNr -1) return
		// 	currQuestion++
		// 	goToQuestion(currQuestion)
		// 	updateProgressBar()
		// }

		// function prevQuestion(){
		// 	if(currQuestion === 0) return
		// 	currQuestion--
		// 	goToQuestion(currQuestion)
		// 	updateProgressBar()
		// }



		// goToQuestion(currQuestion)
		// updateProgressBar(1)


		// function createAllFields(){
		// 	console.log(schema.fields)
		// 	schema.fields.forEach((el,index)=>{
		// 		// console.log(el)
		// 	})
		// }



		// function createField(){

				// <fieldset>

				// 	<div class="fs-title">Intrebarea 4</div>
				// 	<div class="fs-subtitle">
				// 		What postgraduate qualifications do you hold?
				// 	</div>

				// 	<div class="input-slider">
				// 		<div class="fs-input">
				// 			<select name="" id="">
				// 				<option value="1">Bucuresti</option>
				// 				<option value="2">Brasov</option>
				// 				<option value="3">Cluj</option>
				// 			</select>
				// 		</div>

				// 	</div>
				// </fieldset>
		// }


	</script>


</body>

</html>
