<!-- topbar.php -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

  :root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --accent-color: #4895ef;
    --topbar-height: 60px;
  }

  .top-navbar {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    height: var(--topbar-height);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 0 1rem;
    position: sticky;
    top: 0;
    z-index: 1030;
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    color: white !important;
    transition: all 0.3s ease;
    font-family: "Dancing Script", cursive;
  }

  .navbar-brand:hover {
    transform: translateX(3px);
  }

  .navbar-brand-icon {
    margin-right: 10px;
    font-size: 1.8rem;
  }

  .user-dropdown-btn {
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 30px;
    padding: 0.35rem 1rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
    color: white !important;
  }

  .user-dropdown-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
  }

  .user-dropdown-btn:after {
    display: none;
  }

  .user-dropdown-menu {
    border: none;
    border-radius: 8px;
    padding: 0.5rem 0;
    margin-top: 10px !important;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    min-width: 200px;
  }

  .dropdown-item {
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
  }

  .dropdown-item i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
  }

  .dropdown-item:hover {
    background: rgba(67, 97, 238, 0.1);
    transform: translateX(3px);
  }

  .dropdown-divider {
    border-color: rgba(0, 0, 0, 0.08);
  }

  .logout-item {
    color: #f72585 !important;
  }

  .logout-item:hover {
    background: rgba(247, 37, 133, 0.1) !important;
  }

  /* Notification badge */
  .notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #f72585;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: bold;
  }
</style>

<nav class="navbar navbar-expand-lg top-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">
      <span class="navbar-brand-icon">🛒</span>
      <span>Comingoffer</span>
    </a>

    <div class="d-flex align-items-center">
      <!-- Notification Icon (optional) -->
      <div class="position-relative me-3">
        <button class="btn btn-link text-white p-0" type="button">
          <i class="fas fa-bell fa-lg"></i>
          <span class="notification-badge">3</span>
        </button>
      </div>

      <!-- User Dropdown -->
      <div class="dropdown">
        <button class="btn user-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle me-2"></i>
          <?= htmlspecialchars($_SESSION['username'] ?? 'Shop Owner') ?>
          <i class="fas fa-chevron-down ms-2" style="font-size: 0.8rem;"></i>
        </button>
        <ul class="dropdown-menu user-dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item logout-item" href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>