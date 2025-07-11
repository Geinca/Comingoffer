<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$offer = $conn->query("SELECT * FROM offers WHERE offer_id = $id")->fetch_assoc();
$shops = $conn->query("SELECT * FROM shops WHERE owner_id = $user_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $shop_id = $_POST['shop_id'];
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $discount = $_POST['discount_percent'];
  $start = $_POST['start_date'];
  $end = $_POST['end_date'];

  $image = $offer['image_path']; // Default to existing image

  if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/offers/";
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0755, true);
    }

    $filename = time() . '_' . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $filename;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($fileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $image = $filename;
      }
    }
  }

  // Update with image field
  $stmt = $conn->prepare("UPDATE offers SET shop_id=?, title=?, description=?, discount_percent=?, start_date=?, end_date=?, image_path=? WHERE offer_id=?");
  $stmt->bind_param("ississsi", $shop_id, $title, $desc, $discount, $start, $end, $image, $id);
  $stmt->execute();

  header("Location: offers.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Offer</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/edit_offer.css">
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="edit-header text-center">
      <h3><i class="fas fa-edit me-2"></i> Edit Offer: <?= htmlspecialchars($offer['title']) ?></h3>
    </div>

    <div class="edit-container">
      <div class="offer-icon">
        <i class="fas fa-percentage"></i>
      </div>

      <?php
      // Determine offer status
      $current_date = date('Y-m-d');
      $status = '';
      if ($current_date < $offer['start_date']) {
        $status = 'upcoming';
      } elseif ($current_date > $offer['end_date']) {
        $status = 'expired';
      } else {
        $status = 'active';
      }
      ?>
      <div class="text-center">
        <span class="status-badge status-<?= $status ?>">
          <i class="fas <?=
                        $status == 'active' ? 'fa-bolt' : ($status == 'expired' ? 'fa-clock' : 'fa-calendar-plus')
                        ?> me-1"></i>
          <?= ucfirst($status) ?>
        </span>
      </div>

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="shop_id" class="form-label">Shop</label>
          <div class="input-group-icon">
            <i class="fas fa-store"></i>
            <select name="shop_id" id="shop_id" class="form-select" required>
              <?php while ($shop = $shops->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($shop['shop_id']) ?>"
                  <?= ($shop['shop_id'] == $offer['shop_id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($shop['shop_name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div class="mb-4">
          <label for="title" class="form-label">Offer Title</label>
          <div class="input-group-icon">
            <i class="fas fa-heading"></i>
            <input type="text" name="title" id="title" class="form-control"
              value="<?= htmlspecialchars($offer['title']) ?>" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="image" class="form-label">Offer Image</label>
          <div class="input-group-icon">
            <i class="fas fa-image"></i>
            <input type="file" name="image" id="image" class="form-control">
          </div>
          <?php if (!empty($offer['image_path'])): ?>
            <small class="text-muted">Current Image: <?= htmlspecialchars($offer['image_path']) ?></small>
          <?php endif; ?>
        </div>


        <div class="mb-4">
          <label for="description" class="form-label">Description</label>
          <div class="input-group-icon">
            <i class="fas fa-align-left"></i>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($offer['description']) ?></textarea>
          </div>
        </div>

        <div class="mb-4">
          <label for="discount_percent" class="form-label">Discount Percentage</label>
          <div class="input-group-icon" style="position: relative;">
            <i class="fas fa-percent"></i>
            <input type="number" name="discount_percent" id="discount_percent" class="form-control"
              value="<?= htmlspecialchars($offer['discount_percent']) ?>" min="1" max="100" required>
            <span class="discount-badge">% OFF</span>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Offer Period</label>
          <div class="date-row">
            <div class="date-col">
              <label for="start_date" class="form-label">Start Date</label>
              <div class="input-group-icon">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="start_date" id="start_date" class="form-control"
                  value="<?= htmlspecialchars($offer['start_date']) ?>" required>
              </div>
            </div>
            <div class="date-col">
              <label for="end_date" class="form-label">End Date</label>
              <div class="input-group-icon">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="end_date" id="end_date" class="form-control"
                  value="<?= htmlspecialchars($offer['end_date']) ?>" required>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
          <a href="offers.php" class="btn btn-secondary btn-cancel">
            <i class="fas fa-times me-2"></i> Cancel
          </a>
          <button type="submit" class="btn btn-update">
            <i class="fas fa-save me-2"></i> Update Offer
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script>
    // Set minimum end date to be same as start date
    document.getElementById('start_date').addEventListener('change', function() {
      document.getElementById('end_date').min = this.value;
    });

    // Initialize the min date for end date based on current start date
    document.getElementById('end_date').min = document.getElementById('start_date').value;
  </script>
</body>

</html>