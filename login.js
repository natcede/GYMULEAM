document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const mensajeDiv = document.getElementById("mensaje");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        iniciarSesion();
    });

    function iniciarSesion() {
        const formData = new FormData(loginForm);
        fetch("iniciar_sesion.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                mostrarMensaje(true, data.message);
            } else {
                mostrarMensaje(false, data.message);
            }
        })
        .catch(error => {
            mostrarMensaje(false, "Error de red: " + error.message);
        });
    }

    function mostrarMensaje(esExitoso, mensaje) {
        mensajeDiv.textContent = mensaje;
        mensajeDiv.style.color = esExitoso ? "green" : "red";
    }
});
