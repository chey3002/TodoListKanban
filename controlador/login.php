


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
    <title>Inicio</title>
  </head>
<body>
<!--content start-->
  
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Obtener las credenciales del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $pdo->prepare("SELECT * FROM usuario WHERE usuario = ? ");
    $statement->execute([$email]);
    $row = $statement->fetch();

    if ($row) {
    // Comprobar la contraseña utilizando password_verify
    $hashedPassword = $row['password'];

    if (password_verify($password, $hashedPassword)) {
        // Contraseña válida
        // Iniciar sesión y guardar los datos en las variables de sesión
        session_start();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_type'] = $row['tipo_id'];
        $_SESSION['user_name'] = $row['usuario']; // Guardar el nombre de usuario

        // Las credenciales son correctas, puedes redirigir a la página de inicio o realizar otras acciones.
        echo "Inicio de sesión exitoso. Redireccionando...";
        header("Location: /vista/dashboard.php");
    } else {
        // Contraseña incorrecta
        include('../vista/navBar.php');
        echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
}


    // Cerrar la conexión a la base de datos
    $pdo = null;
}
?>
<!--content end-->
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>
