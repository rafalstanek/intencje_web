<?php
session_start();
$_SESSION['user_type'] = null;
$_SESSION = array();
session_reset();
session_destroy();
echo '<script>window.location = "index.php";</script>';