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

    if (isset($_POST['createTag'])) {
        $newTag = $conn->real_escape_string($_POST['newTag']);
        $insertTagQuery = "INSERT INTO tags (TagName) VALUES ('$newTag')";
        if ($conn->query($insertTagQuery)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'New tag created successfully!'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error creating new tag.'];
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
        $newInput = str_replace("\r\n", "\n", $_POST['newInput']);
        $newOutput = str_replace("\r\n", "\n", $_POST['newOutput']);
        $testCaseNo = $conn->real_escape_string($_POST['testCaseNo']);

        $directoryPath = "../problems/$problemID";
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        $inputFilePath = "$directoryPath/input_$testCaseNo.txt";
        $outputFilePath = "$directoryPath/output_$testCaseNo.txt";

        $insertQuery = "INSERT INTO testcases (ProblemID, Input, Output, testCaseNo) VALUES ('$problemID', '$inputFilePath', '$outputFilePath', '$testCaseNo')";
        if ($conn->query($insertQuery)) {
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
        $updatedInput = str_replace("\r\n", "\n", $_POST['updatedInput']);
        $updatedOutput = str_replace("\r\n", "\n", $_POST['updatedOutput']);
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