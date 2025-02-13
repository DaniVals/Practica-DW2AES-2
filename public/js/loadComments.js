const idButtonLoadMore = 'loadMore';

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		loadComments();
	}
});

var isLoading = false;

function loadComments() {
	if (isLoading) {
		console.log('Comments are loading...');
		return;
	}
	isLoading = true;

	let xhttp = new XMLHttpRequest();
	xhttp.onload = function() {

		console.log('Comments loaded');
		isLoading = false;
	};
	xhttp.open('POST', '/loadComments');
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	
	const idPost = document.getElementsByClassName('post')[0].id;
	console.log(idPost);

	xhttp.send("idPost=" + idPost);
	console.log('Loading comments...');
	
}