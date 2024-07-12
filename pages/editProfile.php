<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'aust_code_realm');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_email'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $query = "UPDATE `users` SET `Email` = '$email' WHERE `users`.`UserID` = " . $user['UserId'];
        if ($conn->query($query) === TRUE) {
            $_SESSION['user']['Email'] = $email;
            $success_message = "Email updated successfully.";
        } else {
            $error_message = "Error updating email: " . $conn->error;
        }
    }

    if (isset($_POST['update_name'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $query = "UPDATE `users` SET `Name` = '$name' WHERE `users`.`UserID` = " . $user['UserId'];
        if ($conn->query($query) === TRUE) {
            $_SESSION['user']['Name'] = $name;
            $success_message = "Name updated successfully.";
        } else {
            $error_message = "Error updating name: " . $conn->error;
        }
    }

    if (isset($_POST['update_password'])) {
        $password = $_POST['password'];
        $retype_password = $_POST['retype_password'];
        if ($password !== $retype_password) {
            $error_message = "Passwords do not match!";
        } else {
            $password_hashed = md5($conn->real_escape_string($password));
            $query = "UPDATE `users` SET `User_Password` = '$password_hashed' WHERE `users`.`UserID` = " . $user['UserId'];
            if ($conn->query($query) === TRUE) {
                $_SESSION['user']['User_Password'] = $password_hashed;
                $success_message = "Password updated successfully.";
            } else {
                $error_message = "Error updating password: " . $conn->error;
            }
        }
    }

    if (isset($_POST['update_profile_picture'])) {
        if ($_FILES['profile_picture']['name']) {
            $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
            $profile_picture_encoded = base64_encode($profile_picture);
            $query = "UPDATE `users` SET `Profile_Picture` = '$profile_picture_encoded' WHERE `users`.`UserID` = " . $user['UserId'];
            if ($conn->query($query) === TRUE) {
                $_SESSION['user']['Profile_Picture'] = $profile_picture_encoded;
                $success_message = "Profile picture updated successfully.";
            } else {
                $error_message = "Error updating profile picture: " . $conn->error;
            }
        } else {
            $error_message = "No profile picture selected.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/editProfile.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Edit Profile - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    <!-- Section -->
    <section class="edit-profile-section py-5">
        <div class="container">
            <h2>Edit Profile</h2>
            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <!-- Update Email Form -->
            <form action="editProfile.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>
                <button type="submit" name="update_email" class="btn btn-primary">Update Email</button>
            </form>
            <br>

            <!-- Update Name Form -->
            <form action="editProfile.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
                </div>
                <button type="submit" name="update_name" class="btn btn-primary">Update Name</button>
            </form>
            <br>

            <!-- Update Password Form -->
            <form action="editProfile.php" method="post">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (leave blank to keep current password)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="retype_password" class="form-label">Retype New Password</label>
                    <input type="password" class="form-control" id="retype_password" name="retype_password">
                </div>
                <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
            </form>
            <br>

            <!-- Update Profile Picture Form -->
            <form action="editProfile.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                </div>
                <button type="submit" name="update_profile_picture" class="btn btn-primary">Update Profile Picture</button>
            </form>
        </div>
    </section>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
