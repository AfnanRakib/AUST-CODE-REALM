<?php
    $problemId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM problems WHERE ProblemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $problemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $problem = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/problemPage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <?php include '../helpers/judge0.php'; ?>

    <!-- Main Content -->
    <div class="container">
        <ul class="nav nav-tabs" id="problemTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="problem-statement-tab" data-bs-toggle="tab" href="#problem-statement" role="tab" aria-controls="problem-statement" aria-selected="true">Problem Statement</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="submit-tab" data-bs-toggle="tab" href="#submit" role="tab" aria-controls="submit" aria-selected="false">Submit</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="submissions-tab" data-bs-toggle="tab" href="#submissions" role="tab" aria-controls="submissions" aria-selected="false">My Submissions</a>
            </li>
        </ul>
        <div class="tab-content" id="problemTabsContent">
            <div class="tab-pane fade show active" id="problem-statement" role="tabpanel" aria-labelledby="problem-statement-tab">
            <?php include '../helpers/problemStatement.php'; ?>
            </div>
            <div class="tab-pane fade" id="submit" role="tabpanel" aria-labelledby="submit-tab">
                <div class="row">
                    <h2 style="text-align: center;color:#00A859;">Submit Code</h2>
                    <div class="col editor-container">
                        <?php include '../helpers/ide.php'; ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <button class="btn btn-primary w-100" id="runButton">Run</button>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <button class="btn btn-primary w-100" id="submitButton">Submit</button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="resultDisplay" class="mt-4 p-3 border rounded" style="background-color: #f8f9fa;margin-bottom:20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="submissions" role="tabpanel" aria-labelledby="submissions-tab">
                <div class="row">
                    <div class="col">
                        <h2 style="text-align: center;color:#00A859;">My Submissions</h2>
                        <div id="mySubmissions">
                            <!-- Display user's submissions here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/runcode.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        function copyToClipboard(elementId) {
            var text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard');
            }, function(err) {
                alert('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>
