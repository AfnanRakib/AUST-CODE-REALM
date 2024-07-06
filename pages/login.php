<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>AUST CODE REALM</title>
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
            <h1>Welcome Back</h1>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="enter your e-mail" required>
                <input type="password" name="password" placeholder="enter your password" required>
                <button type="submit">Sign in</button>
            </form>
            <p><a href="signup.php">Don't have any account? Register Here</a></p>
        </div>
    </div>
</body>
</html>


<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string(md5($_POST['password']));
    
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        // User authenticated
        $_SESSION['user'] = array(
            'username' => $username,
            'email' => $row['email'],
            'fullname' => $row['fullname'],
            'address'=>$row['address']
        );

        header("Location: ../index.php");
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }

    $conn->close();
}
?>
