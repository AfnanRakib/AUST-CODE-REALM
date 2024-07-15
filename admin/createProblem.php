<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Create Problem - AUST CODE REALM</title>
    <script src="../tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#description, textarea#inputSpec, textarea#outputSpec, textarea#note',
            plugins: 'preview importcss searchreplace autolink save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            branding: false,
            promotion: false,
            quickbars_insert_toolbar: '',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    </script>
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
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <h2 style="text-align: center;color:#00A859;">Create a New Problem</h2>
    <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg justify-content-center">
        <div class="container">
            <form action="createProblem.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Problem Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
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
                    <label for="problemNumber" class="form-label">Problem Number:</label>
                    <input type="text" id="problemNumber" name="problemNumber" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note:</label>
                    <textarea id="note" name="note" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="timeLimit" class="form-label">Time Limit (ms):</label>
                    <input type="number" id="timeLimit" name="timeLimit" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="memoryLimit" class="form-label">Memory Limit (KB):</label>
                    <input type="number" id="memoryLimit" name="memoryLimit" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="ratedFor" class="form-label">Rated For (points):</label>
                    <input type="number" id="ratedFor" name="ratedFor" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Problem</button>
            </form>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $inputSpecification = $conn->real_escape_string($_POST['inputSpecification']);
    $outputSpecification = $conn->real_escape_string($_POST['outputSpecification']);
    $problemNumber = $conn->real_escape_string($_POST['problemNumber']);
    $note = $conn->real_escape_string($_POST['note']);
    $timeLimit = $conn->real_escape_string($_POST['timeLimit']);
    $memoryLimit = $conn->real_escape_string($_POST['memoryLimit']);
    $ratedFor = $conn->real_escape_string($_POST['ratedFor']);
    $authorID = $_SESSION['user']['UserID'];

    $sql = "INSERT INTO problems (Name, PlmDescription, InputSpecification, OutputSpecification, ProblemNumber, Note, TimeLimit, MemoryLimit, RatedFor, AuthorID) 
            VALUES ('$name', '$description', '$inputSpecification', '$outputSpecification', '$problemNumber', '$note', '$timeLimit', '$memoryLimit', '$ratedFor', '$authorID')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Problem created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
