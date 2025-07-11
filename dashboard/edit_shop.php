<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$shop_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM shops WHERE shop_id = $shop_id AND owner_id = $user_id");
$shop = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $shop_name = $_POST['shop_name'];
  $address   = $_POST['address'];
  $city      = $_POST['city'];
  $state     = $_POST['state'];
  $pincode   = $_POST['pincode'];
  $latitude  = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $image_path = $shop['image']; // existing image path

  // Check if new image is uploaded
  if (isset($_FILES['shop_image']) && $_FILES['shop_image']['error'] === UPLOAD_ERR_OK) {
    $image_name = basename($_FILES['shop_image']['name']);
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_name = uniqid('shop_', true) . '.' . $image_ext;
    $upload_dir = 'uploads/shops/';
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true);
    }
    $target_file = $upload_dir . $new_name;
    if (move_uploaded_file($_FILES['shop_image']['tmp_name'], $target_file)) {
      // Delete old image if exists
      if (!empty($shop['image']) && file_exists($shop['image'])) {
        unlink($shop['image']);
      }
      $image_path = $target_file;
    }
  }

  // Update shop data
  $stmt = $conn->prepare("UPDATE shops SET shop_name=?, address=?, city=?, state=?, pincode=?, latitude=?, longitude=?, image=? WHERE shop_id=? AND owner_id=?");
  $stmt->bind_param("sssssddssi", $shop_name, $address, $city, $state, $pincode, $latitude, $longitude, $image_path, $shop_id, $user_id);
  $stmt->execute();

  header("Location: manage_shops.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Shop</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/edit_shop.css">
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="edit-header">
      <h3><i class="fas fa-store me-2"></i> Edit Shop: <?= htmlspecialchars($shop['shop_name']) ?></h3>
    </div>

    <div class="edit-container">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="shop_name" class="form-label">Shop Name</label>
          <div class="input-group-icon">
            <i class="fas fa-signature"></i>
            <input type="text" name="shop_name" id="shop_name" class="form-control"
              value="<?= htmlspecialchars($shop['shop_name']) ?>" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="address" class="form-label">Address</label>
          <div class="input-group-icon">
            <i class="fas fa-map-marker-alt"></i>
            <textarea name="address" id="address" class="form-control"
              rows="3" required><?= htmlspecialchars($shop['address']) ?></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="city" class="form-label">City</label>
            <div class="input-group-icon">
              <i class="fas fa-city"></i>
              <input type="text" name="city" id="city" class="form-control"
                value="<?= htmlspecialchars($shop['city']) ?>" required>
            </div>
          </div>

          <div class="col-md-6 mb-4">
            <label for="state" class="form-label">State</label>
            <div class="input-group-icon">
              <i class="fas fa-flag"></i>
              <input type="text" name="state" id="state" class="form-control"
                value="<?= htmlspecialchars($shop['state']) ?>" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-4">
            <label for="pincode" class="form-label">Pincode</label>
            <div class="input-group-icon">
              <i class="fas fa-mail-bulk"></i>
              <input type="text" name="pincode" id="pincode" class="form-control"
                value="<?= htmlspecialchars($shop['pincode']) ?>" required>
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Shop Location</label>
          <div class="map-preview">
            <?php if ($shop['latitude'] && $shop['longitude']): ?>
              <div class="map-coordinates">
                <i class="fas fa-map-pin me-1"></i>
                <?= number_format($shop['latitude'], 6) ?>, <?= number_format($shop['longitude'], 6) ?>
              </div>
            <?php else: ?>
              <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                <p>No location coordinates set</p>
              </div>
            <?php endif; ?>
            <button type="button" class="location-btn" title="Update location">
              <i class="fas fa-location-arrow"></i>
            </button>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" name="latitude" id="latitude" class="form-control"
                value="<?= htmlspecialchars($shop['latitude']) ?>" placeholder="Enter latitude">
            </div>
            <div class="col-md-6 mb-3">
              <label for="longitude" class="form-label">Longitude</label>
              <input type="text" name="longitude" id="longitude" class="form-control"
                value="<?= htmlspecialchars($shop['longitude']) ?>" placeholder="Enter longitude">
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label for="shop_image" class="form-label">Shop Image</label>
          <?php if (!empty($shop['image'])): ?>
            <div class="mb-3">
              <img src="<?= htmlspecialchars($shop['image']) ?>" alt="Shop Image" style="max-width: 200px; border-radius: 8px;">
            </div>
          <?php endif; ?>
          <div class="input-group-icon">
            <i class="fas fa-image"></i>
            <input type="file" name="shop_image" id="shop_image" class="form-control" accept="image/*">
          </div>
        </div>


        <div class="d-flex justify-content-end gap-3">
          <a href="manage_shops.php" class="btn btn-cancel btn-secondary">
            <i class="fas fa-times me-2"></i> Cancel
          </a>
          <button type="submit" class="btn btn-update btn-primary">
            <i class="fas fa-save me-2"></i> Update Shop
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>