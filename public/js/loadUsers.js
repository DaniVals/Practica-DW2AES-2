const idInputText = 'searchUserBar';
var debounceTimeout = null; // Variable para almacenar el timeout

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		
		showUsers();

		document.getElementById(idInputText).addEventListener('keyup', function() {
			clearTimeout(debounceTimeout); // Cancela la ejecución anterior
			debounceTimeout = setTimeout(() => {
				showUsers();
			}, 300); // Espera 300ms antes de ejecutar la función
		});
	}
});

function showUsers() {

	const ajaxRoute = document.getElementById("ajaxRoute").value;

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			const divLoadMore = document.getElementById("loadedUsers");
			divLoadMore.innerHTML = '';
			const users = JSON.parse(this.responseText);

			for (let i = 0; i < users.length; i++) {
				const user = users[i];

				let userDiv = document.createElement('div');
				userDiv.className = 'user';
			
					// post user
					const userLink = document.createElement('a');
					userLink.href = '/profile/' + user["userName"];

						const userImg = document.createElement('img');
						userImg.src = "/userData/" + user["idUser"] + "/profilePicture.png";
						userImg.alt = 'user image';
						userLink.appendChild(userImg);

						const postUser = document.createElement('span');
						postUser.textContent = user["userName"];
						userLink.appendChild(postUser);

					userDiv.appendChild(userLink);

				divLoadMore.appendChild(userDiv);
			}
			console.log('Users loaded');
		}
	};
	xhttp.open('GET', ajaxRoute + "?search=" + document.getElementById(idInputText).value, true);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
	console.log('Loading users...');	
}