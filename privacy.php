<?php
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Privacy Policy - ComingOffer</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/privacy.css">
  <link rel="stylesheet" href="./assets/css/header.css">
</head>

<body>
  <?php include('./includes/header.php') ?>

  <!-- Hero Section -->
  <section class="policy-hero">
    <div class="container text-center position-relative">
      <h1 class="display-4 fw-bold mb-4">Privacy Policy</h1>
      <p class="lead">How we collect, use, and protect your information</p>
    </div>
  </section>

  <!-- Policy Content -->
  <section class="py-5">
    <div class="container">
      <div class="last-updated">
        <p class="mb-0"><strong>Last Updated:</strong> <?php echo date('F j, Y'); ?></p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Introduction</h2>
        <p>Welcome to ComingOffer ("we," "our," or "us"). We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.</p>
        <p>By accessing or using our service, you agree to the collection and use of information in accordance with this policy.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Information We Collect</h2>
        <p>We collect several types of information from and about users of our website, including:</p>
        
        <ul class="policy-list">
          <li><strong>Personal Information:</strong> Name, email address, phone number, location data, and other identifiers.</li>
          <li><strong>Usage Data:</strong> Information about how you interact with our website and services.</li>
          <li><strong>Device Information:</strong> IP address, browser type, operating system, and other technical details.</li>
          <li><strong>Cookies and Tracking Technologies:</strong> We use cookies and similar tracking technologies to track activity on our website.</li>
        </ul>
      </div>

      <div class="policy-card">
        <h2 class="section-title">How We Use Your Information</h2>
        <p>We use the information we collect for various purposes:</p>
        
        <ul class="policy-list">
          <li>To provide and maintain our service</li>
          <li>To notify you about changes to our service</li>
          <li>To allow you to participate in interactive features of our service</li>
          <li>To provide customer support</li>
          <li>To gather analysis or valuable information so that we can improve our service</li>
          <li>To monitor the usage of our service</li>
          <li>To detect, prevent and address technical issues</li>
          <li>To provide you with news, special offers and general information about other goods, services and events</li>
        </ul>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Data Sharing and Disclosure</h2>
        <p>We may share your personal information in the following situations:</p>
        
        <ul class="policy-list">
          <li><strong>With Service Providers:</strong> We may share your information with third-party vendors who perform services for us.</li>
          <li><strong>For Business Transfers:</strong> If we undergo a merger, acquisition, or asset sale.</li>
          <li><strong>With Affiliates:</strong> We may share your information with our affiliates.</li>
          <li><strong>With Business Partners:</strong> To offer you certain products, services or promotions.</li>
          <li><strong>With Your Consent:</strong> We may disclose your personal information for any other purpose with your consent.</li>
        </ul>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Data Security</h2>
        <p>We implement appropriate technical and organizational measures to protect the security of your personal information. However, please remember that no method of transmission over the Internet or method of electronic storage is 100% secure.</p>
        <p>We strive to use commercially acceptable means to protect your personal information but cannot guarantee its absolute security.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Your Data Protection Rights</h2>
        <p>Depending on your location, you may have certain rights regarding your personal information:</p>
        
        <ul class="policy-list">
          <li>The right to access, update or delete your information</li>
          <li>The right to rectification if your information is inaccurate or incomplete</li>
          <li>The right to object to our processing of your personal data</li>
          <li>The right to request restriction of processing your personal information</li>
          <li>The right to data portability</li>
          <li>The right to withdraw consent</li>
        </ul>
        
        <p>To exercise any of these rights, please contact us using the information provided below.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Cookies and Tracking Technologies</h2>
        <p>We use cookies and similar tracking technologies to track activity on our website and hold certain information.</p>
        <p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our service.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Children's Privacy</h2>
        <p>Our service does not address anyone under the age of 13 ("Children").</p>
        <p>We do not knowingly collect personally identifiable information from children under 13. If you are a parent or guardian and you are aware that your child has provided us with personal data, please contact us.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Changes to This Privacy Policy</h2>
        <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>
        <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>
      </div>

      <div class="policy-card">
        <h2 class="section-title">Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us:</p>
        <ul>
          <li>By email: privacy@comingoffer.com</li>
          <li>By visiting this page on our website: <a href="contact.php">Contact Us</a></li>
          <li>By phone: +91 8327725217</li>
        </ul>
      </div>
    </div>
  </section>

  <?php include('./includes/footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>