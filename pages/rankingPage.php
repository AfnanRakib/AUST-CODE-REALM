<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../images/logosm.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/contestPage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Contest Rankings</title>
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle !important;
        }
        .accepted { color: green; font-weight: bold; }
        .attempted { color: red; font-weight: bold; }
        .unattempted { color: #ccc; }
        .problem-cell {
            min-width: 80px;
        }
    </style>
</head>
<body>
<?php include '../helpers/navbar.php'; ?>
<div class="container">
    <h1 class="text-center mb-4">Contest Rankings</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Rank</th>
                    <th>Who</th>
                    <th>=</th>
                    <th>Penalty</th>
                    <?php
                    include '../helpers/config.php';
                    // Fetch problem IDs for this contest
                    $contest_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    $problem_sql = "SELECT p.ProblemNumber, cp.ProblemID 
                                    FROM contestproblems cp
                                    JOIN problems p ON cp.ProblemID = p.ProblemID
                                    WHERE cp.ContestID = ? 
                                    ORDER BY p.ProblemNumber";
                    $problem_stmt = $conn->prepare($problem_sql);
                    $problem_stmt->bind_param("i", $contest_id);
                    $problem_stmt->execute();
                    $problem_result = $problem_stmt->get_result();

                    // Create an array to store problem numbers and IDs
                    $problems = [];
                    while ($problem = $problem_result->fetch_assoc()) {
                        $problems[$problem['ProblemID']] = $problem['ProblemNumber'];
                        echo "<th class='problem-cell'><a href=".'problemPage.php?id='.$problem['ProblemID'].">{$problem['ProblemNumber']}</a></th>";
                    }
                    $problem_stmt->close();
                    ?>
                </tr>
            </thead>
            <tbody>
            <?php
            // Fetch overall rankings
            $sql = "SELECT u.Handle, cr.problems_solved, cr.total_penalty, cr.rank
                    FROM contest_rankings cr
                    JOIN users u ON cr.UserID = u.UserID
                    WHERE cr.ContestID = ?
                    ORDER BY cr.rank ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $contest_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $rank = 1;

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['rank']}</td>
                        <td>{$row['Handle']}</td>
                        <td>{$row['problems_solved']}</td>
                        <td>{$row['total_penalty']}</td>";
                
                // Fetch submission details for each problem
                $problem_sql = "SELECT ProblemID, Status, attempts, 
                                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(SubmissionTime, c.StartTime))) as time_taken
                                FROM contest_submissions cs
                                JOIN contests c ON cs.ContestID = c.ContestID
                                WHERE cs.ContestID = ? AND cs.UserID = (SELECT UserID FROM users WHERE Handle = ?)
                                ORDER BY ProblemID";
                $problem_stmt = $conn->prepare($problem_sql);
                $problem_stmt->bind_param("is", $contest_id, $row['Handle']);
                $problem_stmt->execute();
                $problem_result = $problem_stmt->get_result();
                
                $submissions = [];
                while ($sub = $problem_result->fetch_assoc()) {
                    $submissions[$sub['ProblemID']] = $sub;
                }
                
                foreach ($problems as $problemId => $problemNumber) {
                    if (isset($submissions[$problemId])) {
                        $sub = $submissions[$problemId];
                        $time_taken = "<span style='color: blue; font-size: smaller;'>{$sub['time_taken']}</span>";
                        
                        if ($sub['Status'] == 'Accepted' && $sub['attempts'] == 1) {
                            echo "<td class='accepted'>+<br>{$time_taken}</td>";
                        } else if ($sub['Status'] == 'Accepted') {
                            echo "<td class='accepted'>+".($sub['attempts']-1)."<br>{$time_taken}</td>";
                        } elseif ($sub['attempts'] > 0) {
                            echo "<td class='attempted'>-{$sub['attempts']}</td>";
                        } else {
                            echo "<td class='unattempted'>.</td>";
                        }
                    } else {
                        echo "<td class='unattempted'>.</td>";
                    }
                }     
                echo "</tr>";
                $rank++;
            }
            $stmt->close();
            ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>