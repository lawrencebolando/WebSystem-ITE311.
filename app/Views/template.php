<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Bootstrap Navigation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/40fbe012-9c83-4ad9-b2e2-93c499223e48.png" alt="Company logo - abstract blue and white geometric design" width="40" height="40" class="d-inline-block align-top me-2">
                BrandName
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Product 1</a></li>
                            <li><a class="dropdown-item" href="#">Product 2</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Premium Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-outline-primary me-2">Login</button>
                    <button class="btn btn-primary">Sign Up</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white d-flex align-items-center justify-content-center" style="min-height: 400px">
        <div class="container text-center">
            <h1 class="display-4">Welcome to Our Website</h1>
            <p class="lead">Modern design with responsive navigation</p>
            <button class="btn btn-light btn-lg mt-3">Get Started</button>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/ce1f4385-5953-4114-a06a-2ee94d1dbf26.png" alt="Modern abstract icon for responsive design feature" class="img-fluid mb-3">
                        <h5 class="card-title">Fully Responsive</h5>
                        <p class="card-text">Looks great on any device, from mobile to desktop.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/a6c42080-e39a-4181-8a7c-8bdc52c17a93.png" alt="Clean minimalist icon for mobile-friendly navigation" class="img-fluid mb-3">
                        <h5 class="card-title">Mobile Friendly</h5>
                        <p class="card-text">Optimized for touch interactions and small screens.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/36ceba1a-59c6-4029-a5a5-20797d957a14.png" alt="Lightning bolt icon representing fast performance" class="img-fluid mb-3">
                        <h5 class="card-title">Fast Loading</h5>
                        <p class="card-text">Minimal code for maximum performance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    =======
</body>
</html>