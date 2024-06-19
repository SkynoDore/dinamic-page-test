<?php
include('../config.php');
session_start();
include '../scripts/bd.php';
include('../scripts/autentificador_usuario.php');

//establezco una nueva variable de sesion para que el comportamiento de mostrar_info.php sea diferente
$_SESSION['panel_admin'] = TRUE;

$role = $_SESSION['role'];

// Obtener la lista de usuarios si es administrador
if ($role == 'admin') {
    $userStmt = $conn->prepare('SELECT DISTINCT u.idUsuario, l.usuario FROM usuarios u INNER JOIN logins l ON u.IdUsuario = l.idUsuarioFK');

    $userStmt->execute();
    $userStmt->store_result();
    $userStmt->bind_result($idUsuario, $usuario);

    $users = [];
    while ($userStmt->fetch()) {
        $users[] = ['id' => $idUsuario, 'name' => $usuario];
    }
    $userStmt->close();
}
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
    <title>Panel de admin</title>
</head>

<body>
    <?php
    include('../scripts/selector_de_barras.php');
    ?>

    <main>
        <?php
        include('../scripts/mensaje_cambio.php');
        ?>
        <div class="bg-light">
            <section>
                <div class="bg-light container">
                    <h1>Panel de administrador de usuarios</h1>
                    <p>Bienvenido al administrador de perfiles, aquí puedes crear, modificar o eliminar cuentas de usuarios.</p>
                    <p>Cualquier cambio es irreversible, tenga mucho cuidado de no equivocarse.</p>
                    <!-- el formulario esta en el siguiente archivo, que a su vez se procesa en otro archivo -->
                    <div class="d-flex flex-column justify-content-center">
    <button class="btn btn-secondary m-2 w-100 " type="button" onclick="toggleForm('crear')">Crear nuevo usuario</button>
    <form action="/dinamic-page-test/views/perfil/cambio_contraseña.php">
        <button class="btn btn-secondary m-2 w-100 " type="submit">Cambiar contraseña</button>
    </form>
    <form action="/dinamic-page-test/views/perfil/eliminar_usuario.php">
        <button class="btn btn-secondary m-2 w-100 " type="submit">Eliminar usuario</button>
    </form>
</div>

                    <div>
                    <div id="crearForm" style="display: none;">
                    <h2>Crear usuario</h2>
                            <form action="/dinamic-page-test/views/login/registrar.php" method="post">
                                <div class="form-group">
                                    <label for="sexo">Rol</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option autofocus value="">--Porfavor seleccione--</option>
                                        <option value="usuario">usuario</option>
                                        <option value="admin">admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre" pattern="[A-Za-záéíóúüÁÉÍÓÚÜñÑ ]{3,30}" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input class="form-control" type="text" id="apellidos" name="apellidos" pattern="[A-Za-záéíóúüÁÉÍÓÚÜñÑ ]{3,30}" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Usuario</label>
                                    <input class="form-control" type="text" id="usuario" name="usuario" pattern="{3,30}" placeholder="Ej: entre 1 y 12 caracteres" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input class="form-control" type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Ej: Ohnigiri.rest@email.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Numero de teléfono</label>
                                    <input class="form-control" type="text" id="telefono" name="telefono" pattern="[0-9]{9}" placeholder="Ej: 123456789" required>

                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input class="form-control" type="text" id="direccion" name="direccion" pattern="[A-Za-z0-9áéíóúüÁÉÍÓÚÜñÑ.,\- ]{5,255}" placeholder="Ej: Calle Alonso cano 31, 28011" required>
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


                    <h2 class="m-3">Modificar usuario</h2>
                    <div class="d-flex justify-content-center">
            <button class="btn btn-secondary mx-2" type="button" onclick="toggleForm('modificar')">Seleccionar usuario</button>
        </div>
        <div id="modificarForm" style="display: none;">
        <form method="post" action="/dinamic-page-test/views/admin_usuarios.php" class="p-3 my-3">
                <label for='user_id'>Seleccionar usuario a modificar:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                    <?php } ?>
                </select><br>
                <button class="btn btn-dark" type="submit" id="enviar">Cambiar</button>
                        </form>
                    </div>
                    
                    <?php include'perfil/mostrar_info.php' ?>
                    </div>
            </section>
        </div>
    </main>
    <?php include 'barras/footer.php' ?>
    <script>
        function toggleForm(formId) {
            var crearForm = document.getElementById('crearForm');
            var modificarForm = document.getElementById('modificarForm');
            
            if (formId === 'crear') {
                crearForm.style.display = crearForm.style.display === 'none' ? 'block' : 'none';
                modificarForm.style.display = 'none';
            } else if (formId === 'modificar') {
                modificarForm.style.display = modificarForm.style.display === 'none' ? 'block' : 'none';
                crearForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>