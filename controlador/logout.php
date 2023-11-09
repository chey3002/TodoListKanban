<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    

    
        // Iniciar una sesión y guardar los datos relevantes en las variables de sesión
        session_start();
        session_destroy();

        // Las credenciales son correctas, puedes redirigir a la página de inicio o realizar otras acciones.
        echo "Cerrado de sesión exitoso. Redireccionando...";
        header("Location: /index.php");

    // Cerrar la conexión a la base de datos
    $pdo = null;
}
?>