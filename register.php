<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $course = $_POST["course"];

    // Basic validations
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } 
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $message = "Phone must be 10 digits.";
    } 
    elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } 
    else {

        // Check if email already exists
        $check = $conn->query("SELECT email FROM students WHERE email='$email'");
        if ($check->num_rows > 0) {
            $message = "Email already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO students 
            (fullname, email, password, phone, address, dob, gender, course)
            VALUES ('$fullname', '$email', '$hashed', '$phone', '$address', '$dob', '$gender', '$course')";

            if ($conn->query($sql)) {
                header("Location: success.php");
                exit;
            } else {
                $message = "Database error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body { font-family: Arial; background: #eef2f3; }
        .box {
            width: 420px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px #aaa;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }
        .msg { text-align: center; color: red; }
    </style>
</head>

<body>
<div class="box">
    <h2>Register</h2>

    <?php if ($message) echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password (min 6 chars)" required>
        <input type="text" name="phone" placeholder="Phone Number (10 digits)" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="date" name="dob" required>

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <select name="course" required>
            <option value="">Select Course</option>
            <option value="BBA">BBA</option>
            <option value="BCSIT">BCSIT</option>
            <option value="BHM">BHM</option>
            <option value="MBA">MBA</option>
        </select>

        <button type="submit">Register</button>
    </form>

    <p style="text-align:center; margin-top:10px;">
        Already registered? <a href="login.php">Login</a>
    </p>
</div>
</body>
</html>
