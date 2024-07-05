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
            <h2 style="color: rgb(3, 191, 98)">Available Courses</h2>
        </div>
        
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/DynamicPrograming.png" class="img-fluid" alt="Dynamic Programming"/>
                       
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Dynamic Programming</h5>
                        <p class="card-text">Learn dynamic programming techniques.</p>
                        <a href="DP.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Arrays 101.png" class="img-fluid" alt="Arrays 101"/>
                    
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Arrays 101</h5>
                        <p class="card-text">Master array manipulation and algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)" >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/SQL Language.png" class="img-fluid" alt="SQL Language">
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">SQL Language</h5>
                        <p class="card-text">Learn database querying with SQL.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Sorting.jfif" class="img-fluid" alt="Sorting"/>
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sorting</h5>
                        <p class="card-text">Explore various sorting algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/DynamicPrograming.png" class="img-fluid" alt="Dynamic Programming"/>
                       
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Dynamic Programming</h5>
                        <p class="card-text">Learn dynamic programming techniques.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Arrays 101.png" class="img-fluid" alt="Arrays 101"/>
                    
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Arrays 101</h5>
                        <p class="card-text">Master array manipulation and algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)" >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/SQL Language.png" class="img-fluid" alt="SQL Language">
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">SQL Language</h5>
                        <p class="card-text">Learn database querying with SQL.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Sorting.jfif" class="img-fluid" alt="Sorting"/>
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sorting</h5>
                        <p class="card-text">Explore various sorting algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/DynamicPrograming.png" class="img-fluid" alt="Dynamic Programming"/>
                       
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Dynamic Programming</h5>
                        <p class="card-text">Learn dynamic programming techniques.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Arrays 101.png" class="img-fluid" alt="Arrays 101"/>
                    
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Arrays 101</h5>
                        <p class="card-text">Master array manipulation and algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)" >Go to course</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/SQL Language.png" class="img-fluid" alt="SQL Language">
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">SQL Language</h5>
                        <p class="card-text">Learn database querying with SQL.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 course-card">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="../images/Sorting.jfif" class="img-fluid" alt="Sorting"/>
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sorting</h5>
                        <p class="card-text">Explore various sorting algorithms.</p>
                        <a href="#!" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)"  >Go to course</a>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">1</a></li>
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">2</a></li>
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">3</a></li>
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">4</a></li>
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">7</a></li>
                <li class="page-item"><a class="page-link" href="#"style="color: rgb(3, 191, 98)">Next</a></li>
            </ul>
        </nav>
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