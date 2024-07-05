<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/problemPage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>AUST CODE REALM</title>
    <style>
        .course-card {
            margin-bottom: 20px;
        }
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 255, 0, .2);
            overflow: hidden; 
        }
        .card:hover {
            background-color: rgba(0, 255, 0, 0.1); 
            box-shadow: 4px 4px 12px rgba(0, 255, 0, 0.4);
        }
        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .card-text {
            flex-grow: 1;
        }
        .card img {
            height: 200px; /* Adjust this value to your desired height */
            object-fit: cover;
        }
        .btn {
            margin-top: auto;
            overflow: hidden;
            color: white;
        }
        
        .btn:active {
            overflow: hidden;
            transform: none !important;
        }
        .bg-image {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .ripple {
            position: relative;
            overflow: hidden;
        }
        .ripple::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 0, 0.2);
            pointer-events: none;
            transition: opacity 0.3s;
            opacity: 0;
        }
        .ripple:hover::before {
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>

    <!--card-items-->
    <div class="container mt-4">
        <div class="green-header mb-4">
            <h2 style="color: rgb(3, 191, 98)">Dynamic Programing</h2>
        </div>
        <div class="row">  
            <div class="col-md-3 col-sm-6 goback">
                <a href="courses.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;"  >Go back to courses</a>
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"
                     src="https://www.youtube.com/embed/xeeo6nhq9IY?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="DYNAMIC PROGRAMMING ULTIMATE COURSE OVERVIEW | CP Course | EP 89" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">DYNAMIC PROGRAMMING ULTIMATE COURSE OVERVIEW</h5>
                        <p class="card-text">In video I discuss an overview of my full Upcoming Dynamic Programming Course.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%" 
                        src="https://www.youtube.com/embed/u7DdPBAJttU?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Introduction to Dynamic Programming | Tutorial | CP Course | EP 90" 
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Introduction to Dynamic Programming</h5>
                        <p class="card-text">In video I discuss what is dynamic programming, how I approach its problems, what is bottom up/top down approach, what is memoisation.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"  
                        src="https://www.youtube.com/embed/mnuBvHbMNJM?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Frog 1 &amp; 2: Atcoder 1D DP Questions | CP Course | EP 91" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Frog 1 & 2: Atcoder 1D DP Questions</h5>
                        <p class="card-text">n this video I discuss Frog1 and Frog2 questions in Educational DP series of Atcoder along with their proper explanations and code.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe  width="100%" height="100%"  
                        src="https://www.youtube.com/embed/mNrzyuus2h4?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Longest Increasing Subsequence (LIS) | Dynamic Programming | CP Course | EP 92" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Longest Increasing Subsequence (LIS)</h5>
                        <p class="card-text">In this video I discuss longest increasing subsequence problem of dynamic programming and also solve related leetcode question.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%" 
                        src="https://www.youtube.com/embed/PoTE56n_It8?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi"
                         title="Coin Change 1 &amp; 2 : Leetcode DP Questions | CP Course | EP 93" 
                         frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                       
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Coin Change 1 & 2 : Leetcode DP Questions</h5>
                        <p class="card-text">In this video I discuss longest Coin Change 1 and Coin Change 2 problems of Leetcode in detail along with their explanation and code.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"  
                        src="https://www.youtube.com/embed/o0NtrkItjws?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Knapsack Concept and Variations: Dynamic Programming | EP 94" 
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen>
                    </iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Knapsack Concept and Variations: Dynamic Programming </h5>
                        <p class="card-text">In this video I discuss the knapsack concept various questions related to it and what is general concept of thinking around them.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"  
                        src="https://www.youtube.com/embed/gHVtY5raAQg?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Knapsack 2 Atcoder Tutorial With Code: Dynamic Programming | CP Course| EP 96" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen>
                    </iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Knapsack 2 Atcoder Tutorial With Code: Dynamic Programming</h5>
                        <p class="card-text">In this video I discuss the Knapsack 2 problem of atcoder with proper explanation along with code.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%" 
                        src="https://www.youtube.com/embed/KnzlqtUDfIc?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="ROD CUTTING: Dynamic Programming | CP Course| EP 97" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">ROD CUTTING: Dynamic Programming</h5>
                        <p class="card-text">In this video I discuss the Rod cutting dynamic programming with proper explanation along with code. It is an example of unbounded knapsack .</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"
                        src="https://www.youtube.com/embed/G46kdLkQ_Sw?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="SUBSET SUM &amp; PARTITION PROBLEM : Dynamic Programming | CP Course| EP 98" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                       
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">SUBSET SUM & PARTITION PROBLEM : Dynamic Programming</h5>
                        <p class="card-text">In this video I discuss the how to find if sum is a subset sum in a given array and also Leetcode Partition Equal Subset Problem using dynamic programming with proper explanation along with code. It is an example of 0-1 knapsack.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    <iframe width="100%" height="100%"
                        src="https://www.youtube.com/embed/Q0o9sU1r0FY?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi" 
                        title="Longest Common Subsequence: Dynamic Programming | CP Course | EP 99" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Longest Common Subsequence: Dynamic Programming </h5>
                        <p class="card-text">In this video I discuss the Longest Common Subsequence .</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
    
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('[data-mdb-ripple-init]').forEach((element) => {
                new mdb.Ripple(element);
            });
        });

        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                setTimeout(() => {
                    this.blur();
                }, 100);
            });
        });
    </script>

</body>
</html>
