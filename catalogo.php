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
    <h1>Catálogo de Productos</h1>

    <div class="search-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="searchTerm" placeholder="Buscar...">
            <button type="submit" name="buscar">Buscar</button>
        </form>
    </div>

    <div id="results-container">
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
            $sql = "SELECT * FROM bidon WHERE BID_nom LIKE ? OR BID_precio LIKE ? OR BID_litros LIKE ?";

            $stmt = $conn->prepare($sql);
            
            // Concatenar '%' al término de búsqueda para buscar coincidencias parciales
            $searchTerm = "%" . $searchTerm . "%";

            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            // Mostrar resultados de la búsqueda
            
            if ($result->num_rows > 0) {
                echo "<div id='results-container'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<p>";
                    echo "<p>Nombre: " . $row['BID_nom'] . "<br>";
                    echo "Precio: " . $row['BID_precio'] . "<br>";
                    echo "Litros: " . $row['BID_litros'] . "<br>";
                    echo "Stock: " . $row['BID_stock'] . "</p>";
                    // Mostrar la imagen
                    echo "<img src='images/" . $row['BID_imagen_url'] . "' alt='Imagen del bidón'>";
                    echo "</p>";
                }
                echo "</div>";
            } else {
                echo "<p>No se encontraron resultados.</p>";
            }
            $conn->close();
        ?>
    </div>
    
    <footer>

    </footer>
</body>
</html>