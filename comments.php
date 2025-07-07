<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$filename = isset($_GET['file']) ? $_GET['file'] : '';
$uploadsFile = __DIR__ . '/uploads.txt';
$uploads = file_exists($uploadsFile) ? file($uploadsFile, FILE_IGNORE_NEW_LINES) : [];
$note = null;
foreach ($uploads as $line) {
    list($title, $author, $file, $desc, $ts) = explode('|', $line);
    if ($file === $filename) {
        $note = compact('title', 'author', 'file', 'desc', 'ts');
        break;
    }
}
if (!$note) {
    echo 'Note not found!';
    exit();
}
$commentsFile = __DIR__ . '/comments_' . $filename . '.txt';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);
    if ($comment) {
        $line = $_SESSION['username'] . ' - ' . $comment . "\n";
        file_put_contents($commentsFile, $line, FILE_APPEND);
    }
}
$comments = file_exists($commentsFile) ? file($commentsFile, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">COMMENTS</span></h1>
    <p><b>Note:</b> <?= htmlspecialchars($note['title']) ?><br>
    <b>Uploaded by:</b> <?= htmlspecialchars($note['author']) ?></p>
    <h3>Comments:</h3>
    <ul style="text-align:left;max-width:400px;margin:0 auto 20px auto;">
        <?php if ($comments): foreach ($comments as $c): ?>
            <li><?= htmlspecialchars($c) ?></li>
        <?php endforeach; else: ?>
            <li>No comments yet.</li>
        <?php endif; ?>
    </ul>
    <form method="post" class="form">
        <label>Add your comment: <input type="text" name="comment" required style="width:60%"></label>
        <button type="submit" class="btn">POST COMMENT</button>
    </form>
    <a href="view.php" class="btn">Back to View</a>
</div>
</body>
</html> 