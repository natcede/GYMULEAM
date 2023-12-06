document.addEventListener("DOMContentLoaded", function() {
    const recuperarForm = document.getElementById("recuperarForm");
    const mensajeDiv = document.getElementById("mensaje");

    recuperarForm.addEventListener("submit", function(event) {
        event.preventDefault();
        enviarFormulario(recuperarForm);
    });

    function enviarFormulario(formulario) {
        const formData = new FormData(formulario);

        fetch("recuperar_contrasena.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mensajeDiv.textContent = "Contraseña Actual: " + data.currentPassword;
                mensajeDiv.style.color = "#4caf50"; /* Green */
            } else {
                mensajeDiv.textContent = data.message;
                mensajeDiv.style.color = "#ff6347"; /* Tomato */
            }
        })
        .catch(error => {
            console.error("Error de red:", error);
            mensajeDiv.textContent = "Error de red: " + error.message;
            mensajeDiv.style.color = "#ff6347"; /* Tomato */
        });
    }
});
