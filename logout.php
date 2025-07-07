<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">LOGOUT</span></h1>
    <p>You have been successfully logged out.</p>
    <p>&rarr; <a href="index.php" class="btn"><b>Return to home</b></a></p>
    <img src="logout.png" alt="Logout" class="welcome-img">
</div>
</body>
</html> 