<!-- header -->
<header class="comingoffer-header">
  <nav class="navbar navbar-expand-lg navbar-dark py-2" style="background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%); box-shadow: 0 4px 18px rgba(0,0,0,0.1);">
    <div class="container">
      <a class="navbar-brand" href="index.php" style="font-weight: 800; font-size: 1.8rem; letter-spacing: -1px;">
        <span style="color: #fff;">Coming</span><span style="color: #ffdd59;">offer</span>
        <span class="badge bg-warning text-dark ms-2" style="font-size: 0.6rem; vertical-align: super; border-radius: 10px;">HOT DEALS</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" style="border-color: rgba(255,255,255,0.5);">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">


        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

          <li class="nav-item mx-lg-1">
            <a class="nav-link d-flex align-items-center" href="./index.php" style="font-weight: 500; padding: 8px 12px; border-radius: 50px; transition: all 0.3s;">
              <span>Home</span>
            </a>
          </li>

          <li class="nav-item mx-lg-1">
            <a class="nav-link d-flex align-items-center" href="./about.php" style="font-weight: 500; padding: 8px 12px; border-radius: 50px; transition: all 0.3s;">
              <span>About us</span>
            </a>
          </li>

          <li class="nav-item mx-lg-1">
            <a class="nav-link d-flex align-items-center" href="./contact.php" style="font-weight: 500; padding: 8px 12px; border-radius: 50px; transition: all 0.3s;">
              <span>Contact Us</span>
            </a>
          </li>

          <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
            <li class="nav-item dropdown mx-lg-1 me-2">
              <div class="location-selector dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer; font-weight: 500; padding: 8px 12px; border-radius: 50px; transition: all 0.3s;">
                <i class="fas fa-map-marker-alt me-1" style="color: #ffdd59;"></i>
                <span id="selectedCity"><?= isset($_GET['city']) ? htmlspecialchars($_GET['city']) : 'Select City' ?></span>
              </div>
              <ul class="dropdown-menu" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <?php if ($cityQuery->num_rows > 0): ?>
                  <?php while ($row = $cityQuery->fetch_assoc()): ?>
                    <li>
                      <a class="dropdown-item d-flex align-items-center py-2 city-filter" href="#" data-city="<?= htmlspecialchars($row['city']) ?>">
                        <i class="fas fa-city me-3" style="color: #6e48aa;"></i> <?= htmlspecialchars($row['city']) ?>
                      </a>
                    </li>
                  <?php endwhile; ?>
                <?php else: ?>
                  <li><span class="dropdown-item text-muted">No cities found</span></li>
                <?php endif; ?>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center py-2 city-filter" href="#" data-city="all">
                    <i class="fas fa-globe me-3" style="color: #6e48aa;"></i> Show All Cities
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>


          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item dropdown ms-lg-2">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="background-color: rgba(255,255,255,0.15); padding: 8px 15px; border-radius: 50px; transition: all 0.3s;">
                <div style="width: 30px; height: 30px; border-radius: 50%; background-color: #fff; color: #6e48aa; display: flex; align-items: center; justify-content: center; margin-right: 8px; font-weight: bold;"><?= substr($_SESSION['user_name'], 0, 1) ?></div>
                <span>My Account</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <li><a class="dropdown-item d-flex align-items-center py-2" href="#"><i class="fas fa-user me-3" style="color: #6e48aa; width: 20px; text-align: center;"></i> Profile</a></li>
                <li><a class="dropdown-item d-flex align-items-center py-2" href="#"><i class="fas fa-heart me-3" style="color: #6e48aa; width: 20px; text-align: center;"></i> Saved Offers <span class="badge bg-pink ms-auto">12</span></a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger d-flex align-items-center py-2" href="logout.php"><i class="fas fa-sign-out-alt me-3" style="width: 20px; text-align: center;"></i> Logout</a></li>
              </ul>
            </li>

            <?php
            // Count unread offer_created notifications
            $notifCount = 0;
            // if (isset($_SESSION['user_id'])) {
            $notifSql = "SELECT COUNT(*) as count FROM activity_log WHERE activity_type = 'offer_created'";
            $notifCount = $conn->query($notifSql)->fetch_assoc()['count'];
            // }
            ?>

            <li class="nav-item dropdown mx-lg-1">
              <a class="nav-link position-relative" href="notifications.php" style="padding: 8px 12px; border-radius: 50px;">
                <i class="fas fa-bell" style="color: #ffdd59;"></i>
                <?php if ($notifCount > 0): ?>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    <?= $notifCount ?>
                  </span>
                <?php endif; ?>
              </a>
            </li>

          <?php else: ?>
            <li class="nav-item ms-lg-2">
              <a href="./auth/login.php" action="_blank" class="nav-link login-btn d-flex align-items-center" style="background-color: #ffdd59; color: #6e48aa; font-weight: 600; padding: 8px 20px; border-radius: 50px; transition: all 0.3s;">
                <i class="fas fa-sign-in-alt me-2"></i>
                <span>Login</span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>