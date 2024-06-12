<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Solo si usas HTTPS
ini_set('session.use_strict_mode', 1);

/*
post_max_size = 20MB
upload_max_filesize = 5MB
upload_types = "image/jpeg,image/png,image/gif,application/pdf,application/zip"
upload_tmp_dir = /tmp/uploads
*/
?>
