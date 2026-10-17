<?php
session_start();

require_once __DIR__ . "/config.php";

$errorMessage = "";
$successMessage = $_SESSION["success_message"] ?? "";
unset($_SESSION["success_message"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, email, password_hash FROM users WHERE email = ?"
    );
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password_hash"])) {
        // Give the authenticated session a fresh ID after login.
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        header("Location: dashboard.php");
        exit;
    }

    // Use the same message whether the email or password was incorrect.
    $errorMessage = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
</head>
<body>
    <h1>Log in</h1>

    <?php if ($successMessage !== ""): ?>
        <p><?= htmlspecialchars($successMessage, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>

    <?php if ($errorMessage !== ""): ?>
        <p><?= htmlspecialchars($errorMessage, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Log in</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a>.</p>
</body>
</html>
