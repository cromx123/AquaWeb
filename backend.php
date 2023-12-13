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
        if (isset($_POST["registro"])) {
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
        elseif (isset($_POST["login"])) {
            $email = htmlspecialchars($_POST["email"]);
            $contrasena = htmlspecialchars($_POST["contrasena"]);
            // Realizar consulta SQL
            $sql = "SELECT US_id, US_pass, US_mail FROM usuario WHERE US_mail = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si el usuario existe y las credenciales son correctas
            if ($row = $result->fetch_assoc()) {
                if ($contrasena == $row['US_pass']) {
                    // Credenciales válidas, iniciar sesión
                    $_SESSION["usuario"] = $row['US_nombre'];

                    header("Location: index.html");
                    exit();
                } else {
                    echo "Contraseña incorrecta. Usted proporcionó:$contrasena y es",$row['US_pass'],"sin espacio" ;
                }
            } else {
                echo "Usuario no encontrado.";
            }
            $stmt->close();
        }
    }
    // Cerrar la conexión
    $conn->close();
?>


