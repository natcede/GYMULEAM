<?php
$servername = "212.1.208.199";
$username = "u312507976_db62";
$password = "5Bg1023-2";
$dbname = "u312507976_db62";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$mensaje = ''; // Inicializamos la variable $mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['recuperar'])) {
        $correo = filter_var(mysqli_real_escape_string($conn, $_POST['correo']), FILTER_VALIDATE_EMAIL);

        if (!$correo) {
            $mensaje = 'Correo electrónico no válido.';
        } else {
            $sql = "SELECT contraseña FROM users WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $stmt->bind_result($hash);
            $stmt->fetch();
            $stmt->close();

            if ($hash) {
                // Puedes verificar aquí si la contraseña es un hash y aplicar la lógica necesaria
                // Por ejemplo, si estás usando password_hash y password_verify en PHP.
                // Aquí asumo que se almacena el hash directamente, ajusta según tu implementación.

                $mensaje = "Contraseña actual: $hash";
            } else {
                $mensaje = "No se encontró ninguna cuenta asociada a este correo electrónico.";
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4A90E2, #8B008B);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 10px;
            font-size: 16px;
            color: #333;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        input {
            margin-bottom: 15px;
            padding: 12px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: linear-gradient(to right, #4A90E2, #8B008B);
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, #8B008B, #4A90E2);
        }

        #mensaje {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #ff6347; /* Tomato */
        }

        label:hover {
            color: #8B008B; /* DarkMagenta */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperación de Contraseña</h2>
        
        <!-- Formulario de Recuperación -->
        <form id="recuperarForm" method="POST" action="recuperar_contrasena.php">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required>
            <input type="submit" name="recuperar" value="Recuperar Contraseña">
            <p>¿Recuerdas tu contraseña? <a href="login.html">Inicia Sesión</a></p>

        </form>

        <div id="mensaje">
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>

