<?php
session_start();
$signup_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if ($name && $email && $password && $confirm) {
        if ($password === $confirm) {
            $usersFile = __DIR__ . '/users.txt';
            $users = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES) : [];
            foreach ($users as $user) {
                list($n, $e) = explode('|', $user);
                if ($e === $email) {
                    $signup_error = 'Email already registered!';
                    break;
                }
            }
            if (!$signup_error) {
                $line = $name . '|' . $email . '|' . password_hash($password, PASSWORD_DEFAULT) . "\n";
                file_put_contents($usersFile, $line, FILE_APPEND);
                header('Location: login.php?signup=success');
                exit();
            }
        } else {
            $signup_error = 'Passwords do not match!';
        }
    } else {
        $signup_error = 'Please fill in all fields!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">SIGN UP</span></h1>
    <?php if ($signup_error): ?>
        <div class="error-msg"><?= htmlspecialchars($signup_error) ?></div>
    <?php endif; ?>
    <form method="post" class="form">
        <label>Name:<br><input type="text" name="name" required></label><br><br>
        <label>Email:<br><input type="email" name="email" required></label><br><br>
        <label>Password:<br><input type="password" name="password" required></label><br><br>
        <label>Confirm Password:<br><input type="password" name="confirm" required></label><br><br>
        <button type="submit" class="btn">CREATE ACCOUNT</button>
    </form>
    <p>Already have an account? &rarr; <a href="login.php" class="btn">LOGIN</a></p>
</div>
</body>
</html> 