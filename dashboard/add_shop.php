<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $shop_name = $_POST['shop_name'];
  $address   = $_POST['address'];
  $city      = $_POST['city'];
  $state     = $_POST['state'];
  $pincode   = $_POST['pincode'];
  $latitude  = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $owner_id  = $_SESSION['user_id'];

  // Handle image upload
  $image_path = '';
  if (isset($_FILES['shop_image']) && $_FILES['shop_image']['error'] === UPLOAD_ERR_OK) {
    $image_name = basename($_FILES['shop_image']['name']);
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_name = uniqid('shop_', true) . '.' . $image_ext;
    $upload_dir = 'uploads/shops/';
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true); // create directory if not exists
    }
    $target_file = $upload_dir . $new_name;
    if (move_uploaded_file($_FILES['shop_image']['tmp_name'], $target_file)) {
      $image_path = 'uploads/shops/' . $new_name;
    }
  }

  // Save to database
  $stmt = $conn->prepare("INSERT INTO shops (owner_id, shop_name, address, city, state, pincode, latitude, longitude, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("issssidds", $owner_id, $shop_name, $address, $city, $state, $pincode, $latitude, $longitude, $image_path);
  $stmt->execute();

  header("Location: manage_shops.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add New Shop</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/add_shop.css">
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="page-header">
      <h3><i class="fas fa-store me-2"></i> Add New Shop</h3>
    </div>

    <div class="form-container">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="shop_name" class="form-label">Shop Name</label>
          <div class="input-group-icon">
            <i class="fas fa-signature"></i>
            <input type="text" name="shop_name" id="shop_name" class="form-control" placeholder="Enter shop name" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="address" class="form-label">Address</label>
          <div class="input-group-icon">
            <i class="fas fa-map-marker-alt"></i>
            <textarea name="address" id="address" class="form-control" placeholder="Enter full address" rows="3" required></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="city" class="form-label">City</label>
            <div class="input-group-icon">
              <i class="fas fa-city"></i>
              <input type="text" name="city" id="city" class="form-control" placeholder="Enter city" required>
            </div>
          </div>

          <div class="col-md-6 mb-4">
            <label for="state" class="form-label">State</label>
            <div class="input-group-icon">
              <i class="fas fa-flag"></i>
              <input type="text" name="state" id="state" class="form-control" placeholder="Enter state" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="pincode" class="form-label">Pincode</label>
            <div class="input-group-icon">
              <i class="fas fa-mail-bulk"></i>
              <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter pincode" required>
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label for="shop_image" class="form-label">Shop Image</label>
          <div class="input-group-icon">
            <i class="fas fa-image"></i>
            <input type="file" name="shop_image" id="shop_image" class="form-control" accept="image/*" required>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Location</label>
          <div class="map-container">
            <div class="map-placeholder">
              <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
              <p class="text-center">Map will appear here</p>
            </div>
            <button type="button" class="location-btn">
              <i class="fas fa-location-arrow"></i>
            </button>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Enter latitude">
            </div>
            <div class="col-md-6 mb-3">
              <label for="longitude" class="form-label">Longitude</label>
              <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Enter longitude">
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-3">
          <a href="manage_shops.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i> Save Shop
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>