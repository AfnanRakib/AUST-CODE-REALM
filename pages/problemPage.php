<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$problemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

include '../helpers/config.php';

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
    // Read the contents of the files
    if (file_exists($row['Input']) && file_exists($row['Output'])) {
        $row['Input'] = file_get_contents($row['Input']);
        $row['Output'] = file_get_contents($row['Output']);
    }
    $testcases[] = $row;
}
$stmt->close();

if (isset($_SESSION['user']['UserID'])) {
    $userId = $_SESSION['user']['UserID'];
    // Fetch user submissions for the current problem
    $sql = "SELECT * FROM submissions WHERE UserID = ? AND ProblemID = ? ORDER BY SubmissionTime DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $problemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $submissioncount = mysqli_num_rows($result);
    $submissions = [];
    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }
    $stmt->close();
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title><?php echo htmlspecialchars($problem['Name']); ?> - AUST CODE REALM</title>
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
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="row">
                        <h2 style="text-align: center;color:#00A859;">Submit Code</h2>
                        <div class="col editor-container">
                            <?php include '../helpers/ide.php'; ?>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <button class="btn btn-primary w-100" id="runButton">Run on Sample</button>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <button class="btn btn-primary w-100" id="submitButton">Submit Code</button>
                                </div>
                            </div>
                            <div class="row">
                                <div id="resultDisplay" class="mt-4 p-3"></div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Login First!!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="tab-pane fade" id="submissions" role="tabpanel" aria-labelledby="submissions-tab">
                <?php if (isset($_SESSION['user'])): ?>
                    <h1 class="text-center mb-4">My Submissions</h1>
                    <?php if ($submissioncount > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Submission ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Submission Time</th>
                                    <th scope="col">Time Taken (s)</th>
                                    <th scope="col">Memory Used (kb)</th>
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
                                        <td><?php echo $submission['TimeTaken']; ?></td>
                                        <td><?php echo $submission['MemoryUsed']; ?></td>
                                        <td><?php echo htmlspecialchars($submission['LanguageID']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center">
                            <h4>Empty</h4>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Login First!!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
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
    <?php include'../helpers/footer.php'?>

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
            document.querySelectorAll('.copy-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var targetId = this.getAttribute('data-copy-target');
                    var content = document.getElementById(targetId).innerText;
                    
                    var textarea = document.createElement('textarea');
                    textarea.value = content;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    
                    alert('Copied to clipboard: ' + content);
                });
            });
        });
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
            });
        });
    </script>
</body>
</html>
