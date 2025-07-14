<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$shops = $conn->query("SELECT * FROM shops WHERE owner_id = $user_id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $shop_id = $_POST['shop_id'];
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $discount = $_POST['discount_percent'];
  $start = $_POST['start_date'];

  $end = date('Y-m-d', strtotime($start . ' +2 days'));

  // Handle image upload
  $image_path = '';
  if (isset($_FILES['offer_image']) && $_FILES['offer_image']['error'] == 0) {
    $target_dir = "uploads/offers/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0755, true);
    }

    $file_extension = pathinfo($_FILES['offer_image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $filename;

    // Check if image file is an actual image
    $check = getimagesize($_FILES['offer_image']['tmp_name']);
    if ($check !== false) {
      if (move_uploaded_file($_FILES['offer_image']['tmp_name'], $target_file)) {
        $image_path = $target_file;
      }
    }
  }

  $stmt = $conn->prepare(
    "INSERT INTO offers
         (shop_id, title, description, discount_percent, start_date, end_date, image_path)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
  );
  $stmt->bind_param("ississs", $shop_id, $title, $desc, $discount, $start, $end, $image_path);
  $stmt->execute();

  header("Location: offers.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Create New Offer</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/add_offer.css">
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <div class="container py-4">
    <div class="offer-header text-center">
      <h3><i class="fas fa-percentage me-2"></i> Create New Offer</h3>
    </div>

    <div class="offer-form">
      <div class="offer-icon">
        <i class="fas fa-gift"></i>
      </div>

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="shop_id" class="form-label">Shop</label>
          <div class="input-group-icon">
            <i class="fas fa-store"></i>
            <select name="shop_id" id="shop_id" class="form-select" required>
              <option value="">Select Shop</option>
              <?php while ($shop = $shops->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($shop['shop_id']) ?>">
                  <?= htmlspecialchars($shop['shop_name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <!-- New Image Upload Field -->
        <div class="mb-4">
          <label for="offer_image" class="form-label">Offer Image</label>
          <div class="input-group-icon">
            <i class="fas fa-image"></i>
            <input type="file" name="offer_image" id="offer_image" class="form-control" accept="image/*">
          </div>
          <small class="text-muted">Recommended size: 800x400px (Max 2MB)</small>
          <div id="imagePreview" class="mt-2" style="display: none;">
            <img id="previewImg" src="#" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 5px;">
          </div>
        </div>

        <div class="mb-4">
          <label for="title" class="form-label">Offer Title</label>
          <div class="input-group-icon">
            <i class="fas fa-heading"></i>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter offer title" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="description" class="form-label">Description</label>
          <div class="input-group-icon">
            <i class="fas fa-align-left"></i>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter offer details"></textarea>
          </div>
        </div>

        <div class="mb-4">
          <label for="discount_percent" class="form-label">Discount Percentage</label>
          <div class="input-group-icon" style="position: relative;">
            <i class="fas fa-percent"></i>
            <input type="number" name="discount_percent" id="discount_percent" class="form-control"
              placeholder="0" min="1" max="100" required>
            <span class="discount-badge">% OFF</span>
          </div>
        </div>

        <!-- Offer Period -->
        <div class="mb-4">
          <label class="form-label">Offer Period</label>
          <div class="date-row">
            <div class="date-col">
              <label for="start_date" class="form-label">Start Date</label>
              <div class="input-group-icon">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="start_date" id="start_date"
                  class="form-control" required>
              </div>
            </div>
            <div class="date-col">
              <label for="end_date" class="form-label">End Date<br><small>(auto‑set)</small></label>
              <div class="input-group-icon">
                <i class="fas fa-calendar-alt"></i>
                <!-- readonly prevents typing, keeps the value visible -->
                <input type="date" name="end_date" id="end_date"
                  class="form-control" readonly>
              </div>
            </div>
          </div>
        </div>


        <div class="d-flex justify-content-center gap-3">
          <a href="offers.php" class="btn btn-secondary btn-cancel">
            <i class="fas fa-times me-2"></i> Cancel
          </a>
          <button type="submit" class="btn btn-save">
            <i class="fas fa-save me-2"></i> Create Offer
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script>
    /* --- JS right before </body> --- */

    // Today is the earliest allowed start date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').min = today;

    // When the user picks a start date, auto‑fill expiry (+2 days) and
    // make sure the form still shows a sensible default if they reload.
    function updateEndDate() {
      const startField = document.getElementById('start_date');
      const endField = document.getElementById('end_date');
      if (startField.value) {
        const d = new Date(startField.value);
        d.setDate(d.getDate() + 2); // add exactly 2 calendar days
        endField.value = d.toISOString().split('T')[0];
      } else {
        endField.value = '';
      }
    }

    document.getElementById('start_date').addEventListener('change', updateEndDate);
    updateEndDate(); // run once on page load


    // Image preview functionality
    document.getElementById('offer_image').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById('previewImg');
          preview.src = e.target.result;
          document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
      } else {
        document.getElementById('imagePreview').style.display = 'none';
      }
    });
  </script>
</body>

</html>