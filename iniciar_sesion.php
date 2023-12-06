<?php
$servername = "212.1.208.199";
$username = "u312507976_db62";
$password = "5Bg1023-2";
$dbname = "u312507976_db62";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Recuperar datos del formulario y realizar validación
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$contrasena = $_POST['contrasena'];

// Validar la dirección de correo electrónico
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $response['success'] = false;
    $response['message'] = "Dirección de correo electrónico no válida.";
    echo json_encode($response);
    exit();
}

// Verificar las credenciales
$sql = "SELECT * FROM users WHERE correo = '$correo'";
$result = $conn->query($sql);

$response = array();

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contrasenaAlmacenada = $row['contraseña'];

        // Verificar la contraseña en texto plano
        if ($contrasena === $contrasenaAlmacenada) {
            // Inicio de sesión exitoso, redirigir al usuario a principal.html
            $response['success'] = true;
            $response['message'] = "Inicio de sesión exitoso.";
            $response['redirect'] = "principal.html";
        } else {
            $response['success'] = false;
            $response['message'] = "Contraseña incorrecta.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Usuario no encontrado.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Error en la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
