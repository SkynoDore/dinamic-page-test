<?php
session_start();
session_unset();
session_destroy();
header('Location: /htdocs/index.php');
exit();
?>