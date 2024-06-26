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
    <script src="../scripts/togglePassword.js"></script>
    <title>Hazte una cuenta ohnigiri!</title>
</head>

<body>
    <?php
    include('../scripts/selector_de_barras.php');
    ?>

    <main>

        <div class="container bg-light py-5">
            <h1>Eres nuevo? regístrate aquí</h1>
            <p>Ya tiene cuenta? <a href="pagina_login.php">Accede aquí</a></p>
            <!--la funcion se llamara a cualquier cambio del formulario.-->
            <form action="/dinamic-page-test/views/login/registrar.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" id="nombre" name="nombre" maxlength="30" pattern="[A-Za-záéíóúüÁÉÍÓÚÜñÑ ]{3,30}" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input class="form-control" type="text" id="apellidos" name="apellidos" maxlength="30" pattern="[A-Za-záéíóúüÁÉÍÓÚÜñÑ ]{3,30}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Usuario</label>
                    <input class="form-control" type="text" id="usuario" name="usuario" maxlength="12" pattern="{3,12}" placeholder="Ej: entre 1 y 12 caracteres" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input class="form-control" type="email" id="email" name="email" maxlength="45" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Ej: Ohnigiri.rest@email.com" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Numero de teléfono</label>
                    <input class="form-control" type="text" id="telefono" name="telefono" pattern="[0-9]{9}" placeholder="Ej: 123456789" required>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input class="form-control" type="text" id="direccion" name="direccion" maxlength="255" pattern="[A-Za-z0-9áéíóúüÁÉÍÓÚÜñÑ.,\- ]{5,255}" placeholder="Ej: Calle Alonso cano 31, 28011" required>
                    </div>
                    <div class="form-group">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" name="sexo" id="sexo" required>
                            <option autofocus value="">--Porfavor seleccione--</option>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Fecha de nacimiento">Fecha de nacimiento</label>
                        <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                </div>
                <hr>
                <div class="form-group">
                    <label for="passwordfield1">Contraseña</label>
                    <input class="form-control" type="password" id="passwordfield1" name="password" placeholder="Se requiere mínimo 8 caracteres, una letra mayúscula y un numero" pattern="{8,60}" required>
                </div>
                <div class="form-check">
                    <label for="passwordCheck1">Ocultar/mostrar contraseña</label>
                    <input class="form-check-input" type="checkbox" id="passwordCheck1">
                </div>
                <div class="form-group">
                    <label for="passwordfield2">Vuelve a introducir la contraseña</label>
                    <input class="form-control" type="password" id="passwordfield2" name="password2" placeholder="Se requiere mínimo 8 caracteres, una letra mayúscula y un numero" pattern="{8,60}" required>
                </div>
                <div class="form-check">
                    <label for="passwordCheck2">Ocultar/mostrar contraseña</label>
                    <input class="form-check-input" type="checkbox" id="passwordCheck2">
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