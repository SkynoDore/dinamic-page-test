<?php
include('../config.php');
session_start();
$_SESSION['panel_admin'] = FALSE;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" CONTENT="Gabriel Vich">
    <meta name="description" content="Contacto">
    <meta name="category" content="Bar">
    <link rel="icon" type="image/jpg" href="../photos/favicon.ico">
    <!-- ESTILO-->
    <link rel="stylesheet" href="../style/main.css">
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <!--Scripts JS-->

    <title>Perfil ohnigiri</title>
</head>
<body>
    <?php
    include('../scripts/selector_de_barras.php');
    ?>

    <main>
        
        <?php
        include('../scripts/mensaje_cambio.php');
        include '../scripts/bd.php';
        include('../scripts/autentificador_usuario.php');
        include('../views/barras/bienvenido.php');
        ?>

        <p>Bienvenido a tu perfil, aquí puedes ver y modificar tu información</p>
        <!-- el formulario esta en el siguiente archivo, que a su vez se procesa en otro archivo -->
        <?php
        include('perfil/mostrar_info.php');
        ?>
    
    </main>
    <?php include 'barras/footer.php' ?>
</body>

</html>