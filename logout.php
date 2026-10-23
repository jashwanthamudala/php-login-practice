<?php
session_start();

// Get the current cookie settings.
$params = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires'  => time() - 3600,
    'path'     => $params['path'],
    'domain'   => $params['domain'],
    'secure'   => $params['secure'],
    'httponly' => $params['httponly'],
    'samesite' => $params['samesite'] ?? 'Lax'
]);


// Clear session values, then end the session.
$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;
