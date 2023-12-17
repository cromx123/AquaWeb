<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi-Perfil-AquaWeb</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="cuerpo">
    <header>
        <div class="logo">
            <img src="./images/Logo.jpg" alt="AquaWeb Logo">
            <h1>AquaWeb</h1>
        </div>
        <div class="Espacio_nav">
            <nav>
                <a href="index.html" class="NavnoActive">Home</a>
                <a href="catalogo.php" class="NavnoActive">Catálogo</a>
                <a href="seguimiento.html" class="NavnoActive">Seguimiento</a>
                <a href="contacto.html" class="NavnoActive">Contacto</a>
                <a href="perfilcliente.php#Historial_Compras" class="NavActive">Tu perfil</a>
            </nav>
        </div>
    </header>
    <div class="todo">
        <div class="Menu_Administrador">
            <nav>
                <a href="#Historial_Compras">Historial Compras</a>
                <a href="#Reporte_Compras">Reporte Compras</a>
            </nav>
        </div>
    
        <div class="Cuadrado_variable">
            <div id="Historial_Compras" class="tab-content2">
                <h1>Historial de Compras</h1>
                <?php
                    session_start();
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
                    $US_id = $_SESSION['US_id'];
                    $sql = "SELECT * FROM `compra` WHERE `US_id` = ? ORDER BY COM_fecha DESC";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $US_id);
                    $stmt->execute();
                    if ($stmt->error) {
                        die("Error al ejecutar la consulta: " . $stmt->error);
                    }
                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                            echo '<div>';
                            echo '<table border="1">';
                            echo '<tr><th>Orden de compra</th><th>Estado</th><th>Número de productos</th><th>fecha</th><th>Total</th></tr>';
                        while ($fila = $resultado->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $fila['COM_id'] . '</td>';
                            echo '<td>' . $fila['COM_estado'] . '</td>';
                            echo '<td>' . $fila['COM_numprod'] . '</td>';
                            echo '<td>' . $fila['COM_fecha'] . '</td>';
                            echo '<td>' . $fila['COM_preciototal'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo 'No se ha registrado ninguna compra aun.';
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
            </div>
            <div id="Reporte_Compras" class="tab-content2">
                <h1>Reporte de Compras</h1>
                <div class="diseno_contenedor_table1">
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
                    ?>
                    <div class="btn_cambiorango">
                        <form action="perfilcliente.php#Reporte_Compras" method="post">
                            <p><button type="submit" name="options" value="WEEK"></button>Últimas 24 Horas</p>
                            <p><button type="submit" name="options" value="WEEK"></button>Última semana</p>
                            <p><button type="submit" name="options" value="MONTH"></button>Último mes</p>
                            <p><button type="submit" name="options" value="YEAR"></button>Último año</p>
                            <p><button ></button>Elija rango de Fecha</p>
                        </form>
                    </div>
                    <?php
                    $rango = isset($_POST["options"]) ? $_POST["options"] : "WEEK";
                    $sql = "SELECT COM_fecha, COM_numprod, SUM(`COM_preciototal`) AS TOTAL FROM `compra` WHERE COM_fecha >= DATE_SUB(CURDATE(), INTERVAL 1 $rango) GROUP BY COM_fecha;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    if ($resultado->num_rows > 0) {
                        echo "<div class= 'tablabalances'>";
                        echo '<table border="1">';
                        echo '<tr><th>Fecha de Compra</th><th>Cantidad  de Productos</th><th>Total</th></tr>';
                    
                        while ($fila = $resultado->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $fila['COM_fecha'] . '</td>';
                            echo '<td>' . $fila['COM_numprod'] . '</td>';
                            echo '<td>$' . number_format($fila['TOTAL'], 0) . '</td>';
                            echo '</tr>';
                        }
                    
                        echo '</table>';
                        echo "</div>";
                    } else {
                        echo 'No se encontraron resultados';
                    }
                    
                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer>

    </footer>
               
</body>
</html>