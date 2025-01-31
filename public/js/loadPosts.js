document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();
	}
});


function loadPost() {

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const json = JSON.parse(this.responseText);

			


		}
	};
	xhttp.open('GET', '/posts', true);
	xhttp.send();
}