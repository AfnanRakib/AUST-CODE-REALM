<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']['UserID'])) {
        header("Location: login.php");
        exit();
    }
    include '../helpers/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Manage Test Cases - AUST CODE REALM</title>
    <style>
        .container {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .btn-primary {
            background-color: #00A859;
            border-color: #00A859;
        }
        .btn-primary:hover {
            background-color: #007b5e;
            border-color: #007b5e;
        }
        textarea {
            width: 100%;
            resize: vertical;
        }
        .form-label {
            font-size: 1.2rem;
            font-weight: bold;
            color: #00A859;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <h2 style="text-align: center; color: #00A859;">Create a New Test Case</h2>
    <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg justify-content-center">
        <div class="container">
            <form action="manageTestCase.php" method="post">
                <input type="hidden" name="action" value="create">
                <div class="mb-3">
                    <label for="problemID" class="form-label">Problem ID:</label>
                    <input type="text" id="problemID" name="problemID" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="testCaseNumber" class="form-label">Test Case Number:</label>
                    <input type="number" id="testCaseNumber" name="testCaseNumber" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="inputContents" class="form-label">Input Contents:</label>
                    <textarea id="inputContents" name="inputContents" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="outputContents" class="form-label">Output Contents:</label>
                    <textarea id="outputContents" name="outputContents" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary float-end">Create Test Case</button>
            </form>
        </div>
    </div>

    <h2 style="text-align: center; color: #00A859; margin-top: 50px;">Delete a Test Case</h2>
    <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg justify-content-center">
        <div class="container">
            <form action="manageTestCase.php" method="post">
                <input type="hidden" name="action" value="delete">
                <div class="mb-3">
                    <label for="problemID" class="form-label">Problem ID:</label>
                    <input type="text" id="problemID" name="problemID" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="testCaseNumber" class="form-label">Test Case Number:</label>
                    <input type="number" id="testCaseNumber" name="testCaseNumber" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger float-end">Delete Test Case</button>
            </form>
        </div>
    </div>
    <br>
    
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $problemID = $conn->real_escape_string($_POST['problemID']);
    $testCaseNumber = $conn->real_escape_string($_POST['testCaseNumber']);
    $action = $_POST['action'];

    if ($action == 'create') {
        $inputContents = str_replace("\r\n", "\n", $_POST['inputContents']);
        $outputContents = str_replace("\r\n", "\n", $_POST['outputContents']);

        $problemDir = "../problems/$problemID";

        // Create the problem directory if it doesn't exist
        if (!is_dir($problemDir)) {
            mkdir($problemDir, 0777, true);
        }

        $inputFilePath = "$problemDir/input_$testCaseNumber.txt";
        $outputFilePath = "$problemDir/output_$testCaseNumber.txt";

        // Write the input and output contents to their respective files
        file_put_contents($inputFilePath, $inputContents);
        file_put_contents($outputFilePath, $outputContents);

        // Save the file paths in the database
        $sql = "INSERT INTO testcases (ProblemID, testCaseNo, Input, Output) 
                VALUES ('$problemID', '$testCaseNumber', '$inputFilePath', '$outputFilePath')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Test case created successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'delete') {
        // Delete the test case from the database
        $sql = "DELETE FROM testcases WHERE ProblemID='$problemID' AND testCaseNo='$testCaseNumber'";

        if ($conn->query($sql) === TRUE) {
            $inputFilePath = "../problems/$problemID/input_$testCaseNumber.txt";
            $outputFilePath = "../problems/$problemID/output_$testCaseNumber.txt";

            // Delete the files if they exist
            if (file_exists($inputFilePath)) {
                unlink($inputFilePath);
            }
            if (file_exists($outputFilePath)) {
                unlink($outputFilePath);
            }

            echo "<script>alert('Test case deleted successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
