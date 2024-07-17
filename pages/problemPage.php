<?php
session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

$problemId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userId = $_SESSION['user']['UserID'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch problem details
$sql = "SELECT * FROM problems WHERE ProblemID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $problemId);
$stmt->execute();
$result = $stmt->get_result();
$problem = $result->fetch_assoc();
$stmt->close();

// Fetch test cases for the current problem
$sql = "SELECT * FROM testcases WHERE ProblemID = ? ORDER BY testCaseNo ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $problemId);
$stmt->execute();
$result = $stmt->get_result();
$testcases = [];
while ($row = $result->fetch_assoc()) {
    $testcases[] = $row;
}
$stmt->close();

// Fetch user submissions for the current problem
$sql = "SELECT * FROM submissions WHERE UserID = ? AND ProblemID = ? ORDER BY SubmissionTime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $problemId);
$stmt->execute();
$result = $stmt->get_result();
$submissions = [];
while ($row = $result->fetch_assoc()) {
    $submissions[] = $row;
}
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
                <h1 class="text-center mb-4">My Submissions</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Submission ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Submission Time</th>
                            <th scope="col">Time Taken (ms)</th>
                            <th scope="col">Memory Used (KB)</th>
                            <th scope="col">Language</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $submission): ?>
                            <tr>
                                <th scope="row">
                                    <a href="#" class="submission-id" data-code="<?php echo htmlspecialchars($submission['Code']); ?>" data-lang="<?php echo htmlspecialchars($submission['LanguageID']); ?>">
                                        <?php echo htmlspecialchars($submission['SubmissionID']); ?>
                                    </a>
                                </th>
                                <td><?php echo htmlspecialchars($submission['Status']); ?></td>
                                <td><?php echo htmlspecialchars($submission['SubmissionTime']); ?></td>
                                <td><?php echo htmlspecialchars($submission['TimeTaken']); ?></td>
                                <td><?php echo htmlspecialchars($submission['MemoryUsed']); ?></td>
                                <td><?php echo htmlspecialchars($submission['LanguageID']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Code Modal -->
    <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="codeModalLabel">Submission Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="codeTextarea" class="form-control" rows="15" readonly></textarea>
                    <button class="btn btn-primary mt-3" id="copyButton">Copy Code</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const problem = <?php echo json_encode($problem); ?>;
        const problemId = <?php echo json_encode($problemId); ?>;
        const testcases = <?php echo json_encode($testcases); ?>;
        const userId = <?php echo json_encode($userId); ?>;
    </script>
    <script src="../js/runcode.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.submission-id').forEach(function(element) {
                element.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    document.getElementById('codeTextarea').value = code;
                    const modal = new bootstrap.Modal(document.getElementById('codeModal'));
                    modal.show();
                });
            });

            document.getElementById('copyButton').addEventListener('click', function() {
                const codeTextarea = document.getElementById('codeTextarea');
                codeTextarea.select();
                codeTextarea.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand("copy");
                alert('Code copied to clipboard');
            });
        });
    </script>
</body>
</html>

