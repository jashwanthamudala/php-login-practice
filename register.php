<?php
session_start();

require_once __DIR__ . "/config.php";

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $password === "") {
        $errorMessage = "Please fill in all the fields.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)"
            );
            $stmt->execute([$name, $email, $passwordHash]);

            $_SESSION["success_message"] = "Your account has been created. You can now log in.";
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            // A duplicate email is commonly rejected by the table's UNIQUE constraint.
            if ($e->getCode() === "23000") {
                $errorMessage = "That email may already be registered. Try logging in.";
            } else {
                $errorMessage = "We couldn't create your account. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create an account</title>
</head>
<body>
    <h1>Create an account</h1>

    <?php if ($errorMessage !== ""): ?>
        <p><?= htmlspecialchars($errorMessage, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Log in</a>.</p>
</body>
</html>
