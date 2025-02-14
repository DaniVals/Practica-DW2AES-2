const idButtonLoadMore = 'loadMore';

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadComments();
	}
});

var isLoading = false;

function loadComments() {
	if (isLoading) {
		console.log('Comments are already loading');
		return;
	}
	isLoading = true;

	const Post = document.getElementsByClassName('post')[0];
	console.log(Post);

	let xhttp = new XMLHttpRequest();
	xhttp.onload = function() {

		const comments = JSON.parse(this.responseText);
		console.log(comments);

		/*
			Profile: {userName: 'monstah', idUser: 4, bio: 'Hola SadowGram', followers: 0, following: 0}
			commComment: nullcontent: "muerte a la grasa\r\n"
			idComment: 2
			dislikes: 9
			likes: 6
			postingTime: {date: '2025-02-11 00:00:00.000000', timezone_type: 3, timezone: 'Europe/Berlin'}
			[[Prototype]]: Object
		*/
		comments.forEach(comment => {

			let commentDiv;
			if (comment["commComment"] == null) {
				commentDiv = document.createElement('div');
			}else{
				commentDiv = document.createElement('li');
			}

			commentDiv.className = 'comment';
				const profile = document.createElement('a');
				profile.className = 'commentUser';
				profile.href = '/profile/' + comment["Profile"]["userName"];
					const profileImg = document.createElement('img');
					profileImg.src = "/userData/" + comment["Profile"]["idUser"] + "/ProfilePicture.png";
					profileImg.alt = "";
					profile.appendChild(profileImg);

					const profileName = document.createElement('span');
					profileName.textContent = comment["Profile"]["userName"];
					profile.appendChild(profileName);

					const commentDate = document.createElement('span');
					commentDate.textContent = comment["postingTime"]["date"];
					profile.appendChild(commentDate);
				commentDiv.appendChild(profile);

				const content = document.createElement('p');
				content.className = 'commentContent';
				content.textContent = comment["content"];
				commentDiv.appendChild(content);

				const commentList = document.createElement('ul');
				commentList.className = 'commentList';
				commentList.id = comment["idComment"];
				commentDiv.appendChild(commentList);

			if (comment["commComment"] == null) {
				Post.appendChild(commentDiv);
			}else{

				const lists = document.getElementsByClassName("commentList");
				console.log(lists);
				for (let i = 0; i < lists.length; i++) {
					const list = lists[i];
					if (list.id == comment["commComment"]["idComment"]) {
						list.appendChild(commentDiv);
					}
				}
			}
		});

		console.log('Comments loaded');
		isLoading = false;
	};
	xhttp.open('POST', '/loadComments');
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	

	xhttp.send("idPost=" + Post.id);
	console.log('Loading comments...');
	
}