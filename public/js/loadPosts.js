const idButtonLoadMore = 'loadMore';
const reactPostRoute = '/reactPost/'

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadPost();

		// Esto hace que se recargue automaticamente al llegar al final de la pagina
		// window.addEventListener("scroll", function() {
		// 	if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight) {
		// 		loadPost();
		// 	}
		// });		

		// document.getElementById(idButtonLoadMore).addEventListener('click', function() {
		// 	loadPost();
		// });
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
			console.log(posts);

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
						spanLikes.textContent = post.likes;

							// button to give a like
							const likeButton = document.createElement('button');

							// change based on localStorage
							if (localStorage.getItem('likedPost_' + post.idPost) === 'true') {
								likeButton.className = 'likeGivenButton';
							} else {
								likeButton.className = 'likeButton';
							}

							likeButton.addEventListener('click', function() {
								if (localStorage.getItem('likedPost_' + post.idPost) === 'true') {
									unlikePost(post["idPost"], spanLikes);
								} else {
									likePost(post["idPost"], spanLikes);
								}
							});
							spanLikes.appendChild(likeButton);

						postStats.appendChild(spanLikes);

						const spanDislikes = document.createElement('span');
						spanDislikes.className = 'dislikes';
						spanDislikes.textContent = post.dislikes;

							// button to give a like
							const dislikeButton = document.createElement('button');

							// change based on localStorage
							if (localStorage.getItem('dislikedPost_' + post.idPost) === 'true') {
								dislikeButton.className = 'dislikeGivenButton';
							} else {
								dislikeButton.className = 'dislikeButton';
							}

							dislikeButton.addEventListener('click', function() {
								if (localStorage.getItem('dislikedPost_' + post.idPost) === 'true') {
									undislikePost(post["idPost"], spanDislikes);
								} else {
									dislikePost(post["idPost"], spanDislikes);
								}
							});
							spanDislikes.appendChild(dislikeButton);

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

function likePost(postId, span) {
	let comment = { AAA: "dando like a post", postId: postId, span: span };
	console.log(comment);
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const response = JSON.parse(this.responseText);
			span.textContent = response["newLikes"];

			
			let likeButton = document.createElement('button');
			likeButton.className = 'likeGivenButton';
			span.appendChild(likeButton);

			likeButton.removeEventListener('click', arguments.callee);
			likeButton.addEventListener('click', function() {
				unlikePost(postId, span);
			});

			localStorage.setItem('likedPost_' + postId, true);
		}
	};
	xhttp.open('GET', reactPostRoute + '0/' + postId);
	xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
}
// ==============================
function unlikePost(postId, span) {
	let comment = { AAA: "quitando like a post", postId: postId, span: span };
	console.log(comment);

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const response = JSON.parse(this.responseText);
			span.textContent = response["newLikes"];
			
			let likeButton = document.createElement('button');
			likeButton.className = 'likeButton';
			span.appendChild(likeButton);

			likeButton.removeEventListener('click', arguments.callee);
			likeButton.addEventListener('click', function() {
				likePost(postId, span);
			});

			localStorage.setItem('likedPost_' + postId, false);
		}
	};
	xhttp.open('GET', reactPostRoute + '2/' + postId);
	xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
}
function dislikePost(postId, span) {
	let comment = { AAA: "dando dislike a post", postId: postId, span: span };
	console.log(comment);
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const response = JSON.parse(this.responseText);
			span.textContent = response["newDislikes"];

			
			let dislikeButton = document.createElement('button');
			dislikeButton.className = 'dislikeGivenButton';
			span.appendChild(dislikeButton);

			dislikeButton.removeEventListener('click', arguments.callee);
			dislikeButton.addEventListener('click', function() {
				undislikePost(postId, span);
			});

			localStorage.setItem('dislikedPost_' + postId, true);
		}
	};
	xhttp.open('GET', reactPostRoute + '1/' + postId);
	xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
}

function undislikePost(postId, span) {
	let comment = { AAA: "quitando dislike a post", postId: postId, span: span };
	console.log(comment);

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const response = JSON.parse(this.responseText);
			span.textContent = response["newDislikes"];
			
			let dislikeButton = document.createElement('button');
			dislikeButton.className = 'dislikeButton';
			span.appendChild(dislikeButton);

			dislikeButton.removeEventListener('click', arguments.callee);
			dislikeButton.addEventListener('click', function() {
				dislikePost(postId, span);
			});

			localStorage.setItem('dislikedPost_' + postId, false);
		}
	};
	xhttp.open('GET', reactPostRoute + '3/' + postId);
	xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.send();
}