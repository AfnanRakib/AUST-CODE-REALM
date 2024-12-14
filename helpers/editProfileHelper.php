<?php
session_start();
$user = $_SESSION['user'];
$alertMessage = "";
$alertType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'config.php';

    if (isset($_POST['save_profile'])) {
        // Fetch the updated data from the form
        $email = $conn->real_escape_string($_POST['email']);
        $name = $conn->real_escape_string($_POST['name']);
        $institution = $conn->real_escape_string($_POST['institution']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $password = isset($_POST['password']) && !empty($_POST['password']) ? $conn->real_escape_string(md5($_POST['password'])) : null;
        $retype_password = isset($_POST['retype_password']) && !empty($_POST['retype_password']) ? $conn->real_escape_string(md5($_POST['retype_password'])) : null;

        // Update profile details
        $sql = "UPDATE users SET Email='$email', Name='$name', Institution='$institution', Gender='$gender', DateOfBirth='$dob' WHERE UserID=" . $user['UserID'];
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user']['Email'] = $email;
            $_SESSION['user']['Name'] = $name;
            $_SESSION['user']['Institution'] = $institution;
            $_SESSION['user']['Gender'] = $gender;
            $_SESSION['user']['DateOfBirth'] = $dob;
            $alertMessage = "Profile updated successfully.";
            $alertType = "success";
        } else {
            $alertMessage = "Error updating profile: " . $conn->error;
            $alertType = "danger";
        }

        // Update password if provided
        if ($password && $password === $retype_password) {
            $sql = "UPDATE users SET User_Password='$password' WHERE UserID=" . $user['UserID'];
            if ($conn->query($sql) === TRUE) {
                $_SESSION['user']['User_Password'] = $password;
                $alertMessage = "Profile and password updated successfully.";
                $alertType = "success";
            } else {
                $alertMessage = "Error updating password: " . $conn->error;
                $alertType = "danger";
            }
        } elseif ($password && $password !== $retype_password) {
            $alertMessage = "Passwords do not match.";
            $alertType = "danger";
        }
    }

    if (isset($_POST['save_picture'])) {
        // Update profile picture if provided
        $profile_picture = $_FILES['profile_picture'];

        if ($profile_picture['size'] > 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];

            if ($profile_picture['size'] > 1048576) {
                $alertMessage = "Profile picture size should be less than 1MB.";
                $alertType = "danger";
            } elseif (in_array($profile_picture['type'], $allowed_types)) {
                $target_dir = "../images/uploads/profile_pictures/";
                $target_file = $target_dir . $user['UserID'] . "." . pathinfo($profile_picture["name"], PATHINFO_EXTENSION);
                $dbLoc = "http://localhost/AUST%20CODE%20REALM/images/uploads/profile_pictures/" . $user['UserID'] . "." . pathinfo($profile_picture["name"], PATHINFO_EXTENSION);
                if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
                    $sql = "UPDATE users SET Profile_Picture='$dbLoc' WHERE UserID=" . $user['UserID'];
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['user']['Profile_Picture'] = $target_file;
                        $alertMessage = "Profile picture updated successfully.";
                        $alertType = "success";
                    } else {
                        $alertMessage = "Error updating profile picture: " . $conn->error;
                        $alertType = "danger";
                    }
                } else {
                    $alertMessage = "Error uploading file.";
                    $alertType = "danger";
                }
            } else {
                $alertMessage = "Invalid file type. Only JPEG, JPG, and PNG files are allowed.";
                $alertType = "danger";
            }
        }
    }

    $conn->close();
}
?>