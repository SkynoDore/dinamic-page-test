<?php
session_start();
session_unset();
session_destroy();
header('Location: /dinamic-page-test/index.php');
exit();
?>