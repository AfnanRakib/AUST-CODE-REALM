<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

include '../helpers/config.php';

$name = '';
$description = '';
$inputSpecification = '';
$outputSpecification = '';
$problemNumber = '';
$note = '';
$timeLimit = '';
$memoryLimit = '';
$ratedFor = '';
$sampleTestCaseNo = '';
$authorID = $_SESSION['user']['UserID'];

$sql = "INSERT INTO problems (Name, PlmDescription, InputSpecification, OutputSpecification, ProblemNumber, Note, TimeLimit, MemoryLimit, RatedFor, AuthorID, sampleTestNo) 
        VALUES ('$name', '$description', '$inputSpecification', '$outputSpecification', '$problemNumber', '$note', '$timeLimit', '$memoryLimit', '$ratedFor', '$authorID', '$sampleTestCaseNo')";

if ($conn->query($sql) === TRUE) {
    $problemID = $conn->insert_id;
    $insertQuery = "INSERT INTO `contestproblems` (`ContestID`, `ProblemID`) VALUES ('1','$problemID')";
    if ($conn->query($insertQuery)) {
        header("Location: editProblem.php?id=" . $problemID);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
