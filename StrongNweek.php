<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style\assets.css">
	<link rel="stylesheet" href="style\assets2.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Trirong|Sen">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
		integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
		integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
		integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
		crossorigin="anonymous"></script>
	<title>Navigation Bar with Dropdown Menu</title>

	<style>
		a {
			display: inline-block;
			font-family: 'Fira Code', monospace;
			color: #ffffff;
			font-weight: lighter;
			font-size: xx-small;
			width: 210px;
			padding-left: 8px;
			padding-top: 8px;
			text-align: left;
			text-decoration: none;
			border-radius: 30px;
			transition: background-color 0.3s ease;
			background-color: #00235a;
		}
		.dropdown-content a:hover {
			color: #14f595;
		}
	</style>
</head>
<body>
	<?php
	include ('header.php');
	?>

	<div class="search-bar">
		<form action="#" method="GET">
			<input type="text" name="search" placeholder="Search...">
			<button type="submit">Go</button>
		</form>
	</div>

	
			<div class="carousel">
				<h2 style="text-align: center; margin-top: 30px;">Babar Analysis</h2>
				<div class="slider">
					<div class="slide">
						<img src="images\graph1.png" alt="Slider Image 1">
						<div class="caption">Caption for Image 1</div>
					</div>
					<div class="slide">
						<img src="images\three.jpeg" alt="Slider Image 2">
						<div class="caption">Caption for Image 1</div>
					</div>
					<div class="slide">
						<img src="images\fourth.jpeg" alt="Slider Image 3">
						<div class="caption">Caption for Image 1</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-6">
							<button onclick="showPrev()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<div class="textC">Prev</div>
							</button>
						</div>
						<div class="col-6">
							<button onclick="showNext()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<div class="textC">Next</div>
							</button>
						</div>
		
					</div>
				</div>
			</div>

	<script>
		const slides = document.querySelectorAll('.slide');
		let currentSlide = 0;

		function showSlide() {
			slides.forEach(slide => {
				slide.style.display = 'none';
				slide.classList.remove('slide-prev');
			});
			slides[currentSlide].style.display = 'block';
		}

		function showNext() {
			currentSlide = (currentSlide + 1) % slides.length;
			showSlide();
		}

		// Hide all slides except the first one initially
		showSlide();

		function showPrev() {
			slides[currentSlide].classList.add('slide-prev');
			currentSlide = (currentSlide - 1 + slides.length) % slides.length;
			showSlide();
		}
	</script>

	<script>
		document.querySelector('form').addEventListener('submit', function(e) {
		  e.preventDefault();
		  const searchValue = document.querySelector('input[name="search"]').value;
		  if (searchValue.toLowerCase() === 'babar azam') {
			document.querySelector('.carousel').style.display = 'block';
			// Initialize the carousel slider here if needed
		  } else {
			const errorMessage = document.createElement('div');
			errorMessage.innerText = 'Oops! No player of that name';
			document.body.appendChild(errorMessage);
		  }
		});
	  </script>

<?php
include ('footer.php');
?>

</body>

</html>