<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Signup - AUST CODE REALM</title>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="../images/loginbanner.jpg" alt="Side Art">
        </div>
        <div class="form-container">
            <div class="logo-container">
                <img src="../images/logo.png" alt="Logo">
            </div>
            <h1>Get Started</h1>
            <form action="signup.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="retype_password" placeholder="Retype Password" required>
                <input type="text" name="fullname" placeholder="Full Name" required>
                <button type="submit">Register</button>
            </form>
            <p><a href="login.php">Already have an account? Log in here</a></p>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include '../helpers/config.php';

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $retype_password = $conn->real_escape_string($_POST['retype_password']);
    $fullname = $conn->real_escape_string($_POST['fullname']);

    // Check if passwords match
    if ($password != $retype_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        $hashed_password = md5($password);
        $current_date = date('Y-m-d H:i:s'); // Get current date and time

        $sql = "INSERT INTO users (Handle, Email, User_Password, Name, DateJoined) VALUES ('$username', '$email', '$hashed_password', '$fullname', '$current_date')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful');</script>";
            header("Location: login.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
