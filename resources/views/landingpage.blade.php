<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f7fb;
        }
        .hero {
            background: url('https://plus.unsplash.com/premium_photo-1681433396703-04f3879c9831?q=80&w=2104&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .features .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .features .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        footer {
            background: #343a40;
            color: #fff;
            padding: 40px 0;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero d-flex align-items-center justify-content-center">
        <div class="hero-content container text-center">
            <h1 class="display-4 fw-bold">Simplify Your Inventory Management</h1>
            <p class="lead mb-4">Track products, manage sales & purchases, and optimize your stock effortlessly.</p>
            <a href="#features" class="btn btn-primary btn-lg me-2">Explore Features</a>
            <a href="/login" class="btn btn-outline-light btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features py-5">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-box-seam display-4 text-primary"></i>
                        </div>
                        <h5 class="card-title">Product Management</h5>
                        <p class="card-text">Add, update, and manage all your products in a single dashboard with ease.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-cart-check display-4 text-success"></i>
                        </div>
                        <h5 class="card-title">Sales & Purchase</h5>
                        <p class="card-text">Monitor sales and purchases in real-time and get detailed reports.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-bar-chart-line display-4 text-warning"></i>
                        </div>
                        <h5 class="card-title">Analytics & Reports</h5>
                        <p class="card-text">Visualize your inventory performance and make informed decisions quickly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="mb-4">Ready to streamline your inventory?</h2>
            <a href="/login" class="btn btn-light btn-lg">Get Started Now</a>
        </div>
    </section>


    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2025 Inventory Management System. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
