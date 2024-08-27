<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']['UserID'])) {
        header("Location: login.php");
        exit();
    }

    include '../helpers/config.php';

    $userID = $_SESSION['user']['UserID'];
    $query = "SELECT * FROM contests WHERE CreatorID='$userID'";
    $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="style.css">
    <title>Manage Contests - AUST CODE REALM</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    #updateProgress {
        display: none;
        margin-top: 10px;
    }
    #progressBar {
        width: 0%;
        height: 30px;
        background-color: #4CAF50;
        text-align: center;
        line-height: 30px;
        color: white;
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Contests</h1>
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-primary" onclick="window.location.href='createContest.php'">Create Contest</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <th scope="row"><?php echo $row['ContestID']; ?></th>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['StartTime']; ?></td>
                        <td><?php echo $row['EndTime']; ?></td>
                        <td><?php echo $row['Duration']; ?></td>
                        <td>
                            <a href="editContest.php?id=<?php echo $row['ContestID']; ?>" class="btn btn-primary">Edit</a>
                            <button class="btn btn-danger deleteContestBtn" data-contestid="<?php echo $row['ContestID']; ?>">Delete</button>
                            <button class="btn btn-success updateRatingBtn" data-contestid="<?php echo $row['ContestID']; ?>">Update Rating</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div id="updateProgress" class="container">
        <div id="progressBar"></div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.deleteContestBtn').click(function () {
                var contestID = $(this).data('contestid');
                if (confirm('Are you sure you want to delete this contest?')) {
                    $.ajax({
                        url: 'deleteContest.php',
                        type: 'POST',
                        data: { contestID: contestID },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message || 'Error deleting contest.');
                            }
                        },
                        error: function () {
                            alert('Error deleting contest.');
                        }
                    });
                }
            });

            $('.updateRatingBtn').click(function () {
                var contestId = $(this).data('contestid');
                updateRatings(contestId);
            });
        });

        function updateRatings(contestId) {
            if (confirm("Are you sure you want to update ratings for this contest?")) {
                $("#updateProgress").show();
                $.ajax({
                    url: 'updateRatings.php',
                    method: 'POST',
                    data: { contestId: contestId },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                $('#progressBar').css('width', percentComplete * 100 + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        $("#updateProgress").hide();
                        alert("Ratings updated successfully for " + response + " participants.");
                    },
                    error: function() {
                        $("#updateProgress").hide();
                        alert("An error occurred while updating ratings.");
                    }
                });
            }
        }
    </script>
</body>
</html>