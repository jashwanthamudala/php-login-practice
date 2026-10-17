<?php
session_start();

// Clear session values, then end the session.
$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;
