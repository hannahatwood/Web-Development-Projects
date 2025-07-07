<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$uploadsFile = __DIR__ . '/uploads.txt';
$uploads = file_exists($uploadsFile) ? file($uploadsFile, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Notes - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">VIEW</span></h1>
    <table style="width:100%;margin-bottom:20px;">
        <tr><th>Title</th><th>Uploaded by</th><th>Download</th></tr>
        <?php foreach ($uploads as $line):
            list($title, $author, $filename, $desc, $ts) = explode('|', $line);
        ?>
        <tr>
            <td><a href="comments.php?file=<?= urlencode($filename) ?>" class="note-link"><?= htmlspecialchars($title) ?></a></td>
            <td><?= htmlspecialchars($author) ?></td>
            <td><a href="uploads/<?= htmlspecialchars($filename) ?>" download class="btn">download</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>Click on a note title to view or comment.</p>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html> 