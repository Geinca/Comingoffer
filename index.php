<?php
require_once 'config/db.php';

$shops = $conn->query("SELECT * FROM shops");
$categoryQuery = $conn->query("SELECT DISTINCT category_id, category_name FROM categories ORDER BY category_name ASC");
$cityQuery = $conn->query("SELECT DISTINCT city FROM shops WHERE city IS NOT NULL AND city != '' ORDER BY city ASC");

$iconMap = [
  'Grocery' => 'fa-shopping-basket',
  'Restaurant' => 'fa-utensils',
  'Electronics' => 'fa-tv',
  'Clothing' => 'fa-tshirt',
  'Pharmacy' => 'fa-prescription-bottle-alt',
  'Salon' => 'fa-cut',
  'Bakery' => 'fa-bread-slice',
  'Stationery' => 'fa-pencil-alt',
  'Other' => 'fa-store'
];

?>

<!DOCTYPE html>
<html>

<head>
  <title>Discover Our Shops</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/header.css">
  <style>
    

    

    .badge {
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Animation classes */
    .animate-in {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s ease;
    }

    .animate-in.show {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body>

  <!-- header -->
  <?php include('./includes/header.php') ?>

  <!-- slider -->
  <div class="slider-container">
    <div class="slider" id="slider">
      <div class="slide"><img class="img-fluid" src="https://media.istockphoto.com/id/155443388/photo/dairy-discount-in-grocery-store.jpg?s=612x612&w=0&k=20&c=zpSo5vC7jQHzsJju0Y48E-a5TQItSRDJbz4vF7WuCWc=" alt="Slide 1"></div>
      <div class="slide"><img class="img-fluid" src="https://www.pngitem.com/pimgs/m/241-2413626_grocery-transparent-images-png-grocery-png-png-download.png" alt="Slide 2"></div>
      <div class="slide"><img class="img-fluid" src="https://www.shutterstock.com/image-vector/mega-sale-advertiving-banner-3d-260nw-2000590271.jpg" alt="Slide 3"></div>
    </div>
    <button class="nav prev" onclick="prevSlide()">❮</button>
    <button class="nav next" onclick="nextSlide()">❯</button>
  </div>

  <div class="container-fluid mt-3">
    <div class="row">

      <!-- Category Sidebar -->
      <div class="col-lg-3 col-md-4 mb-4 category">
        <div class="card shadow-sm" style="background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%); color: white; border: none;">
          <div class="card-body">
            <h5 class="card-title mb-3" style="color: #ffffff;">Categories</h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item category-filter" data-category="all"
                style="cursor:pointer; background-color: transparent; color: #fff; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-th-large me-2"></i> Show All
              </li>
              <?php
              $catQuery = "SELECT DISTINCT category_name FROM categories ORDER BY category_name ASC";
              $result = $conn->query($catQuery);
              while ($cat = $result->fetch_assoc()):
                $catName = $cat['category_name'];
                $icon = isset($iconMap[$catName]) ? $iconMap[$catName] : 'fa-tags';
              ?>
                <li class="list-group-item category-filter"
                  style="cursor:pointer; background-color: transparent; color: #fff; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                  <i class="fas <?= $icon ?> me-2"></i> <?= htmlspecialchars($catName) ?>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- shop card -->
      <div class="col-lg-9 col-md-8">
        <div id="shopContainer">
          <?php if ($shops->num_rows > 0): ?>
            <div class="row g-4">
              <?php while ($shop = $shops->fetch_assoc()): ?>
                <?php
                $categoryQuery = "SELECT category_name FROM categories WHERE shop_id = ?";
                $categoryStmt = $conn->prepare($categoryQuery);
                $categoryStmt->bind_param("i", $shop['shop_id']);
                $categoryStmt->execute();
                $categories = $categoryStmt->get_result();

                $categoryNames = [];
                while ($category = $categories->fetch_assoc()) {
                  $categoryNames[] = $category['category_name'];
                }
                $categoryString = implode(",", $categoryNames);
                $categoryStmt->close();
                ?>
                <div class="col-lg-4 col-md-6 mb-4 shop-col" data-city="<?= htmlspecialchars($shop['city']) ?>" data-categories="<?= htmlspecialchars($categoryString) ?>">
                  <div class="card shop-card h-100 animate-in" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                    <!-- Shop Image with Hover Effect -->
                    <div class="shop-image-container" style="position: relative; overflow: hidden;">
                      <?php if (!empty($shop['image']) || file_exists($shop['image'])): ?>
                        <img src="dashboard/<?= htmlspecialchars($shop['image']) ?>" alt="<?= htmlspecialchars($shop['shop_name']) ?>"
                          class="card-img-top" style="height: 220px; object-fit: cover; transition: transform 0.5s ease;">
                      <?php else: ?>
                        <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center"
                          style="background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%); color: white; font-size: 3rem; height: 220px;">
                          <i class="fas fa-store"></i>
                        </div>
                      <?php endif; ?>
                      <div class="shop-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%); height: 50%;"></div>
                      <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3" style="box-shadow: 0 2px 5px rgba(0,0,0,0.2);">15% OFF</span>
                    </div>

                    <div class="card-body position-relative" style="z-index: 1;">
                      <!-- Shop Status Ribbon -->
                      <div class="position-absolute top-0 start-0 translate-middle-y" style="margin-top: -20px;">
                        <span class="badge bg-success px-3 py-2" style="border-radius: 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                          <i class="fas fa-door-open me-1"></i> Open Now
                        </span>
                      </div>

                      <div class="d-flex justify-content-between align-items-start mb-3" style="margin-top: 10px;">
                        <h5 class="card-title fw-bold" style="color: #333; font-size: 1.25rem;"><?= htmlspecialchars($shop['shop_name']) ?></h5>
                        <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 30px; height: 30px;">
                          <i class="far fa-heart"></i>
                        </button>
                      </div>

                      <!-- Rating with Progress Bar -->
                      <div class="rating mb-3 d-flex align-items-center">
                        <div class="stars me-2" style="color: #FFD700;">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="progress flex-grow-1" style="height: 6px; background-color: #f0f0f0;">
                          <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                        </div>
                        <span class="text-muted ms-2 small">(24 reviews)</span>
                      </div>

                      <!-- Location with Distance -->
                      <div class="d-flex align-items-center mb-3">
                        <div class="location-icon me-2" style="color: #6e48aa; font-size: 1.1rem;">
                          <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                          <p class="card-text mb-0" style="color: #555; font-size: 0.9rem;">
                            <?= htmlspecialchars($shop['address']) ?>, <?= htmlspecialchars($shop['city']) ?>
                          </p>
                          <p class="text-muted mb-0 small"><?= htmlspecialchars($shop['pincode']) ?> • <span class="text-primary">2.5km away</span></p>
                        </div>
                      </div>

                      <!-- Categories Tags -->
                      <div class="mb-3">
                        <?php
                        // Fetch categories for this specific shop
                        $categoryQuery = "SELECT category_name FROM categories WHERE shop_id = ?";
                        $categoryStmt = $conn->prepare($categoryQuery);
                        $categoryStmt->bind_param("i", $shop['shop_id']);
                        $categoryStmt->execute();
                        $categories = $categoryStmt->get_result();

                        // Display each category as a badge
                        while ($category = $categories->fetch_assoc()) {
                          echo '<span class="badge bg-light text-dark me-1 mb-1" style="font-weight: normal;">'
                            . htmlspecialchars($category['category_name'])
                            . '</span>';
                        }

                        // Close the statement
                        $categoryStmt->close();
                        ?>
                      </div>

                      <!-- CTA Button -->
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="shop_details.php?id=<?= $shop['shop_id'] ?>"
                          class="btn btn-primary btn-sm px-4 py-2"
                          style="border-radius: 50px; background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%); border: none;">
                          View Offers <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <small class="text-muted">
                          <i class="fas fa-clock me-1"></i> Closes at 9 PM
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php else: ?>
            <div class="no-shops text-center py-5 animate-in">
              <div class="empty-state-icon mb-4" style="width: 120px; height: 120px; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-store-slash" style="font-size: 3rem; color: #9d50bb;"></i>
              </div>
              <h3 class="mb-3" style="color: #333;">No Shops Available in Your Area</h3>
              <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">We couldn't find any shops nearby. Try changing your location or check back later for new additions.</p>
              <button class="btn btn-outline-primary px-4 py-2" style="border-radius: 50px;">
                <i class="fas fa-sync-alt me-2"></i> Refresh
              </button>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <?php include('./includes/footer.php') ?>

  <!-- Font Awesome (CDN for icons) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/main.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const categoryItems = document.querySelectorAll('.category-filter');
      const shopCards = document.querySelectorAll('.shop-col');

      categoryItems.forEach(item => {
        item.addEventListener('click', function() {
          // Remove active from all and add to current
          categoryItems.forEach(el => el.classList.remove('active'));
          this.classList.add('active');

          const selectedCategory = this.textContent.trim().toLowerCase();

          shopCards.forEach(card => {
            const categories = card.getAttribute('data-categories').toLowerCase();

            if (selectedCategory === 'show all' || selectedCategory === 'all') {
              card.style.display = 'block';
            } else {
              if (categories.includes(selectedCategory)) {
                card.style.display = 'block';
              } else {
                card.style.display = 'none';
              }
            }
          });
        });
      });
    });
  </script>
</body>

</html>