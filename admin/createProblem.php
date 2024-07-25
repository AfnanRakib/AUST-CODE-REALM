<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']['UserID'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Create Problem - AUST CODE REALM</title>
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <h2 style="text-align: center; color: #00A859;">Create a New Problem</h2>
    <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg justify-content-center">
        <div class="container">
            <form action="createProblem.php" method="post">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="problemNumber" class="form-label">Problem Number:</label>
                            <input type="text" id="problemNumber" name="problemNumber" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="name" class="form-label">Problem Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Problem Description:</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="inputSpec" class="form-label">Input Specification:</label>
                    <textarea id="inputSpec" name="inputSpecification" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="outputSpec" class="form-label">Output Specification:</label>
                    <textarea id="outputSpec" name="outputSpecification" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note (Optional):</label>
                    <textarea id="note" name="note" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="memoryLimit" class="form-label">Memory Limit (KB):</label>
                            <input type="number" id="memoryLimit" name="memoryLimit" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="timeLimit" class="form-label">Time Limit (ms):</label>
                            <input type="number" id="timeLimit" name="timeLimit" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="ratedFor" class="form-label">Rated For (points):</label>
                            <input type="number" id="ratedFor" name="ratedFor" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="sampleTestCaseNo" class="form-label">No of Sample Test Case:</label>
                            <input type="number" id="sampleTestCaseNo" name="sampleTestCaseNo" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="tags" class="form-label">Tags:</label>
                            <div class="accordion" id="tagsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTags">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTags" aria-expanded="false" aria-controls="collapseTags">
                                            Select Tags
                                        </button>
                                    </h2>
                                    <div id="collapseTags" class="accordion-collapse collapse" aria-labelledby="headingTags" data-bs-parent="#tagsAccordion">
                                        <div class="accordion-body">
                                            <div id="tags">
                                                <?php
                                                
                                                include '../helpers/config.php';

                                                $tagQuery = "SELECT * FROM tags";
                                                $tagResult = $conn->query($tagQuery);
                                                while ($tagRow = $tagResult->fetch_assoc()) {
                                                    echo '<div class="form-check">';
                                                    echo '<input class="form-check-input" type="checkbox" name="tags[]" value="' . $tagRow['TagID'] . '" id="tag' . $tagRow['TagID'] . '">';
                                                    echo '<label class="form-check-label" for="tag' . $tagRow['TagID'] . '">' . $tagRow['TagName'] . '</label>';
                                                    echo '</div>';
                                                }
                                                $conn->close();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <label for="newTag" class="form-label">Create New Tag:</label>
                            <div class="input-group">
                                <input type="text" id="newTag" name="newTag" class="form-control">
                                <button type="button" class="btn btn-primary" onclick="createTag()">Create</button>
                            </div>
                            <div id="tagSuccessMessage" class="mt-2 text-success" style="display: none;">
                                Tag successfully created.
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end">Create Problem</button>
            </form>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        function createTag() {
            var newTag = document.getElementById('newTag').value;
            if (newTag.trim() !== '') {
                var formData = new FormData();
                formData.append('newTag', newTag);

                fetch('createTag.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var tagsDiv = document.getElementById('tags');
                        var newCheckbox = document.createElement('div');
                        newCheckbox.classList.add('form-check');
                        newCheckbox.innerHTML = `<input class="form-check-input" type="checkbox" name="tags[]" value="${data.tagID}" id="tag${data.tagID}"> <label class="form-check-label" for="tag${data.tagID}">${data.tagName}</label>`;
                        tagsDiv.appendChild(newCheckbox);
                        document.getElementById('newTag').value = '';
                        document.getElementById('tagSuccessMessage').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('tagSuccessMessage').style.display = 'none';
                        }, 3000);
                    } else {
                        alert('Error creating tag.');
                    }
                });
            }
        }
    </script>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include '../helpers/config.php';

    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $inputSpecification = $conn->real_escape_string($_POST['inputSpecification']);
    $outputSpecification = $conn->real_escape_string($_POST['outputSpecification']);
    $problemNumber = $conn->real_escape_string($_POST['problemNumber']);
    $note = $conn->real_escape_string($_POST['note']);
    $timeLimit = $conn->real_escape_string($_POST['timeLimit']);
    $memoryLimit = $conn->real_escape_string($_POST['memoryLimit']);
    $ratedFor = $conn->real_escape_string($_POST['ratedFor']);
    $sampleTestCaseNo = $conn->real_escape_string($_POST['sampleTestCaseNo']);
    $authorID = $_SESSION['user']['UserID'];

    $sql = "INSERT INTO problems (Name, PlmDescription, InputSpecification, OutputSpecification, ProblemNumber, Note, TimeLimit, MemoryLimit, RatedFor, AuthorID, sampleTestNo) 
            VALUES ('$name', '$description', '$inputSpecification', '$outputSpecification', '$problemNumber', '$note', '$timeLimit', '$memoryLimit', '$ratedFor', '$authorID','$sampleTestCaseNo')";

    if ($conn->query($sql) === TRUE) {
        $problemID = $conn->insert_id;
        if (!empty($_POST['tags'])) {
            foreach ($_POST['tags'] as $tagID) {
                $conn->query("INSERT INTO problem_tags (ProblemID, TagID) VALUES ('$problemID', '$tagID')");
            }
        }
        echo "<script>alert('Problem created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
