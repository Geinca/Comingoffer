<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$category = $conn->query("SELECT * FROM categories WHERE category_id = $id")->fetch_assoc();
$shops = $conn->query("SELECT * FROM shops WHERE owner_id = $user_id");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $shop_id = $_POST['shop_id'];
  $category_name = $_POST['category_name'];

  $stmt = $conn->prepare("UPDATE categories SET shop_id=?, category_name=? WHERE category_id=?");
  $stmt->bind_param("isi", $shop_id, $category_name, $id);
  $stmt->execute();

  header("Location: categories.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Category</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4895ef;
      --light-color: #f8f9fa;
      --dark-color: #212529;
    }
    
    body {
      background-color: #f5f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .edit-header {
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(0,0,0,0.1);
      position: relative;
    }
    
    .edit-header:after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -1px;
      width: 50px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .edit-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      padding: 2rem;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .form-label {
      font-weight: 600;
      color: var(--dark-color);
      margin-bottom: 0.5rem;
      display: block;
    }
    
    .form-control, .form-select {
      border-radius: 8px;
      padding: 0.75rem 1rem;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }
    
    .input-group-icon {
      position: relative;
    }
    
    .input-group-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #a0aec0;
      z-index: 10;
    }
    
    .input-group-icon .form-control, 
    .input-group-icon .form-select {
      padding-left: 45px;
    }
    
    .btn-update {
      background-color: var(--primary-color);
      border: none;
      padding: 0.75rem 1.5rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .btn-update:hover {
      background-color: var(--secondary-color);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }
    
    .btn-cancel {
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
      transform: translateY(-2px);
    }
    
    .category-icon {
      width: 80px;
      height: 80px;
      background: rgba(67, 97, 238, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      color: var(--primary-color);
      font-size: 2rem;
    }
  </style>
</head>

<body>
  <?php include '../includes/navbar.php'; ?>
  
  <div class="container py-4">
    <div class="edit-header text-center">
      <h3><i class="fas fa-edit me-2"></i> Edit Category: <?= htmlspecialchars($category['category_name']) ?></h3>
    </div>
    
    <div class="edit-container">
      <div class="category-icon">
        <i class="fas fa-tag"></i>
      </div>
      
      <form method="POST">
        <div class="mb-4">
          <label for="shop_id" class="form-label">Shop</label>
          <div class="input-group-icon">
            <i class="fas fa-store"></i>
            <select name="shop_id" id="shop_id" class="form-select" required>
              <?php while ($shop = $shops->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($shop['shop_id']) ?>" 
                  <?= $shop['shop_id'] == $category['shop_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($shop['shop_name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>
        
        <div class="mb-4">
          <label for="category_name" class="form-label">Category Name</label>
          <div class="input-group-icon">
            <i class="fas fa-tags"></i>
            <input type="text" name="category_name" id="category_name" class="form-control" 
                   value="<?= htmlspecialchars($category['category_name']) ?>" required>
          </div>
        </div>
        
        <div class="d-flex justify-content-center gap-3">
          <a href="categories.php" class="btn btn-secondary btn-cancel">
            <i class="fas fa-times me-2"></i> Cancel
          </a>
          <button type="submit" class="btn btn-primary btn-update">
            <i class="fas fa-save me-2"></i> Update Category
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>