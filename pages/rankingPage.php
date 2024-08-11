<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/contestPage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Contest Rankings</title>
</head>
<body>
<?php include '../helpers/navbar.php'; ?>
<div class="container mt-4">
    <h1 class="text-center">Contest Rankings</h1>
    <table class="table table-bordered mt-4">
        <thead>
        <tr>
            <th>Rank</th>
            <th>User Handle</th>
            <th>Problems Solved</th>
            <th>Total Penalty</th>
            <th>Details</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include '../helpers/config.php';
        $contest_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch overall rankings
        $sql = "SELECT u.Handle, COUNT(cs.ProblemID) as problems_solved, 
                       SUM(TIME_TO_SEC(TIMEDIFF(cs.SubmissionTime, c.StartTime)) + (cs.attempts - 1) * 20 * 60) as total_penalty 
                FROM users u 
                JOIN contest_submissions cs ON u.UserID = cs.UserID 
                JOIN contests c ON cs.ContestID = c.ContestID 
                WHERE cs.Status = 'Accepted' AND cs.ContestID = ?
                GROUP BY u.UserID 
                ORDER BY problems_solved DESC, total_penalty ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $contest_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rank = 1;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$rank}</td>
                    <td>{$row['Handle']}</td>
                    <td>{$row['problems_solved']}</td>
                    <td>{$row['total_penalty']}</td>
                    <td><button class='btn btn-info' data-handle='{$row['Handle']}' data-contest='{$contest_id}'>Details</button></td>
                  </tr>";
            $rank++;
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
</div>

<!-- Modal to show details -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Submission Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Problem ID</th>
                            <th>Status</th>
                            <th>Penalty</th>
                        </tr>
                    </thead>
                    <tbody id="detailsTableBody">
                        <!-- Details will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-info').on('click', function() {
        var handle = $(this).data('handle');
        var contestId = $(this).data('contest');
        $.ajax({
            url: '../helpers/fetchRanking.php',
            type: 'GET',
            data: {
                handle: handle,
                contestId: contestId
            },
            success: function(response) {
                $('#detailsTableBody').html(response);
                $('#detailsModal').modal('show');
            }
        });
    });
});
</script>
</body>
</html>
