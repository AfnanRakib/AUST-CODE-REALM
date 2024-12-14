<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="images/logosm.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include 'helpers/navbar.php'; ?>
    <!-- Hero Section -->
    <header class="hero-section text-center">
        <div class="container">
            <img src="images/hero.gif" class="hero-gif" alt="Placeholder Image">
            <h1>Welcome to AUST CODE REALM</h1>
            <p class="lead">A Platform for Aspiring Programmers</p>
        </div>
    </header>
    <!-- Carousel Section -->
    <section class="carousel-section py-5">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/compete.jpg" class="d-block w-100" alt="Placeholder Image 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Join Our Contests</h5>
                        <p>Compete with the best and improve your coding skills.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/access.jpg" class="d-block w-100" alt="Placeholder Image 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Learn New Skills</h5>
                        <p>Access a variety of courses and tutorials.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/connect.jpg" class="d-block w-100" alt="Placeholder Image 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Join Our Community</h5>
                        <p>Connect with fellow coders and share your knowledge.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!-- About Section -->
    <section class="about-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="images/logo.png" class="img-fluid" alt="Coding Doodle">
                </div>
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>At AUST CODE REALM, we believe in nurturing the coding talents of the next generation. Our platform provides a comprehensive suite of tools to help programmers of all levels improve their skills, compete in contests, and connect with a vibrant community.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Motivational Quotes Section -->
    <section class="quotes-section text-center py-5 bg-light">
        <div class="container">
            <h2>Motivational Quotes</h2>
            <p class="lead">"The only way to do great work is to love what you do." - Steve Jobs</p>
            <p class="lead">"Code is like humor. When you have to explain it, it’s bad." - Cory House</p>
            <p class="lead">"Programming isn't about what you know; it's about what you can figure out." - Chris Pine</p>
        </div>
    </section>
    <!-- Features and Community Section -->
    <section class="features-community-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="images/participate.jpg" class="img-fluid mb-3 feature-image" alt="Contests">
                    <h2>Contests</h2>
                    <p>Participate in programming contests and challenge yourself.</p>
                </div>
                <div class="col-md-4">
                    <img src="images/solve.jpg" class="img-fluid mb-3 feature-image" alt="Problems">
                    <h2>Problems</h2>
                    <p>Solve coding problems and improve your skills.</p>
                </div>
                <div class="col-md-4">
                    <img src="images/learn.jpg" class="img-fluid mb-3 feature-image" alt="Courses">
                    <h2>Courses</h2>
                    <p>Take courses to learn new programming languages and technologies.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="images/profile.jpg" class="img-fluid mb-3 feature-image" alt="Profile">
                    <h2>Profile</h2>
                    <p>Create a profile to track your progress and showcase your achievements.</p>
                </div>
                <div class="col-md-4">
                    <img src="images/discuss.jpg" class="img-fluid mb-3 feature-image" alt="Discuss">
                    <h2>Discuss</h2>
                    <p>Join the community and discuss coding challenges and solutions.</p>
                </div>
                <div class="col-md-4">
                    <img src="images/resource.jpg" class="img-fluid mb-3 feature-image" alt="Resources">
                    <h2>Resources</h2>
                    <p>Access a library of resources to help you on your coding journey.</p>
                </div>
            </div>
        </div>
    </section>
    <?php include'helpers/footer.php'?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
