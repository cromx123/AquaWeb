<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo-AquaWeb</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/Logo.jpg" alt="AquaWeb Logo">
            <h1>AquaWeb</h1>
        </div>
        <div class="Espacio_nav">
            <nav>
                <a href="index.html" class="NavnoActive">Home</a>
                <a href="#" class="NavActive">Catálogo</a>
                <a href="seguimiento.html" class="NavnoActive">Seguimiento</a>
                <a href="contacto.html" class="NavnoActive">Contacto</a>
                <a href="ingreso.html" class="NavnoActive">Ingreso</a>
            </nav>
        </div>
    </header>
    <div class="titulo">
        <h1>Catálogo de Productos</h1>
    </div>
    
    <div class="todo">
        <div class="filtros">
            <h2>Filtrado de productos</h2>
            <div class="buscador_de_contenedores">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" name="searchTerm" placeholder="Buscar...">
                    <button type="submit" name="buscar">Buscar</button>
                </form>
            </div>
            <div class="filtros-eleccion">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="custom-dropdown">
                        <ul class="options-list">
                            <!-- Agrega value="mas_vendido" a cada botón -->
                            <li><button type="submit" name="orden" value="mas_vendido">Más vendido</button></li>
                            <li><button type="submit" name="orden" value="mejor_valorado">Mejor Valorado</button></li>
                            <li><button type="submit" name="orden" value="precio_ascendente">Precio Ascendente</button></li>
                            <li><button type="submit" name="orden" value="precio_descendente">Precio Descendente</button></li>
                            <li><button type="submit" name="orden" value="nombre_ascendente">Nombre Ascendente</button></li>
                            <li><button type="submit" name="orden" value="nombre_descendente">Nombre Descendente</button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="results-container">
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
                $searchTerm = isset($_POST["searchTerm"]) ? htmlspecialchars($_POST["searchTerm"]) : "";
                // Realizar la búsqueda en la base de datos
                $sql = "SELECT * FROM bidon WHERE BID_nom LIKE ? OR BID_precio = ? OR BID_litros = ?";

                
                // Verifica si se ha seleccionado una opción de orden
                if (isset($_POST["orden"])) {
                    $opcionOrden = $_POST["orden"];
                
                    // Aplica la lógica de ordenación según la opción seleccionada
                    switch ($opcionOrden) {
                        case "mas_vendido":
                            // Lógica de ordenación para "Más vendido"
                            $orderBy = " ORDER BY BID_cantVAL DESC"; // Reemplaza "ventas_columna" con el nombre real de la columna de ventas en tu base de datos
                            break;
                        case "mejor_valorado":
                            // Lógica de ordenación para "Mejor Valorado"
                            $orderBy = " ORDER BY BID_val DESC"; // Reemplaza "valoracion_columna" con el nombre real de la columna de valoración en tu base de datos
                            break;
                        case "precio_ascendente":
                            // Lógica de ordenación para "Precio Ascendente"
                            $orderBy = " ORDER BY BID_precio ASC";
                            break;
                        case "precio_descendente":
                            // Lógica de ordenación para "Precio Descendente"
                            $orderBy = " ORDER BY BID_precio DESC";
                            break;
                        case "nombre_ascendente":
                            // Lógica de ordenación para "Nombre Ascendente"
                            $orderBy = " ORDER BY BID_nom ASC";
                            break;
                        case "nombre_descendente":
                            // Lógica de ordenación para "Nombre Descendente"
                            $orderBy = " ORDER BY BID_nom DESC";
                            break;
                        default:
                            // Opción de orden desconocida
                            $orderBy = ""; // Si no hay una opción válida, la cadena de ordenación es vacía
                            break;
                    }
                
                    $sql .= $orderBy;
                }
                $stmt = $conn->prepare($sql);
                
                // Concatenar '%' al término de búsqueda para buscar coincidencias parciales
                $searchTerm = "%" . $searchTerm . "%";

                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // Mostrar resultados de la búsqueda
                if ($result->num_rows > 0) {
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='contenedores'>";
                        echo "<p>";
                        echo "<img src='images/" . $row['BID_imagen_url'] . "' alt='Imagen del bidón'>";

                        echo "<p><h4>" . $row['BID_nom'] . "</h4><br>";
                        echo "Precio: $" . $row['BID_precio'] . "<br>";
                        echo "Litros: " . $row['BID_litros'] . "<br>";
                        echo "Stock: " . $row['BID_stock'] . "</p>";
                        echo "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No se encontraron resultados.</p>";
                }
                $conn->close();
            ?>
        </div>
    </div>
    <footer>

    </footer>
</body>
</html>