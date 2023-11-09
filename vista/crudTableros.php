<?php
session_start(); 

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
 
$user_type = $_SESSION['user_type'];

    // Conexión a la base de datos
    $host = "localhost";
    $db = "todolist"; // Nombre de la base de datos
    $user = "root"; // Usuario de la base de datos
    $password = ""; // Contraseña de la base de datos
    $dsn = "mysql:host=" . $host . ";dbname=" . $db;
    $opciones = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
        $pdo = new PDO($dsn, $user, $password, $opciones);
    } catch (PDOException $th) {
        echo "Error de conexión a la base de datos: " . $th->getMessage();
        exit();
    }

    
// Funciones de manejo de tableros
function crearTablero($pdo, $user_id, $nombre) {
    $statement = $pdo->prepare("INSERT INTO tablero (user_id, nombre) VALUES (?, ?)");
    $statement->execute([$user_id, $nombre]);
    return $pdo->lastInsertId(); // Devuelve el ID del nuevo tablero
}

function actualizarTablero($pdo, $tablero_id, $nombre, $uid) {
    $statement = $pdo->prepare("UPDATE tablero SET nombre = ?, user_id = ? WHERE id = ?");
    $statement->execute([$nombre, $uid, $tablero_id]);
}

function eliminarTablero($pdo, $tablero_id) {
    $statement = $pdo->prepare("DELETE FROM tablero WHERE id = ?");
    $statement->execute([$tablero_id]);
}

function listarTableros($pdo, $user_id) {
    $statement = $pdo->prepare("SELECT * FROM tablero WHERE 1");
    $statement->execute([]);
    return $statement->fetchAll();
}

// Procesar formularios de tableros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear_tablero'])) {
        // Procesar el formulario de creación de tablero
        $nombreTablero = $_POST['nombre_tablero'];
        $tablero_id = crearTablero($pdo, $_SESSION['user_id'], $nombreTablero);
        // Puedes redirigir o mostrar un mensaje de éxito
    } elseif (isset($_POST['editar_tablero'])) {
        // Procesar el formulario de edición de tablero
        $tablero_id = $_POST['tablero_id'];
        $nombreTablero = $_POST['nombre_tablero'];
        $uid = $_POST['uid'];
        actualizarTablero($pdo, $tablero_id, $nombreTablero, $uid);
        // Puedes redirigir o mostrar un mensaje de éxito
    } elseif (isset($_POST['eliminar_tablero'])) {
        // Procesar el formulario de eliminación de tablero
        $tablero_id = $_POST['tablero_id'];
        eliminarTablero($pdo, $tablero_id);
        // Puedes redirigir o mostrar un mensaje de éxito
    }
}

// Obtener y mostrar la lista de tableros
$tableros = listarTableros($pdo, $_SESSION['user_id']);

// Cerrar la conexión PDO
$pdo = null;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-startup-image" href="https://www.wepora.com/asset/img/wepora-logo.png">
    <link rel="icon" type="image/x-icon" href="https://www.wepora.com/asset/img/wepora-logo.png">
    <meta name="description" content="Wepora is a best Graphics, software and Web Development company  and provides all IT solutions to their client. In india.."/>
    <meta name="Keywords" content="website design | website development | website logo  |  website hosting  | logo design| logo design ideas  | SEO | android |  best software company in india | cheapest | graphic design | Shrikant Kushwaha">
    <meta name="author" content="contain by Wepora team">
    <meta name="copyright" content="Copyright © 2020 Wepora" />
    <link href="https://bootswatch.com/5/slate/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <title>Crud Tableros</title>
  </head>
  <body>
    <?php include('navBar.php'); ?>
<div class="container mt-5">
    <h1>Mis Tableros</h1>

    <!-- Formulario de creación de tablero -->
    <form method="post">
        <div class="mb-3">
            <label for="nombre_tablero" class="form-label">Nombre del Tablero</label>
            <input type="text" class="form-control" id="nombre_tablero" name="nombre_tablero" required>
        </div>
        <button type="submit" class="btn btn-primary" name="crear_tablero">Crear Tablero</button>
    </form>

    <!-- Lista de tableros en una tabla -->
    <table class="table  mt-3">
        <thead>
            <tr class="table-dark">
                <th>ID</th>
                <th>UID</th>
                <th>Nombre del Tablero</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($tableros as $tablero): ?>
                 <?php
                        $i++;
                        if($i%2==0){
                            echo '<tr class="">';
                        }else{
                            echo '<tr class="table-primary">';
                        }
                        ?>
                    <td class="align-middle"><?php echo $tablero['id']; ?></td>
                    <td class="align-middle"><?php echo $tablero['user_id']; ?></td>
                    <td class="align-middle"><?php echo $tablero['nombre']; ?></td>
                    <td>
                        <!-- Formulario de edición de tablero -->
                        <form method="post">
                            <input type="hidden" name="tablero_id" value="<?php echo $tablero['id']; ?>">
                            <div class="mb-3">
                                <label for="nombre_tablero" class="form-label">Nombre del Tablero</label>
                                <input type="text" class="form-control" id="nombre_tablero" name="nombre_tablero" required value="<?php echo $tablero['nombre']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="uid" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="uid" name="uid" required value="<?php echo $tablero['user_id']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="editar_tablero">Guardar Cambios</button>
                        <form method="post">
                            <input type="hidden" name="tablero_id" value="<?php echo $tablero['id']; ?>">
                            <button type="submit" class="btn btn-danger" name="eliminar_tablero">Eliminar Tablero</button>
                        </form>
                        </form>
                    
                        <!-- Formulario de eliminación de tablero -->
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>