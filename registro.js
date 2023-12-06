document.addEventListener("DOMContentLoaded", function() {
    const registroForm = document.getElementById("registroForm");
    const mensajeDiv = document.getElementById("mensaje");

    registroForm.addEventListener("submit", function(event) {
        event.preventDefault();

        // Validación adicional antes de enviar la solicitud al servidor
        if (validarFormulario()) {
            const formData = new FormData(registroForm);

            fetch("registrar_usuario.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de registro exitoso
                    mensajeDiv.textContent = data.message;
                    mensajeDiv.style.color = "#4caf50"; /* Green */
                } else {
                    // Mostrar mensaje de error
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

    function validarFormulario() {
        // Puedes agregar aquí más validaciones según tus requisitos
        const contrasenaInput = document.getElementById("contrasena");
        const contrasena = contrasenaInput.value;

        if (contrasena.length < 8 || !/[A-Z]/.test(contrasena)) {
            mostrarMensajeError("La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula.");
            return false;
        }

        return true;
    }

    function mostrarMensajeError(mensaje) {
        // Muestra mensajes de error en el formulario
        mensajeDiv.textContent = mensaje;
        mensajeDiv.style.color = "#ff6347"; /* Tomato */
    }
});
