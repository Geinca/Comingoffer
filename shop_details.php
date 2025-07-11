<?php
require_once 'config/db.php';

$shop_id = $_GET['id'] ?? 0;
$shop = $conn->query("SELECT * FROM shops WHERE shop_id = $shop_id")->fetch_assoc();

if (!$shop) {
    die("Shop not found.");
}

$offers = $conn->query("SELECT * FROM offers WHERE shop_id = $shop_id AND CURDATE() BETWEEN start_date AND end_date");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($shop['shop_name']) ?> - Offers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="./assets/css/main.css">
  <style>
    :root {
      --primary-color: #4e73df;
      --secondary-color: #f8f9fc;
      --accent-color: #ff6b6b;
      --dark-color: #2c3e50;
      --light-color: #f8f9fa;
    }
    
    body {
      background-color: var(--secondary-color);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .shop-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
      color: white;
      padding: 40px 0;
      border-radius: 0 0 20px 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .back-btn {
      background-color: white;
      color: var(--primary-color);
      border-radius: 50px;
      padding: 8px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-bottom: 20px;
      border: none;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .back-btn:hover {
      transform: translateX(-5px);
      background-color: var(--light-color);
    }
    
    .shop-info {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 30px;
      border-left: 5px solid var(--primary-color);
    }
    
    .shop-info h2 {
      color: var(--dark-color);
      font-weight: 700;
      margin-bottom: 15px;
    }
    
    .shop-info p {
      color: #555;
      margin-bottom: 8px;
    }
    
    .contact-icon {
      color: var(--primary-color);
      margin-right: 8px;
    }
    
    .section-title {
      color: var(--dark-color);
      font-weight: 700;
      margin-bottom: 25px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 60px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .offer-card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      height: 100%;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      margin-bottom: 25px;
    }
    
    .offer-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .offer-img-container {
      height: 220px;
      overflow: hidden;
      position: relative;
    }
    
    .offer-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .offer-card:hover .offer-img {
      transform: scale(1.1);
    }
    
    .no-image {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666;
    }
    
    .no-image i {
      opacity: 0.5;
    }
    
    .discount-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1rem;
      padding: 8px 15px;
      border-radius: 50px;
      background-color: var(--accent-color);
      color: white;
      font-weight: 700;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .card-body {
      padding: 25px;
    }
    
    .card-title {
      color: var(--dark-color);
      font-weight: 700;
      margin-bottom: 15px;
      font-size: 1.3rem;
    }
    
    .card-text {
      color: #555;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .offer-date {
      background-color: var(--light-color);
      padding: 10px 15px;
      border-radius: 8px;
      font-size: 0.85rem;
      color: #666;
    }
    
    .no-offers {
      background: white;
      border-radius: 15px;
      padding: 40px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .no-offers i {
      font-size: 3rem;
      color: #ddd;
      margin-bottom: 20px;
    }
    
    .no-offers h4 {
      color: #666;
      font-weight: 600;
    }
    
    .rating {
      color: #ffc107;
      margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
      .shop-header {
        padding: 30px 0;
      }
      
      .offer-img-container {
        height: 180px;
      }
    }
  </style>
</head>
<body>

<!-- Shop Header -->
<div class="shop-header animate__animated animate__fadeIn">
  <div class="container">
    <button onclick="window.history.back()" class="back-btn animate__animated animate__fadeInLeft">
      <i class="fas fa-arrow-left me-2"></i>Back to Shops
    </button>
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="display-5 fw-bold mb-3 animate__animated animate__fadeInDown"><?= htmlspecialchars($shop['shop_name']) ?></h1>
        <div class="d-flex align-items-center mb-2 animate__animated animate__fadeInUp">
          <i class="fas fa-map-marker-alt me-2"></i>
          <span><?= htmlspecialchars($shop['address']) ?>, <?= htmlspecialchars($shop['city']) ?> - <?= htmlspecialchars($shop['pincode']) ?></span>
        </div>
        <?php if (!empty($shop['contact_number'])): ?>
          <div class="d-flex align-items-center animate__animated animate__fadeInUp">
            <i class="fas fa-phone-alt me-2"></i>
            <span><?= htmlspecialchars($shop['contact_number']) ?></span>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-4 text-md-end animate__animated animate__fadeIn">
        <div class="rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <span class="ms-2">4.5</span>
        </div>
        <span class="badge bg-success py-2 px-3">
          <i class="fas fa-check-circle me-1"></i> Verified
        </span>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">

  <!-- Offers Section -->
  <div class="row">
    <div class="col-12">
      <h3 class="section-title animate__animated animate__fadeIn">
        <i class="fas fa-tags me-2"></i>Active Offers
      </h3>
    </div>
  </div>

  <?php if ($offers->num_rows > 0): ?>
    <div class="row animate__animated animate__fadeInUp">
      <?php while($offer = $offers->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card offer-card">
            <div class="offer-img-container <?= empty($offer['image_path']) ? 'no-image' : '' ?>">
              <?php if (!empty($offer['image_path'])): ?>
                <img src="dashboard/uploads/offers/<?= htmlspecialchars($offer['image_path']) ?>" alt="<?= htmlspecialchars($offer['title']) ?>" class="offer-img">
              <?php else: ?>
                <div class="p-3 text-center">
                  <i class="fas fa-image fa-4x mb-3"></i>
                  <p>No image available</p>
                </div>
              <?php endif; ?>
              <span class="discount-badge animate__animated animate__pulse animate__infinite"><?= $offer['discount_percent'] ?>% OFF</span>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($offer['title']) ?></h5>
              <p class="card-text"><?= nl2br(htmlspecialchars($offer['description'])) ?></p>
              <div class="offer-date">
                <i class="far fa-calendar-alt me-2"></i>
                <small>Valid from <strong><?= date('M d, Y', strtotime($offer['start_date'])) ?></strong> to <strong><?= date('M d, Y', strtotime($offer['end_date'])) ?></strong></small>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="no-offers animate__animated animate__fadeIn">
      <i class="far fa-frown-open"></i>
      <h4 class="mb-3">No active offers available</h4>
      <p class="text-muted">Check back later for exciting deals from this shop!</p>
      <button class="btn btn-primary mt-3" onclick="window.history.back()">
        <i class="fas fa-arrow-left me-2"></i>Back to Shops
      </button>
    </div>
  <?php endif; ?>
</div>

<!-- Footer -->
<?php include('./includes/footer.php') ?>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Animation on scroll -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const animateElements = document.querySelectorAll('.animate__animated');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add(entry.target.dataset.animate);
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1
    });
    
    animateElements.forEach(el => {
      observer.observe(el);
    });
  });
</script>
</body>
</html>