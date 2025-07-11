<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your Subscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .plan-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .current-plan {
            border: 3px solid;
            position: relative;
        }
        .current-plan::after {
            content: "Your Current Plan";
            position: absolute;
            top: 10px;
            right: -25px;
            background: var(--bs-success);
            color: white;
            padding: 3px 15px;
            transform: rotate(45deg);
            font-size: 12px;
            font-weight: bold;
        }
        .popular-tag {
            position: absolute;
            top: 15px;
            right: -30px;
            background: var(--bs-warning);
            color: var(--bs-dark);
            padding: 3px 25px;
            transform: rotate(45deg);
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .feature-list li:last-child {
            border-bottom: none;
        }
        .btn-upgrade {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Your Subscription</h1>
                <p class="lead text-muted">Manage your current plan or upgrade for more features</p>
            </div>
        </div>

        <!-- Current Plan Status -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-1"><i class="fas fa-crown text-warning me-2"></i>Medium Plan</h3>
                                <p class="text-muted mb-2">8 offers per month • Priority Support</p>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2">Active</span>
                                    <small class="text-muted">Renews on: 15 Aug 2023</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#subscriptionModal">
                                    Change Plan
                                </button>
                                <button class="btn btn-outline-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Comparison -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Choose the Right Plan for You</h2>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active">Monthly Billing</button>
                    <button type="button" class="btn btn-outline-secondary">Yearly Billing (Save 20%)</button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Basic Plan -->
            <div class="col-lg-4">
                <div class="card plan-card h-100 border-primary border-2">
                    <div class="card-body p-4">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-star me-2"></i>Basic
                        </h5>
                        <p class="text-muted">Perfect for individuals getting started</p>
                        <h2 class="fw-bold my-3">₹199<small class="text-muted fs-6">/month</small></h2>
                        <h5 class="fw-bold mb-4">₹1500<small class="text-muted fs-6">/year</small></h5>
                        
                        <ul class="feature-list list-unstyled mb-4">
                            <li><i class="fas fa-check text-primary me-2"></i>5 offers per month</li>
                            <li><i class="fas fa-check text-primary me-2"></i>Basic email support</li>
                            <li><i class="fas fa-check text-primary me-2"></i>Standard updates</li>
                            <li><i class="fas fa-times text-muted me-2"></i>No analytics</li>
                            <li><i class="fas fa-times text-muted me-2"></i>No priority support</li>
                        </ul>
                        
                        <button class="btn btn-outline-primary w-100 mt-auto">
                            Select Basic
                        </button>
                    </div>
                </div>
            </div>

            <!-- Medium Plan (Current/Highlighted) -->
            <div class="col-lg-4">
                <div class="card plan-card h-100 border-warning border-2 current-plan shadow-lg">
                    <div class="popular-tag">MOST POPULAR</div>
                    <div class="card-body p-4">
                        <h5 class="card-title text-warning">
                            <i class="fas fa-gem me-2"></i>Medium
                        </h5>
                        <p class="text-muted">Best for growing businesses</p>
                        <h2 class="fw-bold my-3">₹499<small class="text-muted fs-6">/month</small></h2>
                        <h5 class="fw-bold mb-4">₹2500<small class="text-muted fs-6">/year</small></h5>
                        
                        <ul class="feature-list list-unstyled mb-4">
                            <li><i class="fas fa-check text-warning me-2"></i>8 offers per month</li>
                            <li><i class="fas fa-check text-warning me-2"></i>Priority email support</li>
                            <li><i class="fas fa-check text-warning me-2"></i>Email + SMS updates</li>
                            <li><i class="fas fa-check text-warning me-2"></i>Basic analytics</li>
                            <li><i class="fas fa-times text-muted me-2"></i>No account manager</li>
                        </ul>
                        
                        <button class="btn btn-warning w-100 fw-bold">
                            Current Plan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-lg-4">
                <div class="card plan-card h-100 border-success border-2">
                    <div class="card-body p-4">
                        <h5 class="card-title text-success">
                            <i class="fas fa-rocket me-2"></i>Premium
                        </h5>
                        <p class="text-muted">For maximum growth potential</p>
                        <h2 class="fw-bold my-3">₹999<small class="text-muted fs-6">/month</small></h2>
                        <h5 class="fw-bold mb-4">₹3000<small class="text-muted fs-6">/year</small></h5>
                        
                        <ul class="feature-list list-unstyled mb-4">
                            <li><i class="fas fa-check text-success me-2"></i>15 offers per month</li>
                            <li><i class="fas fa-check text-success me-2"></i>24/7 VIP support</li>
                            <li><i class="fas fa-check text-success me-2"></i>All updates</li>
                            <li><i class="fas fa-check text-success me-2"></i>Advanced analytics</li>
                            <li><i class="fas fa-check text-success me-2"></i>Dedicated account manager</li>
                        </ul>
                        
                        <button class="btn btn-success w-100 btn-upgrade">
                            Upgrade to Premium
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h3 class="text-center mb-4">Frequently Asked Questions</h3>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Can I change my plan anytime?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can upgrade or downgrade your plan at any time. Changes will be prorated based on your billing cycle.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Is there a money-back guarantee?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 14-day money-back guarantee on all new subscriptions. If you're not satisfied, we'll refund your payment.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your existing modal here -->
    <!-- The modal code you provided would go here -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // You can add JavaScript here to handle plan selection
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Change billing toggle
            const billingToggle = document.querySelectorAll('.btn-group .btn');
            billingToggle.forEach(btn => {
                btn.addEventListener('click', function() {
                    billingToggle.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    // Here you would update pricing display based on monthly/yearly
                });
            });
            
            // Example: Plan selection buttons
            const planButtons = document.querySelectorAll('.plan-card .btn');
            planButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // You could trigger the modal here or process the selection
                    const plan = this.closest('.plan-card').querySelector('.card-title').textContent.trim();
                    console.log('Selected plan:', plan);
                });
            });
        });
    </script>
</body>
</html>