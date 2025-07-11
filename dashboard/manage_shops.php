<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM shops WHERE owner_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Shops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/manage_shops.css">
</head>

<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 p-0">
                <?php include '../includes/sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 p-4">
                <div class="page-header">
                    <h2 class="page-title">Your Shops</h2>
                    <a href="add_shop.php" class="btn btn-primary add-shop-btn">
                        <i class="fas fa-plus me-2"></i>Add Shop
                    </a>
                </div>

                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="shop-card">
                                    <div class="shop-card-header text-center">
                                        <?php if (!empty($row['image']) && file_exists($row['image'])): ?>
                                            <img src="<?= htmlspecialchars($row['image']) ?>" alt="Shop Image" class="rounded" style="height: 200px;">
                                        <?php else: ?>
                                            <div class="shop-icon">
                                                <i class="fas fa-store"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="shop-card-body">
                                        <h3 class="shop-name"><?= htmlspecialchars($row['shop_name']) ?></h3>
                                        <div class="shop-detail">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['state']) ?></span>
                                        </div>
                                        <div class="shop-detail">
                                            <i class="fas fa-phone"></i>
                                            <span><?= htmlspecialchars($row['phone'] ?? 'Not provided') ?></span>
                                        </div>
                                        <div class="shop-detail">
                                            <i class="fas fa-envelope"></i>
                                            <span><?= htmlspecialchars($row['email'] ?? 'Not provided') ?></span>
                                        </div>
                                    </div>
                                    <div class="shop-card-footer">
                                        <a href="edit_shop.php?id=<?= $row['shop_id'] ?>" class="btn btn-warning text-white action-btn edit-btn">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="delete_shop.php?id=<?= $row['shop_id'] ?>" class="btn btn-danger action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this shop?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-store-slash"></i>
                                </div>
                                <h4>No Shops Found</h4>
                                <p class="empty-text">You haven't added any shops yet. Get started by adding your first shop!</p>
                                <a href="add_shop.php" class="btn btn-primary add-shop-btn">
                                    <i class="fas fa-plus me-2"></i>Add Your First Shop
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>