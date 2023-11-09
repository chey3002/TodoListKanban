<?php
session_start(); // Asegúrate de iniciar la sesión en todas las páginas donde accederás a las variables de sesión.
    

if (isset($_SESSION['user_type'])) {
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

    // Obtener los tableros según el tipo de usuario
    if ($user_type == 1) {
        // Usuario normal, solo sus tableros
        $user_id = $_SESSION['user_id'];
        $statement = $pdo->prepare("SELECT * FROM tablero WHERE user_id = ?");
        $statement->execute([$user_id]);
        $tableros = $statement->fetchAll();
    } else {
        // Lector, todos los tableros
        $statement = $pdo->prepare("SELECT * FROM tablero");
        $statement->execute();
        $tableros = $statement->fetchAll();
    }

    // Cerrar la conexión a la base de datos
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
    <title>Dashboard</title>
  </head>
<body>
      <?php include('../vista/navBar.php'); ?>
<div class="container mt-5">
<h1>Tableros</h1>
        <div class="row">
            <?php foreach ($tableros as $tablero) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $tablero['nombre']; ?></h5>
                            <a href="entrar_tablero.php?id=<?php echo $tablero['id']; ?>" class="btn btn-primary">Entrar en el tablero</a>
                            <?php
                                if ($user_type == 1) {
                                    echo '<a href="editar_tablero.php?id='.$tablero['id'].'" class="btn btn-primary">Editar tareas</a>' ;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
                            </div>
<!--content end-->
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>