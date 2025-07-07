<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = htmlspecialchars($_SESSION['username']);

// Get recent uploads from uploads/ directory
$uploads = array_diff(scandir('uploads'), array('.', '..'));
$uploads = array_reverse($uploads); // Most recent first
$recent_uploads = array_slice($uploads, 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="welcome-bg">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1><span class="highlight">DASHBOARD</span></h1>
            <a href="logout.php" class="btn" style="margin:0;">LOGOUT</a>
        </div>
        <h2 style="margin-top: 0.5em;">Welcome, <span class="underline"><?php echo $username; ?></span>!</h2>
        <div style="margin: 32px 0 24px 0;">
            <a href="upload.php" class="btn">Upload Notes</a>
            <a href="view.php" class="btn">View Shared Notes</a>
        </div>
        <div class="recent-uploads" style="margin-top: 30px;">
            <h3 class="highlight" style="margin-bottom: 0.5em;">Recent Uploads</h3>
            <?php if (count($recent_uploads) > 0): ?>
                <ul style="text-align:left; max-width:400px; margin:0 auto;">
                    <?php foreach ($recent_uploads as $file): ?>
                        <li><a class="note-link" href="uploads/<?php echo urlencode($file); ?>" target="_blank"><?php echo htmlspecialchars($file); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No uploads yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>