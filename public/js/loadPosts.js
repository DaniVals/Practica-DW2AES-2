document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();
	}
});


function loadPost() {

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const posts = JSON.parse(this.responseText);

			for (let i = 0; i < posts.length; i++) {
				const element = array[i];
				
			}


		}
	};
	xhttp.open('GET', '/posts', true);
	xhttp.send();
}