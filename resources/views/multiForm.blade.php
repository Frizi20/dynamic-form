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

		.progress {
			width: 100%;
			height: 10px;
			background: #9ad2f4;
			margin-top: 10px;


			color: white;
			text-align: center;
			line-height: 75px;
			font-size: 35px;
			font-family: "Segoe UI";
			animation-direction: reverse;
			background: #e5405e;
			/* Old browsers */
			background: -moz-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%);
			/* FF3.6-15 */
			background: -webkit-linear-gradient(left, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%);
			/* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to right, #e5405e 0%, #ffdb3a 25%, #3fffa2 50%, #3fffa2 50%, #1a9be0 73%, #ba68ed 100%);
		}

		.multi-form-container fieldset {
			flex: 1;
			border: none;
			padding-bottom: 30px;

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
			<div class="progress">

			</div>

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

			<div class="form-buttons">
				<div class="prev-btn">Previous</div>
				<div class="next-btn">Next</div>
				{{-- <div class="-btn"></div> --}}
			</div>
		</div>


	</div>


	<script>
		const prevBtn = document.querySelector('.prev-btn');
		const nextBtn = document.querySelector('.next-btn');


		nextBtn.addEventListener('click',(e)=>{
			console.log(e)
		})


	</script>


</body>

</html>
