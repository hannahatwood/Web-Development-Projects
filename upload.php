<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$upload_error = '';
$upload_success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['desc']);
    if ($title && isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $upload_dir = __DIR__ . '/uploads';
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    $upload_error = 'Failed to create uploads directory. Please contact administrator.';
                }
            }
            
            // Check if directory is writable
            if (!is_writable($upload_dir)) {
                $upload_error = 'Uploads directory is not writable. Please contact administrator.';
            } else {
                $filename = uniqid('note_', true) . '.pdf';
                $dest = $upload_dir . '/' . $filename;
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $meta = $title . '|' . $_SESSION['username'] . '|' . $filename . '|' . $desc . '|' . time() . "\n";
                    file_put_contents(__DIR__ . '/uploads.txt', $meta, FILE_APPEND);
                    $upload_success = 'File uploaded successfully!';
                } else {
                    $upload_error = 'Failed to save file. Please try again.';
                }
            }
        } else {
            $upload_error = 'Only PDF files allowed!';
        }
    } else {
        $upload_error = 'Please fill in all fields and select a PDF file!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload - StudyBuddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><span class="highlight">UPLOAD</span></h1>
    <?php if ($upload_error): ?>
        <div class="error-msg"><?= htmlspecialchars($upload_error) ?></div>
    <?php elseif ($upload_success): ?>
        <div class="success-msg"><?= htmlspecialchars($upload_success) ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="form">
        <label>Title:<br><input type="text" name="title" required></label><br><br>
        <label>Select File: <input type="file" name="file" accept="application/pdf" required></label><br><br>
        <label>Description:<br><input type="text" name="desc" required></label><br><br>
        <button type="submit" class="btn">UPLOAD</button>
    </form>
    <p style="margin-top:10px;">(Note: only pdf files allowed)</p>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html> 