<?php
include('../config.php');
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

    <title>La carta de oh-nigiris!</title>
</head>

<?php
    include('../scripts/selector_de_barras.php');
    ?>
    <main>

            <div class="container bg-light py-5">
                <h1>Iniciar sección</h1>
                <p>No tiene cuenta? <a href="pagina_registro">regístrate aquí</a></p>
                <!--la funcion se llamara a cualquier cambio del formulario.-->
                <form action="/proyecto/views/login/login.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input class="form-control" type="text" id="usuario" name="usuario" placeholder="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">contraseña</label>
                        <input class="form-control" type="password" id="password" name="password" placeholder="******" required>

                    </div>
                    <hr>
                    
                    <label for="privacidad">Acepta nuestra <a href="#">política de privacidad?</a></label>
                    <input type="checkbox" id="privacidad" name="privacidad" required>
                    <button class="btn btn-dark" type="submit" id="enviar">Enviar</button>
                    <button class="btn btn-dark" type="reset">Borrar</button>
                    
                </form>
                
            </div>

    </main>
    <?php include 'barras/footer.php' ?>
</body>

</html>