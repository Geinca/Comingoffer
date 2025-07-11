<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch shops and categories
$shops = $conn->query("SELECT * FROM shops WHERE owner_id = $user_id");
$categories = $conn->query("SELECT * FROM categories WHERE shop_id IN (SELECT shop_id FROM shops WHERE owner_id = $user_id)");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $shop_id     = $_POST['shop_id'];
  $category_id = $_POST['category_id'];
  $name        = $_POST['product_name'];
  $desc        = $_POST['description'];
  $price       = $_POST['price'];

  $image = '';
  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/product_images/' . $image);
  }

  $stmt = $conn->prepare("INSERT INTO products (shop_id, category_id, product_name, description, price, image) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("iissds", $shop_id, $category_id, $name, $desc, $price, $image);
  $stmt->execute();

  header("Location: products.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add New Product</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4895ef;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --success-color: #4cc9f0;
    }
    
    body {
      background-color: #f5f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .product-header {
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(0,0,0,0.1);
      position: relative;
    }
    
    .product-header:after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -1px;
      width: 50px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .product-form {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      padding: 2rem;
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
    
    .btn-save {
      background-color: var(--primary-color);
      border: none;
      padding: 0.75rem 1.5rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .btn-save:hover {
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
    
    .image-upload {
      border: 2px dashed #e2e8f0;
      border-radius: 8px;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 1.5rem;
    }
    
    .image-upload:hover {
      border-color: var(--primary-color);
      background: rgba(67, 97, 238, 0.05);
    }
    
    .image-upload i {
      font-size: 2rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }
    
    .image-preview {
      display: none;
      max-width: 200px;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1px solid #e2e8f0;
    }
  </style>
</head>

<body>
  <?php include '../includes/navbar.php'; ?>
  
  <div class="container py-4">
    <div class="product-header">
      <h3><i class="fas fa-plus-circle me-2"></i> Add New Product</h3>
    </div>
    
    <div class="product-form">
      <form method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="shop_id" class="form-label">Shop</label>
            <div class="input-group-icon">
              <i class="fas fa-store"></i>
              <select name="shop_id" id="shop_id" class="form-select" required>
                <option value="">Select Shop</option>
                <?php while ($s = $shops->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($s['shop_id']) ?>"><?= htmlspecialchars($s['shop_name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          
          <div class="col-md-6 mb-4">
            <label for="category_id" class="form-label">Category (Optional)</label>
            <div class="input-group-icon">
              <i class="fas fa-tag"></i>
              <select name="category_id" id="category_id" class="form-select">
                <option value="">Select Category</option>
                <?php while ($c = $categories->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($c['category_id']) ?>"><?= htmlspecialchars($c['category_name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        
        <div class="mb-4">
          <label for="product_name" class="form-label">Product Name</label>
          <div class="input-group-icon">
            <i class="fas fa-cube"></i>
            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" required>
          </div>
        </div>
        
        <div class="mb-4">
          <label for="description" class="form-label">Description</label>
          <div class="input-group-icon">
            <i class="fas fa-align-left"></i>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="price" class="form-label">Price</label>
            <div class="input-group-icon">
              <i class="fas fa-rupee-sign"></i>
              <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="0.00" required>
            </div>
          </div>
        </div>
        
        <div class="mb-4">
          <label class="form-label">Product Image</label>
          <div class="image-upload" onclick="document.getElementById('image-input').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Click to upload product image</p>
            <img id="image-preview" class="image-preview" src="#" alt="Preview">
            <input type="file" name="image" id="image-input" class="d-none" accept="image/*" onchange="previewImage(this)">
          </div>
        </div>
        
        <div class="d-flex justify-content-end gap-3">
          <a href="products.php" class="btn btn-secondary btn-cancel">
            <i class="fas fa-times me-2"></i> Cancel
          </a>
          <button type="submit" class="btn btn-primary btn-save">
            <i class="fas fa-save me-2"></i> Save Product
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script>
    function previewImage(input) {
      const preview = document.getElementById('image-preview');
      const file = input.files[0];
      const reader = new FileReader();
      
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      
      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>
</body>

</html>