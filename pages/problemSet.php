<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/problemSet.css">
    <title>Problem Set - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php';?>
    
    <!-- Problem Set Section -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Problem Set</h1>
        
        <!-- Filter Options -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Search by problem name...">
            </div>
            <div class="col-md-4">
                <input type="text" id="rating" class="form-control" placeholder="Search by problem rating...">
            </div>
            <div class="col-md-4">
                <select id="tags" class="form-control">
                    <option value="">All Tags</option>
                    <?php
                    // Fetch all tags from the database
                    include '../helpers/config.php';
                    
                    $tagQuery = "SELECT * FROM tags";
                    $tagResult = $conn->query($tagQuery);
                    while ($tagRow = $tagResult->fetch_assoc()) {
                        echo '<option value="' . $tagRow['TagID'] . '">' . $tagRow['TagName'] . '</option>';
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Problem</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Tags</th>
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

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script>
    $(document).ready(function(){
        var currentPage = 1;

        function fetchProblems(page, search, rating, tags) {
            $.ajax({
                url: '../helpers/fetchProblems.php',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    rating: rating,
                    tags: tags
                },
                success: function(response) {
                    $('tbody').html(response.problems);
                    $('.pagination .page-item').not(':first,:last').remove(); // Remove existing page numbers
                    for (var i = 1; i <= response.totalPages; i++) {
                        $('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>').insertBefore('.pagination .page-item:last');
                    }
                    currentPage = page;
                }
            });
        }

        // Initial fetch
        fetchProblems(currentPage, '', '', '');

        // Filter and pagination event handlers
        $('#search, #rating, #tags').on('change', function() {
            fetchProblems(1, $('#search').val(), $('#rating').val(), $('#tags').val());
        });

        $('.pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page === 'previous' && currentPage > 1) {
                page = currentPage - 1;
            } else if (page === 'next') {
                page = currentPage + 1;
            }
            fetchProblems(page, $('#search').val(), $('#rating').val(), $('#tags').val());
        });
    });
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
