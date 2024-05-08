<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $national_id = $_POST['national_id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // ایجاد hash از رمز عبور
    $passwordHash = ($password);

    // بررسی نام کاربری تکراری
    $check = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "این نام کاربری قبلا استفاده شده!";
    } else {
        // درج کاربر جدید در دیتابیس
        $sql = "INSERT INTO users (firstname, lastname, username, national_id, phone, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $firstname, $lastname, $username, $national_id, $phone, $email, $passwordHash);
        if ($stmt->execute()) {
            echo "ثبت نام انجام شد. تو الان میتونی <a href='login.php'>وارد شی</a>.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $check->close();
}
?>
<style type="text/css">
body {
    background-color: #666666;
}
</style>


<form method="post">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="876" height="535" border="1" align="center">
      <tbody>
        <tr bgcolor="#00FFF4">
          <td bgcolor="#00FFD4" style="text-align: center">First Name:
          <input type="text" name="firstname" required></td>
        </tr>
        <tr>
          <td bgcolor="#00FFD4" style="text-align: center"><br>
Last Name:
  <input type="text" name="lastname" required></td>
        </tr>
        <tr>
          <td height="71" bgcolor="#00FFD4" style="text-align: center"><br>
Username:
  <input type="text" name="username" required></td>
        </tr>
        <tr>
          <td height="57" bgcolor="#00FFD4" style="text-align: center">National ID:
          <input type="text" name="national_id" required></td>
        </tr>
        <tr>
          <td height="58" bgcolor="#00FFD4" style="text-align: center">Phone:
          <input type="text" name="phone" required></td>
        </tr>
        <tr>
          <td bgcolor="#00FFD4" style="text-align: center"><br>
Email:
  <input type="email" name="email" required></td>
        </tr>
        <tr>
          <td bgcolor="#00FFD4" style="text-align: center"><br>
Password:
  <input type="password" name="password" required></td>
        </tr>
        <tr>
          <td bgcolor="#00FFD4" style="text-align: center"><p>
            <input type="submit" value="Register">
            <input type="reset" name="reset" id="reset" value="Reset">
          </p>
          <p><a href="login.php">رفتن به صفحه ثبت نام</a></p></td>
        </tr>
      </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><br><br><br>
    </p>
</form>