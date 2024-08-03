<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

include '../helpers/config.php';

if (!isset($_GET['id'])) {
    header("Location: userCreatedProblems.php");
    exit();
}

$problemID = $conn->real_escape_string($_GET['id']);

$query = "SELECT `ContestID` FROM `contestproblems` WHERE `ProblemID`= $problemID";
$contest_id_result = $conn->query($query);
if (!$contest_id_result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}
$row = $contest_id_result->fetch_assoc();
$contest_id=$row['ContestID'];

$query = "SELECT * FROM problems WHERE ProblemID = '$problemID'";
$result = $conn->query($query);
$problem = $result->fetch_assoc();

// Fetch tags
$tagQuery = "SELECT tags.TagID, tags.TagName, IF(problem_tags.TagID IS NULL, 0, 1) AS selected 
             FROM tags 
             LEFT JOIN problem_tags ON tags.TagID = problem_tags.TagID AND problem_tags.ProblemID = '$problemID'";
$tagResult = $conn->query($tagQuery);
$tags = [];
while ($row = $tagResult->fetch_assoc()) {
    $tags[] = $row;
}

// Fetch test cases
$testCaseQuery = "SELECT * FROM testcases WHERE ProblemID = '$problemID'";
$testCaseResult = $conn->query($testCaseQuery);
$testCases = [];
while ($row = $testCaseResult->fetch_assoc()) {
    $testCaseID = $row['ID'];
    $testCaseNo = $row['testCaseNo'];
    $inputFilePath = "../problems/$problemID/input_$testCaseNo.txt";
    $outputFilePath = "../problems/$problemID/output_$testCaseNo.txt";
    $inputContent = file_get_contents($inputFilePath);
    $outputContent = file_get_contents($outputFilePath);
    $testCases[] = [
        'ID' => $testCaseID,
        'Input' => $inputContent,
        'Output' => $outputContent,
        'No' => $testCaseNo
    ];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateDetails'])) {
        $problemNumber = $conn->real_escape_string($_POST['problemNumber']);
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $inputSpecification = $conn->real_escape_string($_POST['inputSpecification']);
        $outputSpecification = $conn->real_escape_string($_POST['outputSpecification']);
        $note = $conn->real_escape_string($_POST['note']);
        $memoryLimit = $conn->real_escape_string($_POST['memoryLimit']);
        $timeLimit = $conn->real_escape_string($_POST['timeLimit']);
        $ratedFor = $conn->real_escape_string($_POST['ratedFor']);
        $sampleTestCaseNo = $conn->real_escape_string($_POST['sampleTestCaseNo']);
        $new_contest_id = $conn->real_escape_string($_POST['contestID']);

        $updateQuery = "UPDATE problems 
                        SET ProblemNumber = '$problemNumber', 
                            Name = '$name', 
                            PlmDescription = '$description', 
                            InputSpecification = '$inputSpecification', 
                            OutputSpecification = '$outputSpecification', 
                            Note = '$note', 
                            MemoryLimit = '$memoryLimit', 
                            TimeLimit = '$timeLimit', 
                            RatedFor = '$ratedFor',
                            sampleTestNo = '$sampleTestCaseNo'
                        WHERE ProblemID = '$problemID'";

        if ($conn->query($updateQuery)) {
            //$insertQuery = "INSERT INTO `contestproblems` (`ContestID`, `ProblemID`) VALUES ('$problemID', '$contest_id')";
            $updateQuery = "UPDATE `contestproblems` SET `ContestID` = '$new_contest_id' 
                            WHERE `contestproblems`.`ContestID` = '$contest_id' AND `contestproblems`.`ProblemID` = '$problemID'";
            if ($conn->query($updateQuery)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Problem details updated successfully!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error updating problem details.'];
            }
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error updating problem details.'];
        }
        header("Location: editProblem.php?id=$problemID");
        exit();
    }

    if (isset($_POST['saveTags'])) {
        $deleteTagsQuery = "DELETE FROM problem_tags WHERE ProblemID = '$problemID'";
        $conn->query($deleteTagsQuery);

        if (isset($_POST['tags'])) {
            $selectedTags = $_POST['tags'];
            foreach ($selectedTags as $tagID) {
                $tagID = $conn->real_escape_string($tagID);
                $insertTagQuery = "INSERT INTO problem_tags (ProblemID, TagID) VALUES ('$problemID', '$tagID')";
                $conn->query($insertTagQuery);
            }
        }
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Tags updated successfully!'];
        header("Location: editProblem.php?id=$problemID");
        exit();
    }

    if (isset($_POST['newTestCase'])) {
        $newInput = $conn->real_escape_string($_POST['newInput']);
        $newOutput = $conn->real_escape_string($_POST['newOutput']);
        $testCaseNo = $conn->real_escape_string($_POST['testCaseNo']);

        $directoryPath = "../problems/$problemID";
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $insertQuery = "INSERT INTO testcases (ProblemID, testCaseNo) VALUES ('$problemID', '$testCaseNo')";
        if ($conn->query($insertQuery)) {
            $inputFilePath = "$directoryPath/input_$testCaseNo.txt";
            $outputFilePath = "$directoryPath/output_$testCaseNo.txt";

            file_put_contents($inputFilePath, $newInput);
            file_put_contents($outputFilePath, $newOutput);

            $_SESSION['alert'] = ['type' => 'success', 'message' => 'New test case added successfully!'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error adding new test case.'];
        }
        header("Location: editProblem.php?id=$problemID");
        exit();
    }

    if (isset($_POST['updateTestCase'])) {
        $testCaseID = $conn->real_escape_string($_POST['testCaseID']);
        $updatedInput = $conn->real_escape_string($_POST['updatedInput']);
        $updatedOutput = $conn->real_escape_string($_POST['updatedOutput']);
        $testCaseNo = $conn->real_escape_string($_POST['testCaseNo']);

        $directoryPath = "../problems/$problemID";
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $inputFilePath = "$directoryPath/input_$testCaseNo.txt";
        $outputFilePath = "$directoryPath/output_$testCaseNo.txt";

        file_put_contents($inputFilePath, $updatedInput);
        file_put_contents($outputFilePath, $updatedOutput);

        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Test case updated successfully!'];
        header("Location: editProblem.php?id=$problemID");
        exit();
    }

    if (isset($_POST['deleteTestCase'])) {
        $testCaseID = $conn->real_escape_string($_POST['testCaseID']);
        $testCaseNo = $conn->real_escape_string($_POST['testCaseNo']);

        $deleteQuery = "DELETE FROM testcases WHERE ID = '$testCaseID'";
        if ($conn->query($deleteQuery)) {
            $inputFilePath = "../problems/$problemID/input_$testCaseNo.txt";
            $outputFilePath = "../problems/$problemID/output_$testCaseNo.txt";

            if (file_exists($inputFilePath)) {
                unlink($inputFilePath);
            }
            if (file_exists($outputFilePath)) {
                unlink($outputFilePath);
            }

            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Test case deleted successfully!'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error deleting test case.'];
        }
        header("Location: editProblem.php?id=$problemID");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/problemSet.css">
    <title>Edit Problem - AUST CODE REALM</title>
    <script src="../js/tinymce/tinymce.min.js"></script>
    <script src="../js/tinyMCEinit.js"></script>
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
        .section-header {
            background-color: #f8f9fa;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .section-header h2 {
            margin: 0;
        }
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .tag-item {
            display: flex;
            align-items: center;
            gap: 5px;
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include '../helpers/navbar.php'; ?>
<div class="container">
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['alert']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <!-- Problem Details Section -->
    <div class="section-header">
        <h2>Problem Details</h2>
    </div>
    <form action="" method="post">
        <div class="row mb-3">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <label for="problemNumber" class="form-label">Problem Number</label>
                <input type="text" class="form-control" id="problemNumber" name="problemNumber" value="<?= $problem['ProblemNumber'] ?>" required>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <label for="name" class="form-label">Problem Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $problem['Name'] ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Problem Description</label>
            <textarea id="description" name="description"><?= htmlspecialchars($problem['PlmDescription']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="inputSpecification" class="form-label">Input Specification</label>
            <textarea id="inputSpecification" name="inputSpecification"><?= htmlspecialchars($problem['InputSpecification']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="outputSpecification" class="form-label">Output Specification</label>
            <textarea id="outputSpecification" name="outputSpecification"><?= htmlspecialchars($problem['OutputSpecification']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea id="note" name="note"><?= htmlspecialchars($problem['Note']) ?></textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label for="memoryLimit" class="form-label">Memory Limit (KB)</label>
                <input type="number" class="form-control" id="memoryLimit" name="memoryLimit" value="<?= $problem['MemoryLimit'] ?>" required>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label for="timeLimit" class="form-label">Time Limit (ms)</label>
                <input type="number" class="form-control" id="timeLimit" name="timeLimit" value="<?= $problem['TimeLimit'] ?>" required>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label for="ratedFor" class="form-label">Rated For</label>
                <input type="text" class="form-control" id="ratedFor" name="ratedFor" value="<?= $problem['RatedFor'] ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label for="sampleTestCaseNo" class="form-label">No. of Sample Test Cases</label>
                <input type="number" class="form-control" id="sampleTestCaseNo" name="sampleTestCaseNo" value="<?= $problem['sampleTestNo'] ?>" placeholder="Serially top few Testcases will be added" required>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label for="sampleTestCaseNo" class="form-label">Contest ID</label>
                <input type="number" class="form-control" id="contestID" name="contestID" value="<?= $contest_id ?>"required>
            </div>
        </div>
        <button type="submit" name="updateDetails" class="btn btn-primary">Save Problem Details</button>
    </form>

    <!-- Tags Section -->
    <div class="section-header">
        <h2>Tags</h2>
    </div>
    <form action="" method="post">
        <div class="mb-3">
            <div class="tag-container">
                <?php foreach ($tags as $tag): ?>
                    <div class="tag-item">
                        <input type="checkbox" id="tag_<?= $tag['TagID'] ?>" name="tags[]" value="<?= $tag['TagID'] ?>" <?= $tag['selected'] ? 'checked' : '' ?>>
                        <label for="tag_<?= $tag['TagID'] ?>"><?= $tag['TagName'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="submit" name="saveTags" class="btn btn-primary">Save Tags</button>
    </form>

    <!-- Test Cases Section -->
    <div class="section-header">
        <h2>Test Cases</h2>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Test Case No</th>
                <th>Input</th>
                <th>Output</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($testCases as $testCase): ?>
                <tr>
                    <td><?= $testCase['No'] ?></td>
                    <td><textarea readonly><?= htmlspecialchars($testCase['Input']) ?></textarea></td>
                    <td><textarea readonly><?= htmlspecialchars($testCase['Output']) ?></textarea></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateTestCaseModal_<?= $testCase['ID'] ?>">Update</button>
                        <form action="" method="post" class="d-inline">
                            <input type="hidden" name="testCaseID" value="<?= $testCase['ID'] ?>">
                            <input type="hidden" name="testCaseNo" value="<?= $testCase['No'] ?>">
                            <button type="submit" name="deleteTestCase" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Update Test Case Modal -->
                <div class="modal fade" id="updateTestCaseModal_<?= $testCase['ID'] ?>" tabindex="-1" aria-labelledby="updateTestCaseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateTestCaseModalLabel">Update Test Case #<?= $testCase['No'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="testCaseID" value="<?= $testCase['ID'] ?>">
                                    <div class="mb-3">
                                        <label for="updatedInput_<?= $testCase['ID'] ?>" class="form-label">Input</label>
                                        <textarea id="updatedInput_<?= $testCase['ID'] ?>" name="updatedInput" required><?= htmlspecialchars($testCase['Input']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updatedOutput_<?= $testCase['ID'] ?>" class="form-label">Output</label>
                                        <textarea id="updatedOutput_<?= $testCase['ID'] ?>" name="updatedOutput" required><?= htmlspecialchars($testCase['Output']) ?></textarea>
                                    </div>
                                    <input type="hidden" name="testCaseNo" value="<?= $testCase['No'] ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="updateTestCase" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add New Test Case -->
    <div class="section-header">
        <h2>Add New Test Case</h2>
    </div>
    <form action="" method="post">
        <div class="mb-3">
            <label for="testCaseNo" class="form-label">Test Case No</label>
            <input type="number" class="form-control" id="testCaseNo" name="testCaseNo" required>
        </div>
        <div class="mb-3">
            <label for="newInput" class="form-label">Input</label>
            <textarea id="newInput" name="newInput" required></textarea>
        </div>
        <div class="mb-3">
            <label for="newOutput" class="form-label">Output</label>
            <textarea id="newOutput" name="newOutput" required></textarea>
        </div>
        <button type="submit" name="newTestCase" class="btn btn-primary">Add Test Case</button>
    </form>
</div>
</body>
</html>
