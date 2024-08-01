<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login - AUST CODE REALM</title>
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
                <input type="text" name="username" placeholder="Enter your handle" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <button type="submit">Sign in</button>
            </form>
            <p><a href="signup.php">Don't have an account? Register Here</a></p>
        </div>
    </div>
</body>
</html>


<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include '../helpers/config.php';
    
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string(md5($_POST['password']));
    
    $sql = "SELECT * FROM users WHERE Handle='$username' AND User_Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        // User authenticated
        $_SESSION['user'] = array(
            'UserID' => $row['UserID'],
            'Handle' => $row['Handle'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],
            'DateJoined' => $row['DateJoined'],
            'CurrentRating' => $row['CurrentRating'],
            'User_Role' => $row['User_Role'],
            'RatingCategory' => $row['RatingCategory'],
            'Profile_Picture' => $row['Profile_Picture'],
            'DateOfBirth' => $row['DateOfBirth'],
            'MaxRating' => $row['MaxRating'],
            'Institution' => $row['Institution'],
            'Gender' => $row['Gender']
        );

        header("Location: ../index.php");
    } else {
        echo "<script>alert('Invalid handle or password');</script>";
    }

    $conn->close();
}
?>
