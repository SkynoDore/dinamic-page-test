<?php 

// Verificar conexión
if ($conn->connect_error) {
    echo "No se ha logrado conectar con el servidor. Serás redirigido a la página principal en 5 segundos.";
    echo "<a href='/proyecto/index.php'>regresa al inicio</a>";
    // JavaScript para redireccionar automáticamente
    echo "<script>
            setTimeout(function(){
                window.location.href = '/proyecto/index.php';
            }, 5000);
          </script>";
    exit();
}

// Verificar que el usuario esté autenticado y que 'usuario' esté en la sesión
if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado. Serás redirigido a la página principal en 5 segundos.";
    echo "<a href='/proyecto/index.php'>regresa al inicio</a>";
    // JavaScript para redireccionar automáticamente
    echo "<script>
            setTimeout(function(){
                window.location.href = '/proyecto/index.php';
            }, 5000);
          </script>";
    exit();
}

?>
