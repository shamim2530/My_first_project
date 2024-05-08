<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, is_admin FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: inde.php");
    } else {
    }
    $stmt->close();
}
?>
<style type="text/css">
body {
    background-color: #1400FF;
}
</style>

<form method="post">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<p>&nbsp;</p>
<table width="384" height="202" border="1" align="center">
      <tbody>
        <tr>
          <td width="374" bgcolor="#D8BB00" style="text-align: center">Username:
          <input type="text" name="username" required></td>
        </tr>
        <tr>
          <td bgcolor="#D8BB00" style="text-align: center"><br>
Password:
  <input type="password" name="password" required></td>
        </tr>
        <tr>
          <td bgcolor="#D8BB00" style="text-align: center"><p>
            <input type="submit" value="Login">
          </p>
          <p><a href="register.php">رفتن به صفحه ثبت نام</a></p></td>
        </tr>
      </tbody>
    </table>
    <p>&nbsp;</p>
    <p><br>
    </p>
</form>