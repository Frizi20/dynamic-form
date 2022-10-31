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
  			position:relative; /* relative here */

			/* background: #e5405e; */
			/* Old browsers */
			/* background: -moz-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
			/* FF3.6-15 */
			/* background: -webkit-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
			/* Chrome10-25,Safari5.1-6 */
			/* background: linear-gradient(to right, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%); */
		}

		.progress-bar-indicator{
			/* position: absolute;	 */
			height: 100%;
			/* width: 100%; */
			/* overflow: hidden; */
			width: 10px;
			-webkit-mask:linear-gradient(#fff 0 0);
          	mask:linear-gradient(#fff 0 0);
			border-radius: 5px;
			transition:width 0.2s linear ;
		}

		.progress-bar-indicator::before {
			content:"";
  			position:absolute;
  			top:0;
  			left:0;
  			right:0;
  			bottom:0;
  			background-image: linear-gradient(to right, #166260, #07adce, #3b91ff);
			border-radius: 5px;
		}
		

		.multi-form-container .slider{
			position: relative;
			min-height: 150px;
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
			transition: all 0~.5s ease-out;
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
	</style>


	<div class="wrapper">

		<div class="multi-form-container">
			<div class="progress-bar-container">
				<div class="progress-bar-indicator"></div>
			</div>
			<div class="slider">
				<fieldset>

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
				</fieldset>
				<fieldset>

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
				</fieldset>
			</div>
			<div class="form-buttons">
				<div class="prev-btn">Previous</div>
				<div class="next-btn">Next</div>
				{{-- <div class="-btn"></div> --}}
			</div>
		</div>


	</div>


	<script>

		// (function(){
			document.querySelector('.slider').innerHTML =  document.querySelectorAll('.slider fieldset')[0].outerHTML.repeat(10)
		// })();

		const prevBtn = document.querySelector('.prev-btn');
		const nextBtn = document.querySelector('.next-btn');
		const questions =  document.querySelectorAll('.slider fieldset')
		const slider = document.querySelector('.slider')
		const progressBar = document.querySelector('.progress-bar-indicator')

		let currQuestion = 0
		let questionNr = questions.length;


		console.log(questions)

		nextBtn.addEventListener('click',(e)=>{
			console.log(e)
		})

		document.querySelector('.form-buttons').addEventListener('click',(e)=>{
			if(e.target.className.includes('next-btn')) nextQuestion()
			if(e.target.className.includes('prev-btn')) prevQuestion()
		})

		const goToQuestion = function(questionNr){
			Array.from(questions).forEach((question, i) => {
				// console.log(`translateX(${100 * (i - questionNr)})`)
				
				// console.log(progressBar.style.width = '30%')
				
				const margin = 0
				const scale = questionNr == i ? 'scale(1)' : 'scale(0.5)'
				
				question.style.transform = `translateX(${100 * (i - questionNr) + margin }%) ${scale}`

				// progressBar.style.width = `${currQuestion / questionNr * 100}%`
			});
		}

		function nextQuestion() {
			if(currQuestion >= questionNr -1) return
			currQuestion++
			goToQuestion(currQuestion)
			updateProgressBar()
		}

		function prevQuestion(){
			if(currQuestion === 0) return
			currQuestion--
			goToQuestion(currQuestion)
			updateProgressBar()
		}

		function updateProgressBar(){
			progressBar.style.width =( currQuestion + 1) / questionNr * 100 + '%'
		}

		goToQuestion(currQuestion)
		updateProgressBar(1)




		function createField(){
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
		}
		

	</script>


</body>

</html>
