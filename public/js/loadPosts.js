const idButtonLoadMore = 'loadMore';

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();

		// Esto hace que se recargue automaticamente al llegar al final de la pagina
		// window.addEventListener("scroll", function() {
		// 	if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight) {
		// 		loadPost();
		// 	}
		// });		

		document.getElementById(idButtonLoadMore).addEventListener('click', function() {
			loadPost();
		});
	}
});

var isLoading = false;

function loadPost() {
	if (isLoading) {
		console.log('Posts are already loading');
		return;
	}
	isLoading = true;

	const ajaxRoute = document.getElementById("ajaxRoute").value;

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			const divLoadMore = document.getElementById("loadedPosts");
			const posts = JSON.parse(this.responseText);
			// console.log(posts);

			for (let i = 0; i < posts.length; i++) {
				const post = posts[i];
			
				const postDiv = document.createElement('div');
				postDiv.className = 'post';

					// post user
					const postUserLink = document.createElement('a');
					postUserLink.href = '/profile/' + post.PosterUser.userName;
					postUserLink.className = 'postUser';

						const postUserImg = document.createElement('img');
						postUserImg.src = "/userData/" + post.PosterUser.idUser + "/profilePicture.png";
						postUserImg.alt = 'user image';
						postUserLink.appendChild(postUserImg);

						const postUser = document.createElement('span');
						postUser.textContent = post.PosterUser.userName;
						postUserLink.appendChild(postUser);

						
						const commentDate = document.createElement('span');
						commentDate.textContent = post["postingTime"];
						postUserLink.appendChild(commentDate);

					postDiv.appendChild(postUserLink);
				
					// post photo
					const postImgLink = document.createElement('a');
					postImgLink.href = '/feed/' + post.idPost;
					postImgLink.className = 'postImg';
						const postImg = document.createElement('img');
						postImg.src = post.contentRoute;
						postImg.alt = 'post image';
						postImgLink.appendChild(postImg);
					postDiv.appendChild(postImgLink);

					// post stats
					const postStats = document.createElement('div');
					postStats.className = 'postStats';

						const spanLikes = document.createElement('span');
						spanLikes.className = 'likes';
						spanLikes.textContent = post.likes + ' likes';
						postStats.appendChild(spanLikes);

						const spanDislikes = document.createElement('span');
						spanDislikes.className = 'dislikes';
						spanDislikes.textContent = post.dislikes + ' dislikes';
						postStats.appendChild(spanDislikes);

						const spanComments = document.createElement('span');
						spanComments.className = 'comments';
						spanComments.textContent = post.commentAmount + ' comments';
						postStats.appendChild(spanComments);

					postDiv.appendChild(postStats);

				// TODO: que se ponga por devajo del boton de cargar mas
				// TODO: mostrar el usuario con un enlace
				divLoadMore.appendChild(postDiv);
			}
			console.log('Posts loaded');
			isLoading = false;
		}
	};
	xhttp.open('GET', ajaxRoute);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
	console.log('Loading posts...');
	
}