<?php
if (isset($_SESSION["valido"]) || isset($_SESSION["nombre"])) {
?>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
<?php
}
?>