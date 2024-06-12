<?php
// session_start(); ya deberia estar iniciada

// bd.php tambien


if (isset($_POST['user_id']) && $_POST['user_id'] !== ''){
    $idUsuario = $_POST['user_id'];
} else {
    $idUsuario = $_SESSION['usuario'];
}

// Preparar la declaración SQL para seleccionar los datos del usuario
$stmt = $conn->prepare('
    SELECT 
        u.nombre, u.apellidos, u.email, u.direccion, u.sexo, u.telefono,
        l.role, l.password, l.usuario
    FROM 
        usuarios u
    JOIN 
        logins l ON u.IdUsuario = l.idUsuarioFK
    WHERE 
        u.IdUsuario = ?
');
$stmt->bind_param('i', $idUsuario); // Cambio 's' a 'i' si IdUsuario es un entero
$stmt->execute();
$stmt->store_result();

// Verificar si se encontró el usuario
if ($stmt->num_rows > 0) {
    // Asociar los resultados de la consulta a variables
    $stmt->bind_result($nombre, $apellidos, $email, $direccion, $sexo, $telefono, $role, $password, $usuario);
    $stmt->fetch();
?>

<form id="userForm" method="post" action="perfil/actualizar_info.php" class="p-3 my-3">
    <?php if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE) {
        echo "Ahora tiene seleccionado al $role $usuario <br>";
    } ?>

    <?php if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE) { ?>
        <label for="role">Rol</label>
        <select class="form-control" name="role" id="role">
            <option value="usuario" <?php if ($role == 'usuario') echo 'selected'; ?>>usuario</option>
            <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>admin</option>
        </select><br>
    <?php } ?>


        <label for='nombre'>Nombre</label>
        <input required class="form-control" type="text" id="nombre" name="nombre" pattern="{3,30}" value='<?php echo htmlspecialchars($nombre); ?>'><br>

        <label for='apellidos'>Apellidos</label>
        <input required class="form-control" type="text" id="apellidos" name="apellidos" pattern="{3,30}" value='<?php echo htmlspecialchars($apellidos); ?>'><br>

        <label for='email'>Email</label>
        <input required class="form-control" type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" value='<?php echo htmlspecialchars($email); ?>'><br>

        <label for='direccion'>Dirección</label>
        <input required class="form-control" type="text" id="direccion" name="direccion" pattern="[a-zA-Z0-9._%+-]{5,255}" value='<?php echo htmlspecialchars($direccion); ?>'><br>

        <label for='telefono'>Teléfono</label>
        <input required class="form-control" type="text" id="telefono" name="telefono" pattern="[0-9]{9}" value='<?php echo htmlspecialchars($telefono); ?>'><br>

        <label for="sexo">Sexo</label>
        <select class="form-control" name="sexo" id="sexo" required>
            <option value="hombre" <?php if ($sexo === 'hombre') echo ' selected'; ?>>Hombre</option>
            <option value="mujer" <?php if ($sexo === 'mujer') echo ' selected'; ?>>Mujer</option>
            <option value="otro" <?php if ($sexo === 'otro') echo ' selected'; ?>>Otro</option>
        </select><br>

        <?php if (!isset($_SESSION['panel_admin']) || $_SESSION['panel_admin'] == FALSE) {
      echo '
        <div class="form-group">
            <label for="password">Para realizar los cambios, introduzca contraseña</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" pattern=".{8,60}" required>
        </div>
        '; }   ?>
<a href="perfil/cambio_contraseña.php">Cambiar contraseña?</a>
        <div class="p-2">
            <label for="confirmacion">¿Esta seguro?</label>
            <input type="checkbox" id="confirmacion" name="confirmacion" required>
            <button class="btn btn-dark" type='submit'>Actualizar Datos</button>
            <button class="btn btn-dark" type='reset'>Reiniciar</button>
        </div>
    </form>
<?php
} else {
    if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE) {
        echo "porfavor seleccione un usuario";
    } else {
        echo "Usuario no encontrado.";
    }
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>