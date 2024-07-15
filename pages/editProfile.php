<?php include '../helpers/editProfileHelper.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - AUST CODE REALM</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/editProfile.css">
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    <h2 style="text-align: center;color:#00A859;">Edit Profile</h2>
    <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg justify-content-center">
        <div class="profile-container">
            <form method="post" action="editProfile.php" enctype="multipart/form-data" class="mb-3">
                <div class="profile-picture">
                    <img src="<?= $user['Profile_Picture'] ?>" id="profile-picture" alt="Profile Picture">
                    <label for="formFile" class="upload-icon">
                        <img src="../images/icons/edit.png" alt="Upload Icon" width="24" height="24">
                        <input class="form-control" type="file" name="profile_picture" id="formFile" onchange="previewImage(event)" style="display:none;">
                    </label>
                </div>
                <div class="save-button-container">
                    <button class="btn btn-primary" name="save_picture">Save Profile Picture</button>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <?php if ($alertMessage): ?>
                <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                    <?= $alertMessage ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="post" action="editProfile.php" class="mb-3">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="<?= htmlspecialchars($user['Email']) ?>" type="email" class="form-control" name="email" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input value="<?= htmlspecialchars($user['Name']) ?>" type="text" class="form-control" name="name" id="name" placeholder="Full Name">
                </div>
                <div class="mb-3">
                    <label for="institution" class="form-label">Institution</label>
                    <input value="<?= isset($user['Institution']) ? htmlspecialchars($user['Institution']) : '' ?>" type="text" class="form-control" name="institution" id="institution" placeholder="Institution">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" name="gender" id="gender">
                        <option value="" <?= !isset($user['Gender']) ? 'selected' : '' ?>></option>
                        <option value="male" <?= isset($user['Gender']) && $user['Gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= isset($user['Gender']) && $user['Gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= isset($user['Gender']) && $user['Gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input value="<?= isset($user['DateOfBirth']) ? htmlspecialchars($user['DateOfBirth']) : '' ?>" type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <div class="mb-3">
                    <label for="retype_password" class="form-label">Retype Password</label>
                    <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Retype Password">
                </div>
                <button class="btn btn-primary float-end" name="save_profile">Save Changes</button>
            </form>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('profile-picture');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
