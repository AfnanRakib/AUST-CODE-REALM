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
    $query = "SELECT * FROM problems WHERE AuthorID='$userID'";
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
    <title>User Created Problems - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">User Created Problems</h1>
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-primary" onclick="window.location.href='createBlankProblem.php'">Create Problem</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Problem</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <th scope="row"><?php echo $row['ProblemID']; ?></th>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['RatedFor']; ?></td>
                        <td>
                            <?php
                                $tagQuery = "SELECT tags.TagName 
                                             FROM tags 
                                             JOIN problem_tags ON tags.TagID = problem_tags.TagID 
                                             WHERE problem_tags.ProblemID = " . $row['ProblemID'];
                                $tagResult = $conn->query($tagQuery);
                                while ($tagRow = $tagResult->fetch_assoc()) {
                                    echo $tagRow['TagName'] . ' ';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="editProblem.php?id=<?php echo $row['ProblemID']; ?>" class="btn btn-primary">Edit</a>
                            <button class="btn btn-danger deleteProblemBtn" data-problemid="<?php echo $row['ProblemID']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.deleteProblemBtn').click(function () {
                var problemID = $(this).data('problemid');
                if (confirm('Are you sure you want to delete this problem?')) {
                    $.ajax({
                        url: 'deleteProblem.php',
                        type: 'POST',
                        data: { problemID: problemID },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message || 'Error deleting problem.');
                            }
                        },
                        error: function () {
                            alert('Error deleting problem.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
