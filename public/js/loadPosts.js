const idButtonLoadMore = 'loadMore';

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();

		document.getElementById(idButtonLoadMore).addEventListener('click', function() {
			loadPost();
		});
	}
});


function loadPost() {

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const posts = JSON.parse(this.responseText);
			// console.log(posts);

			for (let i = 0; i < posts.length; i++) {
				const post = posts[i];
			
				let postDiv = document.createElement('div');
				postDiv.className = 'post';

					// post user
					let postUser = document.createElement('h3');
					postUser.className = 'postUser';
					postUser.textContent = post.PosterUser.userName;
					postDiv.appendChild(postUser);
				
					// post photo
					let postImgLink = document.createElement('a');
					postImgLink.href = '/feed/' + post.idPost;
						let postImg = document.createElement('img');
						postImg.src = post.contentRoute;
						postImg.alt = 'post image';
						postImg.className = 'postImg';
						postImgLink.appendChild(postImg);
					postDiv.appendChild(postImgLink);

					// post stats
					let postStats = document.createElement('div');
					postStats.className = 'postStats';

						let spanLikes = document.createElement('span');
						spanLikes.className = 'likes';
						spanLikes.textContent = post.likes + ' likes';
						postStats.appendChild(spanLikes);

						let spanDislikes = document.createElement('span');
						spanDislikes.className = 'dislikes';
						spanDislikes.textContent = post.dislikes + ' dislikes';
						postStats.appendChild(spanDislikes);

						let spanComments = document.createElement('span');
						spanComments.className = 'comments';
						spanComments.textContent = post.commentAmount + ' comments';
						postStats.appendChild(spanComments);

					postDiv.appendChild(postStats);

				// TODO: que se ponga por devajo del boton de cargar mas
				// TODO: mostrar el usuario con un enlace
				document.body.appendChild(postDiv);
			}
		}
	};
	xhttp.open('GET', '/posts', true);
	xhttp.send();
}