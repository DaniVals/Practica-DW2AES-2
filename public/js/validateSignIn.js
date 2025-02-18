document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('form').addEventListener('submit', function(event) {
		// Validar el formulario antes de enviarlo
		if (!validateForm()) {
			event.preventDefault();
		}
	});

	function validateForm() {
		// Obtener los valores de los campos
		const user = document.getElementById('user').value.trim();
		const username = document.getElementById('username').value.trim();
		const surname = document.getElementById('surname').value.trim();
		const email = document.getElementById('email').value.trim();
		const bDate = document.getElementById('bDate').value.trim();
		const phone = document.getElementById('phone').value.trim();
		const password = document.getElementById('password').value.trim();
		const password2 = document.getElementById('password2').value.trim();

		// Validar que todos los campos estén completos
		if (user === "" || username === "" || surname === "" || email === "" || bDate === "" || phone === "" || password === "" || password2 === "") {
			alert("Todos los campos son obligatorios.");
			return false;
		}

		// Validar que las contraseñas coincidan
		if (password !== password2) {
			alert("Las contraseñas no coinciden.");
			return false;
		}

		// Validar el formato del correo electrónico
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!emailRegex.test(email)) {
			alert("Por favor, introduce un correo electrónico válido.");
			return false;
		}

		// Validar el formato del número de teléfono (solo números y longitud de 9 dígitos)
		const phoneRegex = /^\d{9}$/;
		if (!phoneRegex.test(phone)) {
			alert("Por favor, introduce un número de teléfono válido (9 dígitos).");
			return false;
		}

		// Validar que la fecha de nacimiento sea válida (el usuario debe ser mayor de 16 años)
		const today = new Date();
		const birthDate = new Date(bDate);
		const age = today.getFullYear() - birthDate.getFullYear();
		const monthDifference = today.getMonth() - birthDate.getMonth();
		if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
			age--;
		}
		if (age < 16) {
			alert("Debes ser mayor de 18 años para registrarte.");
			return false;
		}

		// Si todo está correcto, se envía el formulario
		return true;
	}
});
