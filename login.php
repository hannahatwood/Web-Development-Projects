<?php
session_start();
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $password = $_POST['password'];
    $usersFile = __DIR__ . '/users.txt';
    $users = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES) : [];
    foreach ($users as $user) {
        list($n, $e, $hash) = explode('|', $user);
        if ($n === $name && password_verify($password, $hash)) {
            $_SESSION['username'] = $n;
            $_SESSION['email'] = $e;
            header('Location: dashboard.php');
            exit();
        }
    }
    $login_error = 'Invalid name or password!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">LOGIN</span></h1>
    <?php if ($login_error): ?>
        <div class="error-msg"><?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>
    <form method="post" class="form">
        <label>Name:<br><input type="text" name="name" required></label><br><br>
        <label>Password:<br><input type="password" name="password" required></label><br><br>
        <button type="submit" class="btn">LOGIN</button>
    </form>
    <p>Don't have an account? &rarr; <a href="signup.php" class="btn">SIGN-UP</a></p>
</div>
</body>
</html> 