<?php
require_once './config/db.php';

$notifQuery = $conn->query("
  SELECT a.*, s.shop_name
  FROM activity_log a
  JOIN shops s ON a.shop_id = s.shop_id
  WHERE a.activity_type = 'offer_created'
  ORDER BY a.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Notifications</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h3 class="mb-4">New Offers</h3>
    <?php if ($notifQuery->num_rows > 0): ?>
      <ul class="list-group">
        <?php while ($row = $notifQuery->fetch_assoc()): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <strong><?= htmlspecialchars($row['shop_name']) ?></strong> added a new offer:
              <br><small class="text-muted"><?= htmlspecialchars($row['description']) ?></small>
            </div>
            <span class="text-muted small"><?= date('d M Y h:i A', strtotime($row['created_at'])) ?></span>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>No new offer notifications.</p>
    <?php endif; ?>
  </div>
</body>
</html>
