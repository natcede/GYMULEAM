<?php
$servername = "212.1.208.199";
$username = "u312507976_db62";
$password = "5Bg1023-2";
$dbname = "u312507976_db62";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    $response['success'] = false;
    $response['message'] = "La conexión falló: " . $conn->connect_error;
    echo json_encode($response);
    exit;
}

// Recuperar datos del formulario y realizar validación
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
$direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
$correo = filter_var(mysqli_real_escape_string($conn, $_POST['correo']), FILTER_VALIDATE_EMAIL);
$contrasena = $_POST['contrasena'];

// Validación de contraseña
if (strlen($contrasena) < 8 || !preg_match('/[A-Z]/', $contrasena)) {
    $response['success'] = false;
    $response['message'] = 'La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula.';
    echo json_encode($response);
    exit;
}

// Verificar si el correo electrónico es válido
if (!$correo) {
    $response['success'] = false;
    $response['message'] = 'Correo electrónico no válido.';
    echo json_encode($response);
    exit;
}

// Utilizamos sentencias preparadas para evitar inyecciones SQL
$sql = "INSERT INTO users (nombre, apellido, direccion, correo, contraseña) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Vinculamos los parámetros
$stmt->bind_param("sssss", $nombre, $apellido, $direccion, $correo, $contrasena);

$response = array();

// Verificamos si la consulta preparada se ejecuta correctamente
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Usuario registrado con éxito.";
} else {
    $response['success'] = false;
    $response['message'] = "Error al registrar el usuario: " . $stmt->error;
}

// Cerramos la consulta preparada y la conexión
$stmt->close();
$conn->close();

// Devolvemos la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
