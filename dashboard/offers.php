<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT o.*, s.shop_name FROM offers o 
          JOIN shops s ON o.shop_id = s.shop_id 
          WHERE s.owner_id = $user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Offers</title>
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
        
        .add-offer-btn {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .add-offer-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .offer-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .offer-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 1rem 1.5rem;
            position: relative;
        }
        
        .offer-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }
        
        .offer-shop {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .offer-badge {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(5px);
        }
        
        .offer-body {
            padding: 1.5rem;
            background: white;
        }
        
        .offer-detail {
            display: flex;
            margin-bottom: 0.75rem;
        }
        
        .offer-label {
            font-weight: 600;
            color: var(--dark-color);
            width: 100px;
        }
        
        .offer-value {
            color: #6c757d;
        }
        
        .offer-footer {
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
        
        .status-active {
            color: #38a169;
        }
        
        .status-expired {
            color: #e53e3e;
        }
        
        .status-upcoming {
            color: #d69e2e;
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
                    <h2 class="page-title">Your Offers</h2>
                    <a href="add_offer.php" class="btn btn-primary add-offer-btn">
                        <i class="fas fa-plus me-2"></i>Add Offer
                    </a>
                </div>
                
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): 
                            $current_date = date('Y-m-d');
                            $status = '';
                            if ($current_date < $row['start_date']) {
                                $status = 'upcoming';
                            } elseif ($current_date > $row['end_date']) {
                                $status = 'expired';
                            } else {
                                $status = 'active';
                            }
                        ?>
                            <div class="col-lg-6">
                                <div class="offer-card">
                                    <div class="offer-header">
                                        <div class="offer-title"><?= htmlspecialchars($row['title']) ?></div>
                                        <div class="offer-shop"><?= htmlspecialchars($row['shop_name']) ?></div>
                                        <span class="offer-badge">
                                            <?php if ($status == 'active'): ?>
                                                <i class="fas fa-bolt me-1"></i>Active
                                            <?php elseif ($status == 'expired'): ?>
                                                <i class="fas fa-clock me-1"></i>Expired
                                            <?php else: ?>
                                                <i class="fas fa-calendar-plus me-1"></i>Upcoming
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="offer-body">
                                        <div class="offer-detail">
                                            <span class="offer-label">Discount:</span>
                                            <span class="offer-value"><?= $row['discount_percent'] ?>% Off</span>
                                        </div>
                                        <div class="offer-detail">
                                            <span class="offer-label">Valid:</span>
                                            <span class="offer-value"><?= date('M d, Y', strtotime($row['start_date'])) ?> - <?= date('M d, Y', strtotime($row['end_date'])) ?></span>
                                        </div>
                                        <div class="offer-detail">
                                            <span class="offer-label">Status:</span>
                                            <span class="offer-value status-<?= $status ?>">
                                                <?= ucfirst($status) ?>
                                                <?php if ($status == 'active'): ?>
                                                    (<?= floor((strtotime($row['end_date']) - time()) / (60 * 60 * 24)) ?> days left)
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($row['description'])): ?>
                                        <div class="offer-detail">
                                            <span class="offer-label">Details:</span>
                                            <span class="offer-value"><?= htmlspecialchars($row['description']) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="offer-footer">
                                        <a href="edit_offer.php?id=<?= $row['offer_id'] ?>" class="btn btn-warning text-white action-btn edit-btn">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="delete_offer.php?id=<?= $row['offer_id'] ?>" class="btn btn-danger action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this offer?')">
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
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <h4>No Offers Found</h4>
                                <p class="empty-text">You haven't created any offers yet. Start by adding your first special offer!</p>
                                <a href="add_offer.php" class="btn btn-primary add-offer-btn">
                                    <i class="fas fa-plus me-2"></i>Add Your First Offer
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