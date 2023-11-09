<?php
session_start(); 

// Verificar si el usuario ha iniciado sesión y es un usuario autorizado (por ejemplo, un administrador)
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
    $userType = $_SESSION['user_type'];
    
        // El usuario tiene permisos para acceder a esta página
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

        // Función para listar tareas
        function listarTareas($pdo, $tablero_id) {
            $statement = $pdo->prepare("SELECT * FROM tarea WHERE tablero_id = ?");
            $statement->execute([$tablero_id]);
            return $statement->fetchAll();
        }

        // Función para crear una tarea
        function crearTarea($pdo, $nombre, $descripcion, $estado_id, $tablero_id) {
            $statement = $pdo->prepare("INSERT INTO tarea (nombre, descripcion, estado_id, tablero_id) VALUES (?, ?, ?, ?)");
            $statement->execute([$nombre, $descripcion, $estado_id, $tablero_id]);
        }

        // Función para actualizar una tarea
        function actualizarTarea($pdo, $id, $nombre, $descripcion, $estado_id, $tablero_id) {
            $statement = $pdo->prepare("UPDATE tarea SET nombre = ?, descripcion = ?, estado_id = ?, tablero_id = ? WHERE id = ?");
            $statement->execute([$nombre, $descripcion, $estado_id, $tablero_id, $id]);
        }

        // Función para eliminar una tarea
        function eliminarTarea($pdo, $id) {
            $statement = $pdo->prepare("DELETE FROM tarea WHERE id = ?");
            $statement->execute([$id]);
        }

        // Obtener el ID del tablero a través de GET
        $tablero_id = $_GET['id'];

        // Procesar formularios
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['crear'])) {
                // Procesar el formulario de creación de tarea
                $nombreTarea = $_POST['nombre_tarea'];
                $descripcionTarea = $_POST['descripcion_tarea'];
                $estadoTarea = $_POST['estado_tarea'];
                crearTarea($pdo, $nombreTarea, $descripcionTarea, $estadoTarea, $tablero_id);
            } elseif (isset($_POST['actualizar'])) {
                // Procesar el formulario de actualización de tarea
                $idActualizar = $_POST['id_actualizar'];
                $nombreActualizar = $_POST['nombre_actualizar'];
                $descripcionActualizar = $_POST['descripcion_actualizar'];
                $estadoActualizar = $_POST['estado_actualizar'];
                actualizarTarea($pdo, $idActualizar, $nombreActualizar, $descripcionActualizar, $estadoActualizar, $tablero_id);
            } elseif (isset($_POST['eliminar'])) {
                // Procesar el formulario de eliminación de tarea
                $idEliminar = $_POST['id_eliminar'];
                eliminarTarea($pdo, $idEliminar);
            }
        }

        // Obtener y mostrar la lista de tareas
        $tareas = listarTareas($pdo, $tablero_id);
    
}

// Cerrar la conexión a la base de datos
$pdo = null;
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
    <title>Editar tareas</title>
  </head>
<body>
<body>
          <?php include('../vista/navBar.php'); ?>

    <div class="container mt-5">
        <h2 class="mb-4">Administración de Tareas</h2>
        
        <!-- Formulario para crear una tarea -->
        <form method="post" class="mb-4">
            <h3>Crear Tarea</h3>
            <div class="mb-3">
                <input type="text" name="nombre_tarea" class="form-control" placeholder="Nombre de la Tarea" required>
            </div>
            <div class="mb-3">
                <textarea name="descripcion_tarea" class="form-control" placeholder="Descripción de la Tarea" required></textarea>
            </div>
            <div class="mb-3">
                <select name="estado_tarea" class="form-select">
                    <option value="1">ToDo</option>
                    <option value="2">En Progreso</option>
                    <option value="3">Revisión</option>
                    <option value="4">Hecho</option>
                </select>
            </div>
            <button type="submit" name="crear" class="btn btn-primary">Crear</button>
        </form>

        <!-- Lista de tareas -->
        <h3>Lista de Tareas</h3>
        <table class="table">
            <thead>
                <tr class="table-dark">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;  foreach ($tareas as $tarea) { ?>
                    <?php
                        $i++;
                        if($i%2==0){
                            echo '<tr class="">';
                        }else{
                            echo '<tr class="table-primary">';
                        }
                        ?>
                        <td class="align-middle"><?php echo $tarea['id']; ?></td>
                        <td class="align-middle"><?php echo $tarea['nombre']; ?></td>
                        <td class="align-middle"><?php echo $tarea['descripcion']; ?></td>
                        <td class="align-middle"><?php echo $tarea['estado_id']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id_actualizar" value="<?php echo $tarea['id']; ?>">
                                <div class="mb-3">
                                    <input type="text" name="nombre_actualizar" value="<?php echo $tarea['nombre']; ?>" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="descripcion_actualizar" class="form-control" required><?php echo $tarea['descripcion']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <select name="estado_actualizar" class="form-select">
                                        <option value="1" <?php echo ($tarea['estado_id'] == 1) ? 'selected' : ''; ?>>ToDo</option>
                                        <option value="2" <?php echo ($tarea['estado_id'] == 2) ? 'selected' : ''; ?>>En Progreso</option>
                                        <option value="3" <?php echo ($tarea['estado_id'] == 3) ? 'selected' : ''; ?>>Revisión</option>
                                        <option value="4" <?php echo ($tarea['estado_id'] == 4) ? 'selected' : ''; ?>>Hecho</option>
                                    </select>
                                </div>
                                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                                <form method="post">
                                <input type="hidden" name="id_eliminar" value="<?php echo $tarea['id']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                            </form>
                            </form>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<!--content end-->
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>
