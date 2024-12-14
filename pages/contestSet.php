<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../images/logosm.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/contestSet.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Contests - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    
    <!-- Contest Section -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Contests</h1>
        <!-- Filter Options -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Search by contest name...">
            </div>
            <div class="col-md-6">
                <select id="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="running">Running</option>
                    <option value="past">Past</option>
                </select>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Contest</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be dynamically inserted here -->
            </tbody>
        </table>
        
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#" data-page="previous">Previous</a></li>
                <!-- Page numbers will be dynamically inserted here -->
                <li class="page-item"><a class="page-link" href="#" data-page="next">Next</a></li>
            </ul>
        </nav>
    </div>

    <?php include'../helpers/footer.php'?>
    
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script>
    $(document).ready(function(){
        var currentPage = 1;

        function fetchContests(page, search, status) {
            $.ajax({
                url: '../helpers/fetchContests.php',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    status: status
                },
                success: function(response) {
                    $('tbody').html(response.contests);
                    $('.pagination .page-item').not(':first,:last').remove(); // Remove existing page numbers
                    for (var i = 1; i <= response.totalPages; i++) {
                        $('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>').insertBefore('.pagination .page-item:last');
                    }
                    currentPage = page;
                }
            });
        }

        // Initial fetch
        fetchContests(currentPage, '', '');

        // Filter and pagination event handlers
        $('#search, #status').on('change', function() {
            fetchContests(1, $('#search').val(), $('#status').val());
        });

        $('.pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page === 'previous' && currentPage > 1) {
                page = currentPage - 1;
            } else if (page === 'next') {
                page = currentPage + 1;
            }
            fetchContests(page, $('#search').val(), $('#status').val());
        });
    });
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
