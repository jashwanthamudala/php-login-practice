<?php
session_start();

// A session without a user ID is not logged in.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to your dashboard!</h1>
    <p>You are logged in.</p>

    <a href="logout.php">Log out</a>
</body>
</html>
