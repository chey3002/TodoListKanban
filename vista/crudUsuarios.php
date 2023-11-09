<?php
session_start(); 

// Verificar si el usuario ha iniciado sesión y es un usuario autorizado (por ejemplo, un administrador)
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
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

    // Función para listar usuarios
    function listarUsuarios($pdo) {
        $statement = $pdo->query("SELECT * FROM usuario");
        return $statement->fetchAll();
    }

    // Función para crear un usuario
function crearUsuario($pdo, $usuario, $password, $tipo_id) {
    // Encripta la contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $statement = $pdo->prepare("INSERT INTO usuario (usuario, password, tipo_id) VALUES (?, ?, ?)");
    $statement->execute([$usuario, $hashedPassword, $tipo_id]);
}


    function actualizarUsuario($pdo, $id, $usuario, $password, $tipo_id) {
    // Verifica si se proporcionó una nueva contraseña
    if (!empty($password)) {
        // Encripta la nueva contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Actualiza el usuario, incluyendo la contraseña encriptada
        $statement = $pdo->prepare("UPDATE usuario SET usuario = ?, password = ?, tipo_id = ? WHERE id = ?");
        $statement->execute([$usuario, $hashedPassword, $tipo_id, $id]);
    } else {
        // Si no se proporciona una nueva contraseña, actualiza el usuario sin modificar la contraseña
        $statement = $pdo->prepare("UPDATE usuario SET usuario = ?, tipo_id = ? WHERE id = ?");
        $statement->execute([$usuario, $tipo_id, $id]);
    }
}


    // Función para eliminar un usuario
    function eliminarUsuario($pdo, $id) {
        $statement = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
        $statement->execute([$id]);
    }

    // Procesar formularios
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['crear'])) {
            // Procesar el formulario de creación
            $nuevoUsuario = $_POST['nuevo_usuario'];
            $nuevaPassword = $_POST['nueva_password'];
            $nuevoTipoID = $_POST['nuevo_tipo_id'];
            crearUsuario($pdo, $nuevoUsuario, $nuevaPassword, $nuevoTipoID);
        } elseif (isset($_POST['actualizar'])) {
            // Procesar el formulario de actualización
            $idActualizar = $_POST['id_actualizar'];
            $usuarioActualizar = $_POST['usuario_actualizar'];
            $passwordActualizar = $_POST['password_actualizar'];
            $tipoIDActualizar = $_POST['tipo_id_actualizar'];
            actualizarUsuario($pdo, $idActualizar, $usuarioActualizar, $passwordActualizar, $tipoIDActualizar);
        } elseif (isset($_POST['eliminar'])) {
            // Procesar el formulario de eliminación
            $idEliminar = $_POST['id_eliminar'];
            eliminarUsuario($pdo, $idEliminar);
        }
    }

    // Obtener y mostrar la lista de usuarios
    $usuarios = listarUsuarios($pdo);
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
    <title>CRUD Usuarios</title>
  </head>
<body>

    <?php include('navBar.php'); ?>

    <div class="container mt-5">
        <h2 class="mb-4">Administración de Usuarios</h2>
        
        <!-- Formulario para crear un usuario -->
        <form method="post" class="mb-4">
            <h3>Crear Usuario</h3>
            <div class="mb-3">
                <input type="text" name="nuevo_usuario" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <input type="password" name="nueva_password" class="form-control" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <select name="nuevo_tipo_id" class="form-select">
                    <option value="1">Usuario</option>
                    <option value="2">Lector</option>
                </select>
            </div>
            <button type="submit" name="crear" class="btn btn-primary">Crear</button>
        </form>

        <!-- Lista de usuarios -->
        <h3>Lista de Usuarios</h3>
        <table class="table ">
            <thead>
                <tr class="table-dark">
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Tipo de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($usuarios as $usuario) { ?>
                    
                    
                        <?php
                        $i++;
                        if($i%2==0){
                            echo '<tr class="">';
                        }else{
                            echo '<tr class="table-primary">';
                        }
                        ?>
                        <td class="align-middle"><?php echo $usuario['id']; ?></td>
                        <td class="align-middle"><?php echo $usuario['usuario']; ?></td>
                        <td class="align-middle"><?php echo $usuario['password']; ?></td>
                        <td class="align-middle"><?php echo ($usuario['tipo_id'] == 1) ? 'Usuario' : 'Lector'; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id_actualizar" value="<?php echo $usuario['id']; ?>">
                                <div class="mb-3">
                                    <input type="text" name="usuario_actualizar" value="<?php echo $usuario['usuario']; ?>" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="password_actualizar"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <select name="tipo_id_actualizar" class="form-select">
                                        <option value="1" <?php echo ($usuario['tipo_id'] == 1) ? 'selected' : ''; ?>>Usuario</option>
                                        <option value="2" <?php echo ($usuario['tipo_id'] == 2) ? 'selected' : ''; ?>>Lector</option>
                                    </select>
                                </div>
                                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                                <form method="post">
                                    <input type="hidden" name="id_eliminar" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                            </form>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>