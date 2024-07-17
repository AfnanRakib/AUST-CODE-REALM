<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTag = trim($_POST['newTag']);

    if (!empty($newTag)) {
        $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $newTag = $conn->real_escape_string($newTag);
        $sql = "INSERT INTO tags (TagName) VALUES ('$newTag')";

        if ($conn->query($sql) === TRUE) {
            $tagID = $conn->insert_id;
            echo json_encode(['success' => true, 'tagID' => $tagID, 'tagName' => $newTag]);
        } else {
            echo json_encode(['success' => false]);
        }

        $conn->close();
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
