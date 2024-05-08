<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

// تایید یا حذف پست
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $post_id = $_POST['post_id'];
        $sql = "UPDATE posts SET is_approved = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $post_id = $_POST['post_id'];
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
    }
}

// نمایش پست‌هایی که هنوز تایید نشده‌اند
$sql = "SELECT id, content FROM posts WHERE is_approved = 0";
$result = $conn->query($sql);
while ($post = $result->fetch_assoc()) {
    echo htmlspecialchars($post['content']) . "<br>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
    echo "<input type='submit' name='approve' value='Approve'>";
    echo "<input type='submit' name='delete' value='Delete'>";
    echo "</form><br>";
}
?>