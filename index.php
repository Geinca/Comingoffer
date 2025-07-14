<?php

$lang_code = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang_code;
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

$lang_file = "lang/{$lang_code}.php";
if (file_exists($lang_file)) {
  $L = include($lang_file);
} else {
  $L = include("lang/en.php"); // fallback to English
}

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

$catMap = [                       // English key → translations
  'Grocery'     => ['or' => 'କିରାଣା',      'kn' => 'ಸಂಕಿರಣ',      'en' => 'Grocery'],
  'Restaurant'  => ['or' => 'ଭୋଜନାଳୟ',    'kn' => 'ಭೋಜನಾಲಯ',    'en' => 'Restaurant'],
  'Electronics' => ['or' => 'ଇଲେକ୍‌ଟ୍ରୋନିକ୍ସ', 'kn' => 'ಎಲೆಕ್ಟ್ರಾನಿಕ್ಸ್', 'en' => 'Electronics'],
  'Clothing'    => ['or' => 'ପୋଶାକ',       'kn' => 'ಉಡುಪು',       'en' => 'Clothing'],
  'Pharmacy'    => ['or' => 'ଔଷଧ ଦୋକାନ',  'kn' => 'ಔಷಧ ಇಲಾಖೆ',  'en' => 'Pharmacy'],
  'Saloon'       => ['or' => 'ସାଲୁନ୍',      'kn' => 'ಸಲೂನ್',       'en' => 'Salon'],
  'Bakery'      => ['or' => 'ବେକାରୀ',      'kn' => 'ಬೇಕರಿ',      'en' => 'Bakery'],
  'Stationery'  => ['or' => 'ଷ୍ଟେସନେରୀ',   'kn' => 'ಸ್ಥಿರ ಉಸ್ತುವೆ', 'en' => 'Stationery'],
  'Other'       => ['or' => 'ଅନ୍ୟାନ୍ୟ',    'kn' => 'ಇತರೆ',      'en' => 'Other'],
];


?>

<!DOCTYPE html>
<html>

