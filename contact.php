<?php
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact Us - ComingOffer</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/contact.css">
  <link rel="stylesheet" href="./assets/css/header.css">
  <style>

  </style>
</head>

<body>
  <?php include('./includes/header.php') ?>

  <!-- Hero Section -->
  <section class="contact-hero">
    <div class="container text-center position-relative">
      <h1 class="display-4 fw-bold mb-4">Contact Us</h1>
      <p class="lead mb-5">We'd love to hear from you! Get in touch with our team.</p>
    </div>
  </section>

  <!-- Contact Info Section -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="contact-card text-center">
            <div class="contact-icon mx-auto">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3>Our Location</h3>
            <p>PLOT NO-216/1063<br>Jajpur Road, Jajpur, Orissa, India, 755019</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-card text-center">
            <div class="contact-icon mx-auto">
              <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Phone Number</h3>
            <p>+91 9337680876<br>Mon-Fri, 9am-5pm</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-card text-center">
            <div class="contact-icon mx-auto">
              <i class="fas fa-envelope"></i>
            </div>
            <h3>Email Address</h3>
            <p>info@comingoffer.com</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-6">
          <h2 class="section-title">Send Us a Message</h2>
          <p class="mb-4">Have questions about our platform or want to partner with us? Fill out the form and we'll get back to you within 24 hours.</p>

          <!-- In your contact form section, modify the form like this: -->
          <form id="contactForm" method="POST" action="handlers/contact.php">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="name" class="form-label">Your Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group mb-4">
              <label for="message" class="form-label">Your Message</label>
              <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
        <div class="col-lg-6">
          <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59617.92736558947!2d86.04902490676321!3d20.94767708720668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19518f39d6ac5d%3A0xf14bc4140cb31b7c!2sByasanagar%2C%20Odisha%2C%20India!5e0!3m2!1sen!2sus!4v1752387059749!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="lead">Find quick answers to common questions</p>
      </div>

      <div class="accordion" id="faqAccordion">
        <div class="accordion-item mb-3 border-0 shadow-sm">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              How do I list my business on ComingOffer?
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              To list your business, please visit our <a href="business.php">Business Portal</a> and complete the registration form. Our team will review your application and contact you within 2 business days to complete the setup process.
            </div>
          </div>
        </div>

        <div class="accordion-item mb-3 border-0 shadow-sm">
          <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              How often are deals updated on the platform?
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Deals are updated in real-time as businesses publish them. We recommend checking back frequently or enabling notifications to never miss a great deal in your area.
            </div>
          </div>
        </div>

        <div class="accordion-item mb-3 border-0 shadow-sm">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Is there a mobile app available?
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Yes! Our mobile app is available for both iOS and Android devices. You can download it from the App Store or Google Play Store by searching for "ComingOffer".
            </div>
          </div>
        </div>

        <div class="accordion-item mb-3 border-0 shadow-sm">
          <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              How do I report an issue with a deal or business?
            </button>
          </h2>
          <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              If you encounter any issues with a deal or business, please use the "Report" button on the deal page or contact our support team directly through this contact form. We take all reports seriously and will investigate promptly.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="toast-container">
    <div id="formToast" class="toast toast-custom" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto" id="toastTitle">Notification</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" id="toastMessage"></div>
    </div>
  </div>

  <?php include('./includes/footer.php') ?>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('contactForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const form = e.target;
      const formData = new URLSearchParams(new FormData(form));

      // Show loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Sending...
    `;

      try {
        const res = await fetch(form.action, {
          method: form.method,
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: formData
        });

        const text = await res.text();
        const toast = new bootstrap.Toast(document.getElementById('formToast'));
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        if (res.ok && text === 'success') {
          // Success state
          toastTitle.textContent = 'Success!';
          toastMessage.textContent = 'Thank you! We will get back to you soon.';
          document.getElementById('formToast').classList.remove('bg-danger');
          document.getElementById('formToast').style.color = "#fff";
          form.reset();
        } else {
          // Error state
          toastTitle.textContent = 'Error';
          toastMessage.textContent = text || 'Something went wrong. Please try again.';
          document.getElementById('formToast').classList.remove('bg-success');
          document.getElementById('formToast').classList.add('bg-danger');
        }

        toast.show();
      } catch (err) {
        console.error('Error:', err);
        const toast = new bootstrap.Toast(document.getElementById('formToast'));
        document.getElementById('toastTitle').textContent = 'Network Error';
        document.getElementById('toastMessage').textContent = 'Unable to connect. Please check your connection.';
        document.getElementById('formToast').classList.remove('bg-success');
        document.getElementById('formToast').classList.add('bg-danger');
        toast.show();
      } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
  </script>
</body>

</html>