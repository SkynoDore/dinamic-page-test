<?php

// Define la raíz del proyecto usando la raíz del documento del servidor web
define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/proyecto/');

if (!isset($_SESSION["valido"]) || $_SESSION["valido"] !== TRUE) {
    // Usuario no autenticado
    include(PROJECT_ROOT . 'views/barras/barra_bienvenida.php');
} else {
    // Usuario autenticado
    if (isset($_SESSION["role"]) && $_SESSION["role"] == 'admin') {
        include(PROJECT_ROOT . 'views/barras/barra_admin.php');
    } else {
        include(PROJECT_ROOT . 'views/barras/barra_usuario.php');
    }
}
?>
