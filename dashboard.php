<?php
session_start();

if (!isset($_SESSION["student"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; text-align:center; margin-top:80px; }
    </style>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION["student"]; ?>!</h1>
<p>You have successfully logged in.</p>

<a href="login.php">Logout</a>

</body>
</html>
