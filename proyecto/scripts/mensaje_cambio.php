<?php
// detecta si ha habido un error en los formularios
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    echo "<div class='error'>Error: " . htmlspecialchars($_SESSION['error']) . "</div>";
    $_SESSION['error'] = ''; // Limpiar los errores después de mostrarlos
}
// detecta si ha habido un cambio en los formularios
if (isset($_SESSION['cambio']) && $_SESSION['cambio'] === TRUE) {
    echo "<div class='success'>Felicidades, los cambios han sido realizados con éxito.</div>";
    $_SESSION['cambio'] = FALSE; // Limpiar el mensaje de éxito después de mostrarlo
}
// detecta si ha registrado una cita
if (isset($_SESSION['cita']) && $_SESSION['cita'] === TRUE) {
    echo "<div class='success'>Felicidades, la cita ha sido registrada con éxito.</div>";
    $_SESSION['cita'] = ''; // Limpiar los errores después de mostrarlos
}
?>
