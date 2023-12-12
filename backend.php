<?php
    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myweb";
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar datos del formulario
        $nombre = htmlspecialchars($_POST["nombre"]);
        $email = htmlspecialchars($_POST["email"]);
        $contrasena = htmlspecialchars($_POST["contrasena"]);
        $fecha_nacimiento = htmlspecialchars($_POST["fecha_nacimiento"]);
        $tipo= 1;
        // Validar los datos (agrega más validaciones según sea necesario)

        // Consulta SQL preparada para evitar inyección de SQL
        $sql = "INSERT INTO usuario (US_nombre, US_mail, US_pass, TIPOUS_ID) VALUES (?, ?, ?, ?);";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ssss", $nombre, $email, $contrasena, $tipo);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            header("Location: ingreso.html");
        } else {
            echo "Error en el registro: " . $stmt->error;
        }
        // Cerrar la declaración y la conexión
        $stmt->close();
    }
    
    // Cerrar la conexión
    $conn->close();
?>


