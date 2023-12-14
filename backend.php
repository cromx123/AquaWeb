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
        $apellido = htmlspecialchars($_POST["apellido"]);
        $telefono = htmlspecialchars($_POST["telefono"]);
        $email = htmlspecialchars($_POST["email"]);
        $contrasena = htmlspecialchars($_POST["contrasena"]);
        $tipo = 1;
        $calle = htmlspecialchars($_POST["calle"]);
        $callenum = htmlspecialchars($_POST["direccionnum"]);
        $comuna = htmlspecialchars($_POST["comuna"]);
        $US_id = rand(1000, 999999);
        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // Consulta SQL preparada para evitar inyección de SQL - Tabla 2 (direccion)
            $sqlDIR = "INSERT INTO direccion(DIR_CALLE,DIR_NUM,DIR_COMUNA) VALUES (?, ?, ?);";

            // Preparar la declaración
            $stmtDIR = $conn->prepare($sqlDIR);

            // Vincular parámetros (ajusta según tus campos)
            $stmtDIR->bind_param("sss", $calle, $callenum, $comuna);

            // Ejecutar la declaración para la tabla 2
            $stmtDIR->execute();

            // Obtener el DIR_id recién insertado
            $DIR_id = $stmtDIR->insert_id;

            // Cerrar la declaración para la tabla 2
            $stmtDIR->close();

            // Consulta SQL preparada para evitar inyección de SQL - Tabla 1 (usuario)
            $sqlUsuario = "INSERT INTO usuario (US_id, US_nombre, US_apellido, US_fono, US_mail, US_pass, TIPOUS_ID, DIR_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

            // Preparar la declaración
            $stmtUsuario = $conn->prepare($sqlUsuario);

            // Vincular parámetros
            $stmtUsuario->bind_param("issssssi", $US_id, $nombre, $apellido, $telefono, $email, $contrasena, $tipo, $DIR_id);

            // Ejecutar la declaración para la tabla 1
            $stmtUsuario->execute();
            $stmtUsuario->close();

            // Confirmar la transacción
            $conn->commit();

            // Redireccionar a la página de ingreso
            header("Location: ingreso.html");
            exit();
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            echo "Error en el registro: " . $e->getMessage();
        }
    } elseif (isset($_POST["login"])) {
        $email = htmlspecialchars($_POST["email"]);
        $contrasena = htmlspecialchars($_POST["contrasena"]);
        // Realizar consulta SQL
        $sql = "SELECT US_id, US_pass, US_mail, TIPOUS_ID FROM usuario WHERE US_mail = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si el usuario existe y las credenciales son correctas
        if ($row = $result->fetch_assoc()) {
            if ($contrasena == $row['US_pass']) {
                // Credenciales válidas, iniciar sesión
                $_SESSION["usuario"] = $row['US_nombre'];
                if($row['TIPOUS_ID'] == 0){
                    header("Location: balancesadm.html");
                }else if($row['TIPOUS_ID'] == 1){
                    header("Location: balancesusu.html");
                }else if($row['TIPOUS_ID'] == 2){
                    header("Location: actualizarestado.html");
                }
                
                exit();
            } else {
                include("ingreso.html");
                ?>
                <div class="AlertaINGRESO" role="alert">
                    <h1>ERROR AL INICIAR SESSIÓN</h1>
                    <p><strong>Email o Contraseña incorrecta.</strong></p>
                </div>
                <?php
            }
        } else {
            include("ingreso.html");
                ?>
                <div class="AlertaINGRESO" role="alert">
                    <h1>ERROR AL INICIAR SESSIÓN</h1>
                    <p><strong>Email o Contraseña incorrecta.</strong></p>
                </div>
                <?php
        }
        $stmt->close();
    }
}
// Cerrar la conexión
$conn->close();
?>
