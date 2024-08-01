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