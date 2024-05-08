<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

echo "<h1>خوش اومدی " . $_SESSION['username'] . "</h1>";
if ($_SESSION['is_admin']) {
    echo "<a href='admin.php'>صفحه مدیران </a><br>";
}

// ارسال پست جدید
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $content);
    $stmt->execute();
    echo "نظر شما برای مدیران ثبت شد.<br>";
    $stmt->close();
}

// نمایش پست‌های تایید شده در جدول
$sql = "SELECT posts.content, posts.created_at, users.username FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.is_approved = 1 ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
echo "<table border='1' style='width:100%; text-align:left;'>
    <tr>
        <th>نام کاربری</th>
        <th>نظر</th>
        <th>تاریخ ارسال</th>
    </tr>";
while ($post = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($post['username']) . "</td>
            <td>" . htmlspecialchars($post['content']) . "</td>
            <td>" . $post['created_at'] . "</td>
        </tr>";
}
echo "</table>";
?>
<style type="text/css">
body {
    background-image: url(../../../Users/Parsian/Documents/Unnamed%20Site%207/1.jpg);
}
</style>
<body background="../../../Users/Parsian/Documents/Unnamed Site 7/1.jpg">
<form method="post">
    <textarea name="content"></textarea><br>
    <input type="submit" value="ثبت نظر">
</form>