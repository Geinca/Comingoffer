<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT c.*, s.shop_name FROM categories c 
          JOIN shops s ON c.shop_id = s.shop_id 
          WHERE s.owner_id = $user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .page-title {
            font-weight: 700;
            color: var(--dark-color);
            position: relative;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1rem;
            width: 50px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .add-category-btn {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .add-category-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .category-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            background: white;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .category-icon {
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .category-card-body {
            padding: 1.5rem;
        }
        
        .category-name {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
            font-size: 1.2rem;
            text-align: center;
        }
        
        .category-detail {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #6c757d;
            font-size: 0.9rem;
            justify-content: center;
        }
        
        .category-detail i {
            margin-right: 0.5rem;
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }
        
        .category-card-footer {
            background: white;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
        }
        
        .action-btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .edit-btn {
            background: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .edit-btn:hover {
            background: #e07c0c;
            transform: translateY(-2px);
        }
        
        .delete-btn {
            background: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .delete-btn:hover {
            background: #e5176b;
            transform: translateY(-2px);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        
        .empty-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .empty-text {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
    </style>
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
                    <h2 class="page-title">Your Categories</h2>
                    <a href="add_category.php" class="btn btn-primary add-category-btn">
                        <i class="fas fa-plus me-2"></i>Add Category
                    </a>
                </div>
                
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="category-card-body">
                                        <h3 class="category-name"><?= htmlspecialchars($row['category_name']) ?></h3>
                                        <div class="category-detail">
                                            <i class="fas fa-store"></i>
                                            <span><?= htmlspecialchars($row['shop_name']) ?></span>
                                        </div>
                                        <?php if (!empty($row['description'])): ?>
                                        <div class="category-detail">
                                            <i class="fas fa-align-left"></i>
                                            <span><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="category-card-footer">
                                        <a href="edit_category.php?id=<?= $row['category_id'] ?>" class="btn btn-warning text-white action-btn edit-btn">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="delete_category.php?id=<?= $row['category_id'] ?>" class="btn btn-danger action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this category? All products in this category will be moved to Uncategorized.')">
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
                                    <i class="fas fa-tags"></i>
                                </div>
                                <h4>No Categories Found</h4>
                                <p class="empty-text">You haven't created any categories yet. Start by adding your first category!</p>
                                <a href="add_category.php" class="btn btn-primary add-category-btn">
                                    <i class="fas fa-plus me-2"></i>Add Your First Category
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