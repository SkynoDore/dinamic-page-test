<?php
include('../../config.php');
session_start();
include '../../scripts/bd.php';
include('../../scripts/autentificador_usuario.php');

$role = $_SESSION['role'];
$idUsuarioSesion = $_SESSION['usuario'];
$nombreUsuarioSesion = '';
$roleUsuarioSesion = '';

// Obtener el nombre de usuario y el rol del usuario de la sesión
$stmt = $conn->prepare('
    SELECT l.usuario, l.role 
    FROM usuarios u
    JOIN logins l ON u.IdUsuario = l.idUsuarioFK
    WHERE u.IdUsuario = ?
');
$stmt->bind_param('i', $idUsuarioSesion);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nombreUsuarioSesion, $roleUsuarioSesion);
$stmt->fetch();
$stmt->close();

if ($role == 'admin') {
    // Obtener la lista de usuarios si es administrador
    $userStmt = $conn->prepare('
        SELECT DISTINCT u.IdUsuario, l.usuario, l.role 
        FROM usuarios u
        JOIN logins l ON u.IdUsuario = l.idUsuarioFK
    ');
    $userStmt->execute();
    $userStmt->store_result();
    $userStmt->bind_result($idUsuario, $usuario, $roleUsuario);

    $users = [];
    while ($userStmt->fetch()) {
        $users[] = ['id' => $idUsuario, 'name' => $usuario, 'role' => $roleUsuario];
    }
    $userStmt->close();
}

if (isset($_POST['user_id']) && $_POST['user_id'] !== '') {
    $idUsuarioSeleccionado = $_POST['user_id'];

    // Obtener el usuario seleccionado
    $stmt = $conn->prepare('
        SELECT l.usuario, l.role 
        FROM usuarios u
        JOIN logins l ON u.IdUsuario = l.idUsuarioFK
        WHERE u.IdUsuario = ?
    ');
    $stmt->bind_param('i', $idUsuarioSeleccionado);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nombreUsuarioSeleccionado, $roleUsuarioSeleccionado);
    $stmt->fetch();

    $_SESSION['usuario_seleccionado'] = $idUsuarioSeleccionado;
    $_SESSION['usuario_seleccionado_nombre'] = $nombreUsuarioSeleccionado;
    $_SESSION['usuario_seleccionado_role'] = $roleUsuarioSeleccionado;
    $stmt->close();
} else {
    $idUsuarioSeleccionado = $idUsuarioSesion;
    $nombreUsuarioSeleccionado = $nombreUsuarioSesion;
    $roleUsuarioSeleccionado = $roleUsuarioSesion;
}

if (isset($_POST['delete_user']) && isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE && isset($_SESSION['usuario_seleccionado'])) {
    $idUsuarioEliminar = $_SESSION['usuario_seleccionado'];

    if ($idUsuarioEliminar == $idUsuarioSesion) {
        $_SESSION['error'] = "No puedes eliminar tu propia cuenta. Selecciona otro usuario.";
    } else {
        // Eliminar el usuario seleccionado
        $stmt = $conn->prepare('DELETE FROM usuarios WHERE IdUsuario = ?');
        $stmt->bind_param('i', $idUsuarioEliminar);

        if ($stmt->execute()) {
            $_SESSION['cambio'] = TRUE;
            unset($_SESSION['usuario_seleccionado']);
            unset($_SESSION['usuario_seleccionado_nombre']);
            unset($_SESSION['usuario_seleccionado_role']);
        } else {
            $_SESSION['error'] = "Error al eliminar el usuario. Inténtelo de nuevo.";
        }

        $stmt->close();
        header('Location: /dinamic-page-test/views/perfil/eliminar_usuario.php');
        exit();
    }
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
    <link rel="icon" type="image/jpg" href="../../photos/favicon.ico">
    <link rel="stylesheet" href="../../style/main.css">
    <script src="../../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <title>Eliminar usuario</title>
</head>
<body>
<main>
    <?php include('../../scripts/selector_de_barras.php'); ?>
    <div class="container">
    <?php include('../../scripts/mensaje_cambio.php'); ?>
    <h1>Eliminar Usuario</h1>
    <form method="post" action="" class="p-3 my-3">
        <?php if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE) { ?>
            <label for="user_id">Seleccionar usuario a eliminar:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo htmlspecialchars($user['id']); ?>" <?php echo ($user['id'] == $idUsuarioSeleccionado) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['name']); ?>
                    </option>
                <?php } ?>
            </select><br>
            <button class="btn btn-dark" type="submit" id="enviar">Seleccionar</button>
        <?php } ?>
    </form>

    <form action="" method="post" class="py-2">
        <?php if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE && isset($nombreUsuarioSeleccionado)) { ?>
            <p>Ahora tiene seleccionado al <span class="error"><?php echo $roleUsuarioSeleccionado; ?> <?php echo $nombreUsuarioSeleccionado; ?> </span></p>
            <p>La eliminación de usuario es permanente e irreversible. Tenga cuidado.</p>
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] !== '') { ?>
                <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php } ?>
            <div class="p-3">
                <label for="confirmacion_check">¿Está seguro?</label>
                <input type="checkbox" id="confirmacion_check" name="confirmacion_check" required>
                <button class="btn btn-dark" type="submit" name="delete_user">Eliminar Usuario</button>
                <button class="btn btn-dark" type="reset">Reiniciar</button>
            </div>
        <?php } ?>
    </form>
    </div>
</main>
</body>
</html>
