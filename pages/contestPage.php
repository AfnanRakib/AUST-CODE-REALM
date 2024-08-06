<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/contestPage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Contest Details - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <!-- Contest Details Section -->
    <div class="container mt-5">
        <h1 class="text-center mb-4" id="contestTitle">Contest Title</h1>
        
        <div id="contestClock" class="text-center mb-4"></div>
        
        <div class="row">
            <div class="col-md-8">
                <h3>Problems</h3>
                <ul id="problemList" class="list-group">
                    <!-- Problems will be dynamically inserted here -->
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Contest Details</h3>
                <p><strong>Start Time:</strong> <span id="startTime"></span></p>
                <p><strong>End Time:</strong> <span id="endTime"></span></p>
                <p><strong>Duration:</strong> <span id="duration"></span></p>
                <button class="btn btn-primary" id="rankingButton">View Rankings</button>
            </div>
        </div>
    </div>

    <?php include '../helpers/footer.php'; ?>
    
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        var contestId = new URLSearchParams(window.location.search).get('id');

        function fetchContestDetails() {
            $.ajax({
                url: '../helpers/fetchContestDetails.php',
                type: 'GET',
                data: { id: contestId },
                success: function(response) {
                    $('#contestTitle').text(response.title);
                    $('#startTime').text(response.startTime);
                    $('#endTime').text(response.endTime);
                    $('#duration').text(response.duration);
                    
                    var currentTime = new Date().getTime();
                    var startTime = new Date(response.startTime).getTime();
                    var endTime = new Date(response.endTime).getTime();
                    
                    if (currentTime < startTime) {
                        $('#contestClock').text('Contest starts in: ' + formatTime(startTime - currentTime));
                        setInterval(function() {
                            $('#contestClock').text('Contest starts in: ' + formatTime(startTime - new Date().getTime()));
                        }, 1000);
                    } else if (currentTime < endTime) {
                        $('#contestClock').text('Contest ends in: ' + formatTime(endTime - currentTime));
                        setInterval(function() {
                            $('#contestClock').text('Contest ends in: ' + formatTime(endTime - new Date().getTime()));
                        }, 1000);
                    } else {
                        $('#contestClock').text('Contest Finished');
                    }

                    $('#problemList').empty();
                    response.problems.forEach(function(problem) {
                        $('#problemList').append('<li class="list-group-item"><a href="problemPage.php?id=' + problem.ProblemID + '">' + problem.Name + '</a></li>');
                    });
                }
            });
        }

        function formatTime(ms) {
            var seconds = Math.floor((ms / 1000) % 60);
            var minutes = Math.floor((ms / (1000 * 60)) % 60);
            var hours = Math.floor((ms / (1000 * 60 * 60)) % 24);
            var days = Math.floor(ms / (1000 * 60 * 60 * 24));
            return days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        }

        fetchContestDetails();

        $('#rankingButton').on('click', function() {
            window.location.href = 'rankingPage.php?id=' + contestId;
        });
    });
    </script>
</body>
</html>

