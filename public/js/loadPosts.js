const idButtonLoadMore = 'loadMore';

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();

		window.addEventListener("scroll", function() {
			if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight) {
				loadPost();
			}
		});		

		document.getElementById(idButtonLoadMore).addEventListener('click', function() {
			loadPost();
		});
	}
});

var isLoading = false;

function loadPost() {
	if (isLoading) {
		console.log('Posts are loading...');
		return;
	}
	isLoading = true;

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			const posts = JSON.parse(this.responseText);
			console.log(posts);

			for (let i = 0; i < posts.length; i++) {
				const post = posts[i];
			
				let postDiv = document.createElement('div');
				postDiv.className = 'post';

					// post user
					let postUserLink = document.createElement('a');
					postUserLink.href = '/profile/' + post.PosterUser.userName;
					postUserLink.className = 'postUser';

						let postUserImg = document.createElement('img');
						postUserImg.src = "userData/" + post.PosterUser.idUser + "/profilePicture.png";
						postUserImg.alt = 'user image';
						postUserLink.appendChild(postUserImg);

						let postUser = document.createElement('span');
						postUser.textContent = post.PosterUser.userName;
						postUserLink.appendChild(postUser);

					postDiv.appendChild(postUserLink);
				
					// post photo
					let postImgLink = document.createElement('a');
					postImgLink.href = '/feed/' + post.idPost;
					postImgLink.className = 'postImg';
						let postImg = document.createElement('img');
						postImg.src = post.contentRoute;
						postImg.alt = 'post image';
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
			console.log('Posts loaded');
			isLoading = false;
		}
	};
	xhttp.open('GET', '/loadPost');
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
	console.log('Loading posts...');
	
}