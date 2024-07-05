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
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <button type="submit">Register</button>
            </form>
            <p><a href="login.php">Already have an account? Log in here</a></p>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string(md5($_POST['password']));
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $address = $conn->real_escape_string($_POST['address']);

    $sql = "INSERT INTO users (username, email, password, fullname, address) VALUES ('$username', '$email', '$password', '$fullname', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful');</script>";
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
