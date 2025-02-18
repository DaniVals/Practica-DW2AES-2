document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		
		const usersDivs = document.getElementsByClassName("user");

		for (let i = 0; i < usersDivs.length; i++) {
			usersDivs[i].draggable = true;
			usersDivs[i].addEventListener("dragstart", dragUser);
		}

		document.getElementById("drop_to_edit").addEventListener("dragover", allowDrop);
		document.getElementById("drop_to_delete").addEventListener("dragover", allowDrop);
		document.getElementById("drop_to_edit").addEventListener("drop", dropEdit);
		document.getElementById("drop_to_delete").addEventListener("drop", dropDelete);
	}
});

function dragUser(ev) {
	ev.dataTransfer.setData("userId", ev.target.id);
}
function allowDrop(ev) {
	ev.preventDefault();
}

function dropEdit(ev) {
	ev.preventDefault();

	const data = ev.dataTransfer.getData("userId");
	const route = document.getElementById("drop_to_edit_route").value.slice(0, -1);
	window.location.href = route + data;
}
function dropDelete(ev) {
	ev.preventDefault();

	const data = ev.dataTransfer.getData("userId");
	const route = document.getElementById("drop_to_delete_route").value.slice(0, -1);
	window.location.href = route + data;
}