<?php
include "db.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM students WHERE email='$email'";
    $res = $conn->query($sql);

    if ($res->num_rows == 0) {
        $message = "Email not registered. Please register first.";
    } else {
        $row = $res->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["student"] = $row["fullname"];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Incorrect password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { background: #eef2f3; font-family: Arial; }
        .box {
            width: 350px;
            margin: 80px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px #aaa;
        }
        input {
            width: 100%; padding: 10px; margin: 8px 0;
        }
        button {
            width: 100%; padding: 12px; background: #28a745; color: white; border: none;
        }
        .msg { text-align:center; color:red; }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>
    <?php if ($message) echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p style="text-align:center; margin-top:10px;">
        New user? <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>
