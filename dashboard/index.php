<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_SESSION['subscription_shown'])) {
    $_SESSION['subscription_shown'] = true;
    $show_subscription_modal = true;
} else {
    $show_subscription_modal = false;
}


$user_id = $_SESSION['user_id'];

// Fetch stats
$total_shops = $conn->query("SELECT COUNT(*) AS count FROM shops WHERE owner_id = $user_id")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) AS count FROM products p JOIN shops s ON p.shop_id = s.shop_id WHERE s.owner_id = $user_id")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) AS count FROM categories c JOIN shops s ON c.shop_id = s.shop_id WHERE s.owner_id = $user_id")->fetch_assoc()['count'];
$total_offers = $conn->query("SELECT COUNT(*) AS count FROM offers o JOIN shops s ON o.shop_id = s.shop_id WHERE s.owner_id = $user_id")->fetch_assoc()['count'];

// Products per shop (for chart)
$shop_product_data = $conn->query("
    SELECT s.shop_name, COUNT(p.product_id) AS product_count 
    FROM shops s 
    LEFT JOIN products p ON s.shop_id = p.shop_id 
    WHERE s.owner_id = $user_id 
    GROUP BY s.shop_id
");

$labels = [];
$data = [];

while ($row = $shop_product_data->fetch_assoc()) {
    $labels[] = $row['shop_name'];
    $data[] = $row['product_count'];
}

$recent_activities = $conn->query("
    SELECT 'Product' AS type, p.product_name AS name, p.created_at 
    FROM products p
    JOIN shops s ON p.shop_id = s.shop_id
    WHERE s.owner_id = $user_id

    UNION ALL

    SELECT 'Shop' AS type, s.shop_name AS name, s.created_at 
    FROM shops s
    WHERE s.owner_id = $user_id

    UNION ALL

    SELECT 'Offer' AS type, o.title AS name, o.created_at 
    FROM offers o
    JOIN shops s ON o.shop_id = s.shop_id
    WHERE s.owner_id = $user_id

    UNION ALL

    SELECT 'Category' AS type, c.category_name AS name, c.created_at 
    FROM categories c
    JOIN shops s ON c.shop_id = s.shop_id
    WHERE s.owner_id = $user_id

    ORDER BY created_at DESC
    LIMIT 6
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Shop Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/shop_owner.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 p-0 sidebar">
                <?php include '../includes/sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <h2 class="welcome-header">Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? 'Shop Owner') ?>!</h2>
                <p class="text-muted mb-4">Here's what's happening with your business today</p>

                <!-- Summary Widgets -->
                <div class="row mb-4 g-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card summary-card shops h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Shops</h6>
                                        <h2 class="stat-number mb-0"><?= $total_shops ?></h2>
                                    </div>
                                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                                        <i class="fas fa-store fa-lg"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="shops.php" class="text-primary text-decoration-none small">
                                        View all shops <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card summary-card products h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Products</h6>
                                        <h2 class="stat-number mb-0"><?= $total_products ?></h2>
                                    </div>
                                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-circle p-3">
                                        <i class="fas fa-boxes fa-lg"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="products.php" class="text-success text-decoration-none small">
                                        Manage products <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card summary-card categories h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Categories</h6>
                                        <h2 class="stat-number mb-0"><?= $total_categories ?></h2>
                                    </div>
                                    <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                                        <i class="fas fa-tags fa-lg"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="categories.php" class="text-warning text-decoration-none small">
                                        Browse categories <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card summary-card offers h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Offers</h6>
                                        <h2 class="stat-number mb-0"><?= $total_offers ?></h2>
                                    </div>
                                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle p-3">
                                        <i class="fas fa-percentage fa-lg"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="offers.php" class="text-danger text-decoration-none small">
                                        View offers <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i> Products Distribution</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        This Month
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="chartDropdown">
                                        <li><a class="dropdown-item" href="#">This Week</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="shopChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-bell me-2 text-warning"></i> Recent Activity</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <?php while ($row = $recent_activities->fetch_assoc()): ?>
                                        <?php
                                        $icon = match ($row['type']) {
                                            'Product' => 'fa-box',
                                            'Shop' => 'fa-store',
                                            'Offer' => 'fa-percentage',
                                            'Category' => 'fa-tag',
                                            default => 'fa-info-circle',
                                        };
                                        $color = match ($row['type']) {
                                            'Product' => 'primary',
                                            'Shop' => 'success',
                                            'Offer' => 'warning',
                                            'Category' => 'info',
                                            default => 'secondary',
                                        };
                                        $timeAgo = date('M d, Y H:i', strtotime($row['created_at']));
                                        ?>
                                        <a href="#" class="list-group-item list-group-item-action border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> rounded-circle p-2 me-3">
                                                    <i class="fas <?= $icon ?>"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">New <?= htmlspecialchars($row['type']) ?>: <?= htmlspecialchars($row['name']) ?></h6>
                                                    <p class="mb-0 text-muted small"><?= $timeAgo ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Plan Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <!-- Ribbon for Popular Plan -->
            <div class="popular-tag position-absolute bg-warning text-dark fw-bold py-1 px-3 rounded-end" style="top: 20px; right: 0; z-index: 1; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                MOST POPULAR
            </div>
            
            <div class="modal-header bg-primary text-white position-relative">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%);"></div>
                <h5 class="modal-title" id="subscriptionModalLabel">
                    <i class="fas fa-crown me-2"></i> Choose Your Perfect Plan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 position-relative">
                <!-- Decorative elements -->
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background: radial-gradient(circle at center, var(--bs-primary) 0%, transparent 70%); z-index: -1;"></div>
                
                <div class="text-center mb-4">
                    <p class="text-muted mb-0">Select the plan that fits your needs</p>
                    <div class="d-flex justify-content-center mt-2">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active">Monthly</button>
                            <button type="button" class="btn btn-outline-secondary">Yearly (Save 20%)</button>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <!-- Basic Plan -->
                    <div class="col-md-4">
                        <div class="card h-100 border-primary border-2 shadow-sm hover-scale">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-4">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-star me-2"></i>Basic
                                    </h5>
                                    <p class="card-text text-muted">Perfect for getting started</p>
                                    <div class="py-2">
                                        <h4 class="fw-bold mb-0">₹199</h4>
                                        <small class="text-muted">per month</small>
                                    </div>
                                    <div class="py-2 bg-light rounded mb-3">
                                        <h6 class="fw-bold mb-0">₹1500</h6>
                                        <small class="text-muted">per year</small>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-start mb-4 flex-grow-1">
                                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>5 offers/month</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Basic support</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Email updates</li>
                                </ul>
                                <button class="btn btn-outline-primary w-100 mt-auto py-2">
                                    Get Started
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Medium Plan (Highlighted) -->
                    <div class="col-md-4">
                        <div class="card h-100 border-warning border-2 shadow-lg hover-scale" style="transform: translateY(-10px);">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-4">
                                    <h5 class="card-title text-warning">
                                        <i class="fas fa-gem me-2"></i>Medium
                                    </h5>
                                    <p class="card-text text-muted">Best for growing businesses</p>
                                    <div class="py-2">
                                        <h4 class="fw-bold mb-0">₹499</h4>
                                        <small class="text-muted">per month</small>
                                    </div>
                                    <div class="py-2 bg-light rounded mb-3">
                                        <h6 class="fw-bold mb-0">₹2500</h6>
                                        <small class="text-muted">per year</small>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-start mb-4 flex-grow-1">
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>8 offers/month</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Priority support</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Email + SMS updates</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Basic analytics</li>
                                </ul>
                                <button class="btn btn-warning w-100 mt-auto py-2 fw-bold">
                                    Popular Choice
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Plan -->
                    <div class="col-md-4">
                        <div class="card h-100 border-success border-2 shadow-sm hover-scale">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-4">
                                    <h5 class="card-title text-success">
                                        <i class="fas fa-rocket me-2"></i>Premium
                                    </h5>
                                    <p class="card-text text-muted">For maximum growth</p>
                                    <div class="py-2">
                                        <h4 class="fw-bold mb-0">₹999</h4>
                                        <small class="text-muted">per month</small>
                                    </div>
                                    <div class="py-2 bg-light rounded mb-3">
                                        <h6 class="fw-bold mb-0">₹3000</h6>
                                        <small class="text-muted">per year</small>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-start mb-4 flex-grow-1">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>15 offers/month</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>24/7 VIP support</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>All updates</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Advanced analytics</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Dedicated account manager</li>
                                </ul>
                                <button class="btn btn-success w-100 mt-auto py-2">
                                    Go Premium
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer justify-content-center bg-light">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="far fa-clock me-2"></i>Maybe Later
                </button>
                <p class="text-center mt-3 mb-0 small text-muted">
                    <i class="fas fa-lock me-1"></i> Secure payment. Cancel anytime.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale {
        transition: all 0.3s ease;
    }
    .hover-scale:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card {
        border-radius: 12px !important;
        overflow: hidden;
    }
</style>



    <?php if ($show_subscription_modal): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
                modal.show();
            });
        </script>
    <?php endif; ?>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('shopChart').getContext('2d');
        const shopChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Number of Products',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: '#4361ee',
                    borderColor: '#3a0ca3',
                    borderWidth: 1,
                    borderRadius: 6,
                    hoverBackgroundColor: '#3f37c9'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#2d3748',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#4a5568',
                        borderWidth: 1,
                        padding: 12,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' products';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            drawBorder: false,
                            color: "rgba(0, 0, 0, 0.05)"
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>