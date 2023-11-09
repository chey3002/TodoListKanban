<?php
// Conexión a la base de datos (ajusta tus credenciales)

session_start(); 
$host = "localhost";
$db = "todolist";
$user = "root";
$password = "";
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

// Obtén el ID del tablero a través del parámetro "id" en la URL
if (isset($_GET['id'])) {
    $tablero_id = $_GET['id'];

    // Consulta para obtener las tareas de ese tablero
    $statement = $pdo->prepare("SELECT * FROM tarea WHERE tablero_id = ?");
    $statement->execute([$tablero_id]);
    $tareas = $statement->fetchAll();
} else {
    // Si no se proporciona un ID de tablero, muestra un mensaje de error o redirige a otra página
    echo "ID de tablero no proporcionado.";
    // Puedes redirigir con header("Location: otra_pagina.php");
    exit();
}
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
    <link href="https://bootswatch.com/5/sketchy/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <title>Tablero Kanban</title>
  </head>
<body>
        <?php include('navBar.php'); ?>
<?php 
if (isset($_SESSION['user_type'])) {?>
    <div class="container mt-5">
        <h2 class="mb-4">Tablero Kanban</h2>
        <button class="btn btn-primary mb-3" onclick="copiarEnlace()">Compartir Tablero</button>

        <!-- Tablero Kanban -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Tareas Pendientes
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            foreach ($tareas as $tarea) {
                                if ($tarea['estado_id'] == 1) { 
                            ?>
                                <li class="list-group-item">
                                    <h4><?php echo $tarea['nombre']; ?></h4>
                                    <p><?php echo $tarea['descripcion']; ?></p>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Tareas en Progreso
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            foreach ($tareas as $tarea) {
                                if ($tarea['estado_id'] == 2) { 
                            ?>
                                <li class="list-group-item">
                                    <h4><?php echo $tarea['nombre']; ?></h4>
                                    <p><?php echo $tarea['descripcion']; ?></p>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        Tareas en Revisión
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            foreach ($tareas as $tarea) {
                                if ($tarea['estado_id'] == 3) { 
                            ?>
                                <li class="list-group-item">
                                    <h4><?php echo $tarea['nombre']; ?></h4>
                                    <p><?php echo $tarea['descripcion']; ?></p>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Tareas Completadas
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            foreach ($tareas as $tarea) {
                                if ($tarea['estado_id'] == 4) { 
                            ?>
                                <li class="list-group-item">
                                    <h4><?php echo $tarea['nombre']; ?></h4>
                                    <p><?php echo $tarea['descripcion']; ?></p>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Agrega el código HTML del toast (inicialmente oculto) con una clase personalizada para el color de fondo del header -->
    <div class="toast align-items-center justify-content-center" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false" style="position: fixed; bottom: 10px; right: 10px;">
        <div class="toast-header " style="background-color: #d4edda">
            <strong class="me-auto">Copiado al portapapeles</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message">
        </div>
    </div>
    <?php } else { ?>
        <div class="container justify-content-center">
        <h1>Error, no se inicio sesión</h1>
        </div>
    <?php } ?>


 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
 <script>
        function copiarEnlace() {
            var enlace = window.location.href; // Obtiene la URL actual del navegador

            var input = document.createElement('input');
            input.value = enlace;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);

            var toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = "Enlace al tablero copiado al portapapeles: " + enlace;
            
            var toast = new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
        }
    </script>
</body>
</html>