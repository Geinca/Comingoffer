<?php
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>About ComingOffer - Discover Amazing Deals</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/about.css">
  <link rel="stylesheet" href="./assets/css/header.css">
</head>

<body>
  <?php include('./includes/header.php') ?>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container text-center position-relative">
      <h1 class="display-4 fw-bold mb-4">About ComingOffer</h1>
      <p class="lead mb-5">Connecting shoppers with the best local deals and discounts</p>
      <a href="#our-story" class="btn btn-light btn-lg px-4 me-2">Our Story</a>
      <a href="#our-team" class="btn btn-outline-light btn-lg px-4">Our Team</a>
    </div>
  </section>

  <!-- Our Story Section -->
  <section id="our-story" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="section-title">Our Story</h2>
          <p class="lead">Welcome to <span style="font-weight: 700;">ComingOffer.com,</span> a proudly developed product of <span style="font-weight: 700;">Devadx Pvt Ltd,</span> dedicated to revolutionizing the way local shops connect with nearby customers. We are on a mission to empower small and medium businesses with a smart platform to share their best deals, reach more people, and grow profitably — all through the power of digital transformation.</p>
          <a href="#" class="btn btn-primary mt-3">Learn More</a>
        </div>
        <div class="col-lg-6">
          <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Our Story" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <!-- What we do Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">What We Do</h2>
      </div>
      <p class="lead">At ComingOffer.com, we help local shops go digital — quickly and affordably. Our platform lets shop owners easily create and publish their latest offers, making them instantly visible to nearby customers.</p>
      <div class="row g-4">
        <p>For customers, ComingOffer.com is the simplest way to:</p>
        <ul>
          <li>Discover real-time deals in their area across categories like clothing, electronics, Gym, Doctor Clinic, Saloon, Grocery, Mobile, Restaurant, Education, Beauty parlour, Employee, Others </li>
          <li>Filter offers by location (0–5 km radius)</li>
          <li>Save favourite deals and get notified before they expire</li>
          <li>Share exciting offers with friends on WhatsApp with one click</li>
        </ul>
        
        
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Why Choose ComingOffer</h2>
        <p class="lead">We're changing the way people discover local deals</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-percentage"></i>
            </div>
            <h3>Exclusive Deals</h3>
            <p>Access special discounts and offers you won't find anywhere else, available only through ComingOffer.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3>Local Focus</h3>
            <p>Discover hidden gems in your neighborhood and support local businesses in your community.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-bell"></i>
            </div>
            <h3>Personalized Alerts</h3>
            <p>Get notified about deals that match your interests and shopping habits.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-5" style="background: linear-gradient(135deg, #9d50bb 0%, #6e48aa 100%); color: white;">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-3 mb-4 mb-md-0">
          <div class="stats-item">
            <div class="stats-number">500+</div>
            <p>Local Shops</p>
          </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <div class="stats-item">
            <div class="stats-number">10K+</div>
            <p>Happy Customers</p>
          </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <div class="stats-item">
            <div class="stats-number">50K+</div>
            <p>Deals Shared</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-item">
            <div class="stats-number">5+</div>
            <p>Cities</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section id="our-team" class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Meet Our Team</h2>
        <p class="lead">The passionate people behind ComingOffer</p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="team-member">
            <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Team Member" class="team-img">
            <h4>Sarah Johnson</h4>
            <p class="text-primary">CEO & Founder</p>
            <p>With 10+ years in e-commerce, Sarah envisioned a better way to connect shoppers with local deals.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-member">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team Member" class="team-img">
            <h4>Michael Chen</h4>
            <p class="text-primary">CTO</p>
            <p>Technology wizard who built our platform from the ground up to deliver the best user experience.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-member">
            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Team Member" class="team-img">
            <h4>Jessica Williams</h4>
            <p class="text-primary">Head of Partnerships</p>
            <p>Connects with local businesses to bring you the best deals in your area.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-5 bg-light">
    <div class="container text-center">
      <h2 class="mb-4">Ready to discover amazing deals?</h2>
      <p class="lead mb-4">Join thousands of happy shoppers saving money every day</p>
      <a href="index.php" class="btn btn-primary btn-lg px-4 me-3">Browse Shops</a>
      <a href="contact.php" class="btn btn-outline-primary btn-lg px-4">Contact Us</a>
    </div>
  </section>

  <?php include('./includes/footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>