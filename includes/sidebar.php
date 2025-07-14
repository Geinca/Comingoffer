<!-- sidebar.php -->
<style>
    .sidebar {
        height: 100vh;
        background: linear-gradient(195deg, #1a1a2e, #16213e);
        color: white;
        transition: all 0.3s ease;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden; /* Hide the main scrollbar */
    }
    
    .sidebar-container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }
    
    /* Custom scrollbar for Webkit browsers */
    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-content::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(transparent, rgba(0,0,0,0.1));
        pointer-events: none;
    }
    
    .sidebar-header {
        padding: 1.5rem 1.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1rem;
        flex-shrink: 0;
    }
    
    .sidebar-brand {
        display: flex;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
    }
    
    .sidebar-brand i {
        margin-right: 10px;
        font-size: 1.5rem;
        color: #4cc9f0;
    }
    
    .nav-item {
        position: relative;
        margin: 0.25rem 0;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: rgba(255, 255, 255, 0.8);
        border-radius: 0 30px 30px 0;
        margin-right: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    
    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: #4cc9f0;
        transform: scaleY(0);
        transform-origin: bottom;
        transition: transform 0.3s ease;
    }
    
    .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.05);
        transform: translateX(5px);
    }
    
    .nav-link:hover::before {
        transform: scaleY(1);
    }
    
    .nav-link.active {
        color: white;
        background: rgba(76, 201, 240, 0.1);
        font-weight: 500;
    }
    
    .nav-link.active::before {
        transform: scaleY(1);
    }
    
    .nav-link i {
        margin-right: 12px;
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }
    
    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    
    .user-info small {
        display: block;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.8rem;
    }
</style>

<div class="sidebar">
  <div class="sidebar-container">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        <i class="fas fa-store-alt"></i>
        <span>Shop Dashboard</span>
      </a>
    </div>

    <div class="sidebar-content">
      <ul class="nav nav-pills flex-column mb-auto px-2">
        <li class="nav-item">
          <a href="../dashboard/index.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <?php if ($_SESSION['role'] === 'shop_owner'): ?>
          <li class="nav-item">
            <a href="../dashboard/manage_shops.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_shops.php' ? 'active' : '' ?>">
              <i class="fas fa-store"></i>
              <span>My Shops</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/products.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">
              <i class="fas fa-box-open"></i>
              <span>Products</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/categories.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : '' ?>">
              <i class="fas fa-tags"></i>
              <span>Categories</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/offers.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'offers.php' ? 'active' : '' ?>">
              <i class="fas fa-gift"></i>
              <span>Offers</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/subscription_plan.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'subscription_plan.php' ? 'active' : '' ?>">
              <i class="fas fa-gift"></i>
              <span>Subscription Plan</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'admin'): ?>
          <li class="nav-item">
            <a href="../dashboard/all_users.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'all_users.php' ? 'active' : '' ?>">
              <i class="fas fa-users-cog"></i>
              <span>Manage Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/shops.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'shops.php' ? 'active' : '' ?>">
              <i class="fas fa-store"></i>
              <span>All Shops</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../dashboard/reviews.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : '' ?>">
              <i class="fas fa-star"></i>
              <span>Reviews</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="user-avatar">
          <i class="fas fa-user"></i>
        </div>
        <div class="user-info">
          <div><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></div>
          <small><?= ucfirst($_SESSION['role'] ?? 'User') ?></small>
        </div>
      </div>
      <a href="../auth/logout.php" class="nav-link text-white mt-3">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </div>
  </div>
</div>
