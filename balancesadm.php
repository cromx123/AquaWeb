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
                <a href="seguimiento.php" class="NavnoActive">Seguimiento</a>
                <a href="contacto.html" class="NavnoActive">Contacto</a>
                <a href="balancesadm.php#Reporte_Balances" class="NavActive">Tu perfil</a>
            </nav>
        </div>
    </header>
    <div class="todo">
        <div class="Menu_Administrador">
                <nav>
                    <a href="#Reporte_Balances">Reporte Balances</a>
                    <a href="#Mantener_Tablas_Basicas">Mantener Tablas Basicas</a>
                    <a href="#Gestionar_productos">Gestionar productos</a>
                    <a href="#Gestionar_Usuarios">Gestionar Usuarios</a>
                    <a href="#Validar_Compra">Validar Compra</a>
                </nav>
        </div>
        <div class="Cuadrado_variable">
            <div id="Reporte_Balances" class="tab-content">
                <h1>Reporte Balance</h1>
                
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
                        <form action="balancesadm.php#Reporte_Balances" method="post">
                            <p><button type="submit" name="options" value="WEEK"></button>Últimas 24 Horas</p>
                            <p><button type="submit" name="options" value="WEEK"></button>Última semana</p>
                            <p><button type="submit" name="options" value="MONTH"></button>Último mes</p>
                            <p><button type="submit" name="options" value="YEAR"></button>Último año</p>
                            <p><button ></button>Elija rango de Fecha</p>
                        </form>
                    </div>
                    <?php
                    $rango = isset($_POST["options"]) ? $_POST["options"] : "WEEK";
                    $sql = "SELECT COM_fecha, SUM(`COM_preciototal`) AS TOTAL FROM `compra` WHERE COM_fecha >= DATE_SUB(CURDATE(), INTERVAL 1 $rango) GROUP BY COM_fecha;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    if ($resultado->num_rows > 0) {
                        echo "<div class= 'tablabalances'>";
                        echo '<table border="1">';
                        echo '<tr><th>Fecha de Compra</th><th>Total</th></tr>';
                    
                        while ($fila = $resultado->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $fila['COM_fecha'] . '</td>';
                            echo '<td>$' . number_format($fila['TOTAL'], 2) . '</td>';
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
            <div id="Mantener_Tablas_Basicas" class="tab-content">
                <h1>Mantener Tablas Basicas</h1>
                
                    <div id="adm_tipousuario" class="admintabla">
                        <div class="contenedor_Tipo">
                            <h2 class="title">Agregar Tipo Usuario</h2>
                            <form action="backend.php" method="POST">
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Nombre <input type="text" id="nombre_TipoUsuario" name="nombre_TipoUsuario" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="agregar_TipoUsuario">Añadir Tipo Usuario</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipo">
                            <h2 class="title">Modificar Tipo Usuario</h2>
                            <form action="backend.php" method="POST" >
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>ID <input type="text" id="ID_TipoUsuario" name="ID_TipoUsuario" required></p>
                                    </div>
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Nombre <input type="text" id="nombre_TipoUsuario" name="nombre_TipoUsuario" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="modificar_TipoUsuario">Modificar Tipo Usuario</button>
                                    </div>
                                        
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipo">
                            <h2 class="title">Eliminar Tipo Usuario</h2>
                            <form action="backend.php" method="POST" >
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Id del Tipo Usuario a eliminar <input type="text" id="ID_TipoUsuario" name="ID_TipoUsuario" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="eliminar_TipoUsuario">Eliminar Tipo Usuario</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipotabla">
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

                            // Nombre de la tabla
                            $nombreTabla = "tipousuario";

                            $sql = "SELECT * FROM $nombreTabla";
                            $stmt = $conn->prepare($sql);

                            if (!$stmt) {
                                die("Error en la preparación de la consulta: " . $conn->error);
                            }

                            $stmt->execute();

                            $resultado = $stmt->get_result();

                            if ($resultado->num_rows > 0) {
                                echo '<div>';
                                echo '<table border="1">';
                                echo '<tr><th>ID</th><th>Descripción</th></tr>';
                                while ($fila = $resultado->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $fila['TIPOUS_ID'] . '</td>';
                                    echo '<td>' . $fila['TIPOUS_DESC'] . '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo 'No se encontraron resultados';
                            }

                            $stmt->close();
                            $conn->close();
                            ?>
                        </div>
                    </div>
                    <div id="adm_tipobidon" class="admintabla"> 
                        <div class="contenedor_Tipo">
                            <h2 class="title">Agregar Tipo Bidón</h2>
                            <form action="backend.php" method="POST">
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Nombre <input type="text" id="nombre_tipobidon" name="nombre_tipobidon" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="agregar_Tipobidon">Añadir Tipo Bidón</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipo">
                            <h2 class="title">Modificar Tipo Bidón</h2>
                            <form action="backend.php" method="POST" >
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>ID <input type="text" id="ID_tipobidon" name="ID_tipobidon" required></p>
                                    </div>
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Nombre <input type="text" id="nombre_tipobidon" name="nombre_tipobidon" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="modificar_Tipobidon">Modificar Tipo Bidón</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipo">
                            <h2 class="title">Eliminar Tipo Bidón</h2>
                            <form action="backend.php" method="POST" >
                                <div class="diseno_contenedortipo">
                                    <div class="contenedor_formulario_ingreso_tipo">
                                        <p>Id del Tipo Bidón a eliminar <input type="text" id="ID_tipobidon" name="ID_tipobidon" required></p>
                                    </div>
                                    <div class="boton_formulario_ingreso_tipo">
                                        <button type="submit" name="eliminar_Tipobidon">Eliminar Tipo Bidón</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="contenedor_Tipotabla">
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

                            // Nombre de la tabla
                            $nombreTabla = "tipo_bidon";
                            $sql = "SELECT * FROM $nombreTabla";
                            $stmt = $conn->prepare($sql);

                            if (!$stmt) {
                                die("Error en la preparación de la consulta: " . $conn->error);
                            }
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            if ($resultado->num_rows > 0) {
                                echo '<div>';
                                echo '<table border="1">';
                                echo '<tr><th>ID</th><th>Descripción</th></tr>';
                                while ($fila = $resultado->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $fila['TIPOBID_id'] . '</td>';
                                    echo '<td>' . $fila['TIPOBID_desc'] . '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo 'No se encontraron resultados';
                            }
                            $stmt->close();
                            $conn->close();
                            ?>
                        </div>
                    </div>
            </div>

            <!-- Aqui va el formulario para agregar un bidon -->
            <div id="Gestionar_productos" class="tab-content">
                <h1 class="title">Agregar bidón</h1>
                <form action="backend.php" method="POST" enctype="multipart/form-data">
                    <div class="diseno_contenedor">
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Nombre <input type="text" id="nombre_bidon" name="nombre_bidon" required></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Precio $<input type="number" id="precio_bidon" name="precio_bidon" required placeholder="2000"></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Litros <input type="number" id="litros_bidon" name="litros_bidon" required></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Stock <input type="number" id="stock_bidon" name="stock_bidon" required placeholder="20"></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Tipo Bidón <Select name="tipo_bidon" required><option value="1">Redondo, Plástico duro</option><option value="2">Redondo, Plástico reciclable</option></Select></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon2">
                            <p>Suba una imagen <input type="file" id="imagen" name="imagen" accept="image/*"></p>
                        </div>
                        <div class="boton_formulario_ingreso_bidon">
                            <button type="submit" name="agregar_bidon">Añadir bidón</button>
                        </div>
                        
                    </div>
                </form>
                <h1 class="title">Modificar bidón</h1>
                    <form action="backend.php" method="POST" >
                        <div class="diseno_contenedor">
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>ID <input type="text" id="ID_bidon" name="ID_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Nombre <input type="text" id="nombre_bidon" name="nombre_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Precio $<input type="number" id="precio_bidon" name="precio_bidon" required placeholder="2000"></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Litros <input type="number" id="litros_bidon" name="litros_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Stock <input type="number" id="stock_bidon" name="stock_bidon" required placeholder="20"></p>
                            </div>
                            <div class="boton_formulario_ingreso_bidon">
                                <button type="submit" name="modificar_bidon">Modificar bidón</button>
                            </div>
                            
                        </div>
                    </form>
                <h1 class="title">Eliminar bidón</h1>
                <form action="backend.php" method="POST" >
                    <div class="diseno_contenedor">
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Id del bidon a eliminar <input type="text" id="ID_bidon" name="ID_bidon" required></p>
                        </div>
                        <div class="boton_formulario_ingreso_bidon">
                            <button type="submit" name="eliminar_bidon">Eliminar bidón</button>
                        </div>
                        
                    </div>
                </form>
            </div>

            <div id="Gestionar_Usuarios" class="tab-content">
                <h1 class="title">Agregar Usuario</h1>
                <form action="backend.php" method="POST">
                    <div class="diseno_contenedor">
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Nombre <input type="text" id="nombre_bidon" name="nombre_bidon" required></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                                <p>Contraseña <input type="number" id="litros_bidon" name="litros_bidon" required></p>
                            </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Correo<input type="number" id="precio_bidon" name="precio_bidon" required placeholder="2000"></p>
                        </div>
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Tipo usuario <input type="number" id="litros_bidon" name="litros_bidon" required></p>
                        </div>
                        <div class="boton_formulario_ingreso_bidon">
                            <button type="submit" name="agregar_Usuario">Añadir Usuario</button>
                        </div>
                    </div>
                </form>
                <h1 class="title">Modificar Usuario</h1>
                    <form action="backend.php" method="POST" >
                        <div class="diseno_contenedor">
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>ID <input type="text" id="ID_bidon" name="ID_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Nombre <input type="text" id="nombre_bidon" name="nombre_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Contraseña <input type="number" id="litros_bidon" name="litros_bidon" required></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Correo<input type="number" id="precio_bidon" name="precio_bidon" required placeholder="2000"></p>
                            </div>
                            
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>Tipo usuario <input type="number" id="stock_bidon" name="stock_bidon" required placeholder="20"></p>
                            </div>
                            <div class="contenedor_formulario_ingreso_bidon">
                                <p>direccion <input type="number" id="stock_bidon" name="stock_bidon" required placeholder="20"></p>
                            </div>
                            <div class="boton_formulario_ingreso_bidon">
                                <button type="submit" name="modificar_Usuario">Modificar Usuario</button>
                            </div>
                            
                        </div>
                    </form>
                <h1 class="title">Eliminar Usuario</h1>
                <form action="backend.php" method="POST" >
                    <div class="diseno_contenedor">
                        <div class="contenedor_formulario_ingreso_bidon">
                            <p>Id del Usuario a eliminar <input type="text" id="ID_bidon" name="ID_bidon" required></p>
                        </div>
                        <div class="boton_formulario_ingreso_bidon">
                            <button type="submit" name="eliminar_Usuario">Eliminar Usuario</button>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div id="div5" class="tab-content">
                <h1>Agregar bidón</h1>
                <div class="diseno_contenedor">
                    <div class="diseno_contenedor_mensaje">
                        <h2> El bidón se agrego correctamente</h2>
                    </div>
                    
                </div>

            </div>
            <div id="Validar_Compra" class="tab-content">
                <h1>Validacion de las Compra</h1>
                <div class="diseno_contenedor_table">
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
                        $sql = "SELECT COM_COMID, BID_nom, COM_Cantidad, BID_stock FROM com_bid, compra, bidon WHERE COM_COMID = COM_id AND COM_estado = 'Pendiente' AND COM_BIDID = BID_id ORDER BY COM_COMID ASC";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $resultado = $stmt->get_result();
                        $prevCOM_COMID = null;
                        if ($resultado->num_rows > 0) {
                            echo '<table border="1">';
                            echo '<tr><th>Orden de Compras</th><th>Nombre  Bidón</th><th>Cantidad solicitada</th><th>Stock disponible</th><th>Aceptar</th><th>Rechazar</th></tr>';
                        
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $fila['COM_COMID'] . '</td>';
                                echo '<td>' . $fila['BID_nom'] . '</td>';
                                echo '<td>' . $fila['COM_Cantidad'] . '</td>';
                                echo '<td>' . $fila['BID_stock'] . '</td>';
                        
                                // Agregar botón solo para la primera aparición de COM_COMID
                                if ($fila['COM_COMID'] != $prevCOM_COMID) {
                                    echo "<form action='backend.php' method='post'>";
                                    echo '<input type="hidden" name="ID_compra" value="' . $fila['COM_COMID'] . '" />'; 
                                    echo '<input type="hidden" name="compra-validada" value="compra validada" />';
                                    echo '<input type="hidden" name="compra-rechazada" value="anulado" />';
                                    echo '<td><button name="btn_aceptar" type="submit">Aceptar</button></td>';
                                    echo '<td><button name="btn_rechazar" type="submit">Rechazar</button></td>';
                                    echo "</form>";
                                } else {
                                    echo '<td></td>';
                                    echo '<td></td>';
                                }
                        
                                echo '</tr>';
                        
                                $prevCOM_COMID = $fila['COM_COMID'];
                            }
                        
                            echo '</table>';
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