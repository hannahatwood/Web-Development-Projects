<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="welcome-bg">
    <div class="container welcome">
        <h1><span class="highlight">Welcome to <span class="underline">StudyBuddy</span></span></h1>
        <div class="nav-buttons">
            <a href="login.php" class="btn">LOGIN</a>
            <a href="signup.php" class="btn">SIGN-UP</a>
        </div>
        <ul class="welcome-list">
            <li>Welcome to <b>StudyBuddy</b>!</li>
            <li>Share and find study resources shared by other students!</li>
        </ul>
        <div class="welcome-actions">
            <p>&rarr; Browse notes (login or sign-up)</p>
            <p>&rarr; Upload notes to help other students! (login or sign-up)</p>
        </div>
        <img src="welcomepage.png" alt="Welcome Page" class="welcome-img">
    </div>
</body>
</html> 