<head>
  <title><?= $L['title'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/header.css">
</head>

<body>

  <!-- header -->
  <?php include('./includes/header.php') ?>

  <!-- slider -->
  <div class="slider-container">
    <div class="slider" id="slider">
      <div class="slide"><img class="img-fluid" src="./assets/images/slider-1.png" alt="Slide 1"></div>
      <!-- <div class="slide"><img class="img-fluid" src="./assets/images/slider-2.png" alt="Slide 2"></div> -->
      <!-- <div class="slide"><img class="img-fluid" src="https://www.shutterstock.com/image-vector/mega-sale-advertiving-banner-3d-260nw-2000590271.jpg" alt="Slide 3"></div> -->
    </div>
    <button class="nav prev" onclick="prevSlide()">❮</button>
    <button class="nav next" onclick="nextSlide()">❯</button>
  </div>

  <div class="container-fluid mt-3">
    <div class="main-container d-lg-flex d-md-flex">

      <!-- Category Sidebar -->
      <div class="col-12 col-md-4 col-lg-3 mb-4 category">
        <div class="card shadow-sm" style="background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%); color: white; border: none;">
          <div class="card-body">
            <h5 class="card-title mb-3" style="color: #ffffff;"><?= $L['categories'] ?></h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item category-filter" data-category="all"
                style="cursor:pointer; background-color: transparent; color: #fff; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-th-large me-2"></i> <?= $L['show_all'] ?>
              </li>
              <?php
              $catQuery = "SELECT DISTINCT category_name FROM categories ORDER BY category_name ASC";
              $result   = $conn->query($catQuery);

              while ($cat = $result->fetch_assoc()):
                $englishName = $cat['category_name'];

                // NEW:  pick translation or fall back to English
                $catName = $catMap[$englishName][$lang] ?? $englishName;           // ← NEW

                $icon    = $iconMap[$englishName] ?? 'fa-tags';
              ?>
                <li class="list-group-item category-filter"
                  style="cursor:pointer; background-color: transparent; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1);">
                  <i class="fas <?= $icon ?> me-2"></i> <?= htmlspecialchars($catName) ?>
                </li>
              <?php endwhile; ?>

            </ul>
          </div>
        </div>
      </div>

      <!-- shop card -->
      <div class="col-sm-12 col-md-8 col-lg-9 shop">
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
                <div class="col-lg-4 col-md-6 col-12 mb-4 shop-col"
                  data-city="<?= htmlspecialchars($shop['city']) ?>"
                  data-categories="<?= htmlspecialchars($categoryString) ?>"
                  data-lat="<?= $shop['latitude'] ?>"
                  data-lng="<?= $shop['longitude'] ?>">
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
                          <i class="fas fa-door-open me-1"></i> <?= $L['open_now'] ?>
                        </span>
                      </div>

                      <div class="d-flex justify-content-between align-items-start mb-3" style="margin-top: 10px;">
                        <h5 class="card-title fw-bold" style="color: #333; font-size: 1.25rem;"><?= htmlspecialchars($shop['shop_name']) ?></h5>
                        <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 30px; height: 30px;">
                          <i class="far fa-heart"></i>
                        </button>
                      </div>

                      <!-- Rating with Progress Bar -->
                      <!-- <div class="rating mb-3 d-flex align-items-center">
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
                      </div> -->

                      <!-- Location with Distance -->
                      <div class="d-flex align-items-center mb-3">
                        <div class="location-icon me-2" style="color: #6e48aa; font-size: 1.1rem;">
                          <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                          <p class="card-text mb-0" style="color: #555; font-size: 0.9rem;">
                            <?= htmlspecialchars($shop['address']) ?>, <?= htmlspecialchars($shop['city']) ?>
                          </p>
                          <p class="text-muted mb-0 small"><?= htmlspecialchars($shop['pincode']) ?>
                        </div>
                      </div>

                      <!-- Categories Tags -->
                      <div class="mb-3">
                        <?php
                        // Fetch categories for this specific shop
                        $categoryQuery = "SELECT category_name FROM categories WHERE shop_id = ?";
                        $categoryStmt  = $conn->prepare($categoryQuery);
                        $categoryStmt->bind_param("i", $shop['shop_id']);
                        $categoryStmt->execute();
                        $categories = $categoryStmt->get_result();

                        while ($cat = $categories->fetch_assoc()) {
                          $english = $cat['category_name'];                       // value stored in DB
                          $display = $catMap[$english][$lang] ?? $english;       // ← NEW (Option 1)

                          echo '<span class="badge bg-light text-dark me-1 mb-1" style="font-weight: normal;">'
                            . htmlspecialchars($display)                        // translated text
                            . '</span>';
                        }
                        $categoryStmt->close();
                        ?>
                      </div>


                      <!-- CTA Button -->
                      <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="shop_details.php?id=<?= $shop['shop_id'] ?>"
                          class="btn btn-primary btn-sm px-4 py-2"
                          style="border-radius: 50px; background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%); border: none;">
                          <?= $L['view_offers'] ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <small class="text-muted">
                          <i class="fas fa-clock me-1"></i> <?= $L['closes_at'] ?>
                        </small>
                      </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="d-flex gap-2 justify-content-between">
                      <button type="button"
                        class="btn text-white btn-sm review-btn" style="background: linear-gradient(135deg, #ff5722, #ff9800);"
                        data-shop-id="<?= $shop['shop_id'] ?>"
                        data-bs-toggle="modal"
                        data-bs-target="#reviewModal">
                        <i class="fas fa-pen me-1"></i> Review
                      </button>

                      <button type="button"
                        class="btn btn-sm text-white share-btn" style="margin-left:30px;background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%)"
                        data-link="<?= htmlspecialchars(
                                      '/shop_details.php?id=' . $shop['shop_id']
                                    ) ?>">
                        <i class="fas fa-share-alt me-1"></i> Share
                      </button>
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
              <h3 class="mb-3" style="color: #333;"><?= $L['no_shops'] ?></h3>
              <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;"><?= $L['no_shops_msg'] ?></p>
              <button class="btn btn-outline-primary px-4 py-2" style="border-radius: 50px;">
                <i class="fas fa-sync-alt me-2"></i> <?= $L['refresh'] ?>
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

  <!-- Review modal (one global instance) -->
  <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" id="reviewForm">
        <div class="modal-header">
          <h5 class="modal-title">Leave a review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3 text-center" id="starWrapper">
            <!-- 5 stars rendered by JS -->
          </div>
          <div class="mb-3">
            <textarea class="form-control" name="comment" rows="3"
              placeholder="Write something nice…"></textarea>
          </div>
          <input type="hidden" name="shop_id" id="reviewShopId">
          <input type="hidden" name="rating" id="reviewRating" value="0">
        </div>

        <div class="modal-footer">
          <button class="btn btn-primary w-100" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // category wise filter
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

      /* ---------- REVIEW ---------- */

      // Turn ★★★★☆ into clickable stars
      const starWrapper = document.getElementById('starWrapper');
      for (let i = 1; i <= 5; i++) {
        const star = document.createElement('i');
        star.className = 'far fa-star fa-2x text-warning cursor-pointer mx-1';
        star.dataset.value = i;
        starWrapper.appendChild(star);
      }

      starWrapper.addEventListener('mouseover', e => {
        if (!e.target.dataset.value) return;
        highlightStars(e.target.dataset.value);
      });

      starWrapper.addEventListener('click', e => {
        if (!e.target.dataset.value) return;
        const val = e.target.dataset.value;
        document.getElementById('reviewRating').value = val;
        highlightStars(val);
      });

      starWrapper.addEventListener('mouseleave', () => {
        highlightStars(document.getElementById('reviewRating').value);
      });

      function highlightStars(count) {
        [...starWrapper.children].forEach(star => {
          star.classList.toggle('fas', star.dataset.value <= count);
          star.classList.toggle('far', star.dataset.value > count);
        });
      }

      // When a “Review” button is clicked, store its shop‑id
      document.querySelectorAll('.review-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.getElementById('reviewShopId').value = btn.dataset.shopId;
          document.getElementById('reviewRating').value = 0;
          highlightStars(0);
        });
      });

      // Submit via fetch (AJAX)
      const reviewForm = document.getElementById('reviewForm');
      const reviewModal = document.getElementById('reviewModal');

      reviewForm.addEventListener('submit', async e => {
        e.preventDefault();
        const fd = new FormData(e.target);

        try {
          const res = await fetch('handlers/review.php', {
            method: 'POST',
            body: fd
          });
          const json = await res.json();

          if (json.success) {
            bootstrap.Toast.getOrCreateInstance(showToast('Thanks for reviewing!'));
            alert('Thanks for reviewing!');

            /* ⬇️ 1) Clear the fields right away */
            reviewForm.reset(); // empties textarea & hidden inputs
            document.getElementById('reviewRating').value = 0;
            highlightStars(0); // turn stars back to outline

            bootstrap.Modal.getInstance(reviewModal).hide(); // close modal
            // (optional) refresh rating bar here via AJAX
          } else {
            throw Error(json.msg || 'Failed');
          }
        } catch (err) {
          alert('Could not save review: ' + err.message);
        }
      });

      /* ⬇️ 2) In case the user closes the modal manually, also reset then */
      reviewModal.addEventListener('hidden.bs.modal', () => {
        reviewForm.reset();
        document.getElementById('reviewRating').value = 0;
        highlightStars(0);
      });


      /* ---------- SHARE ---------- */

      document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
          const link = btn.dataset.link;

          try {
            if (navigator.share) {
              await navigator.share({
                url: link,
                title: 'Check out this shop!'
              });
            } else {
              await navigator.clipboard.writeText(link);
              bootstrap.Toast.getOrCreateInstance(showToast('Link copied!'));
            }
          } catch (_) {
            alert('Share cancelled or unsupported.');
          }
        });
      });

      /* ---------- Tiny toast helper ---------- */
      function showToast(msg) {
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-primary border-0 position-fixed bottom-0 end-0 m-3';
        toast.role = 'alert';
        toast.innerHTML = `<div class="d-flex">
                         <div class="toast-body">${msg}</div>
                         <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                       </div>`;
        document.body.appendChild(toast);
        return toast;
      }

      // === 0‑5 km location filter =========================
      // function getDistanceKm(lat1, lon1, lat2, lon2) {
      //   const R = 6371; // Earth radius in km
      //   const dLat = (lat2 - lat1) * Math.PI / 180;
      //   const dLon = (lon2 - lon1) * Math.PI / 180;
      //   const a = Math.sin(dLat / 2) ** 2 +
      //     Math.cos(lat1 * Math.PI / 180) *
      //     Math.cos(lat2 * Math.PI / 180) *
      //     Math.sin(dLon / 2) ** 2;
      //   return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      // }

      // window.addEventListener('load', () => {
      //   if (!navigator.geolocation) return; // unsupported browser

      //   navigator.geolocation.getCurrentPosition(pos => {
      //     const {
      //       latitude: userLat,
      //       longitude: userLng
      //     } = pos.coords;
      //     const radiusKm = 5;

      //     document.querySelectorAll('.shop-col').forEach(card => {
      //       const shopLat = +card.dataset.lat;
      //       const shopLng = +card.dataset.lng;
      //       const dist = getDistanceKm(userLat, userLng, shopLat, shopLng);

      //       // show/hide card
      //       card.style.display = dist <= radiusKm ? 'block' : 'none';

      //       // optional distance badge
      //       let badge = card.querySelector('.distance-badge');
      //       if (!badge) {
      //         badge = document.createElement('small');
      //         badge.className = 'text-muted distance-badge';
      //         card.querySelector('.card-body').appendChild(badge);
      //       }
      //       badge.textContent = `• ${dist.toFixed(1)} km away`;
      //       alert("Location fetched")
      //     });
      //   }, err => {
      //     console.warn('Geolocation denied', err);
      //     // do nothing; all shops remain visible
      //   }, {
      //     enableHighAccuracy: true,
      //     maximumAge: 600000
      //   });
      // });

    });
  </script>
</body>

</html>