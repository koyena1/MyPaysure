<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Policy - PaySure</title>
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a3a8f;
            --secondary: #00a0e3;
            --accent: #ff6b00;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --gray: #6c757d;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(26, 58, 143, 0.9), rgba(0, 160, 227, 0.9)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background-color: #e05a00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        /* Main Content */
        .main-content {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.2rem;
            color: var(--primary);
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* Renewal Form */
        .renewal-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .renewal-form {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .renewal-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(0, 160, 227, 0.2);
            outline: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-block {
            display: block;
            width: 100%;
            padding: 0.9rem;
            font-size: 1.1rem;
        }

        /* Policy Details */
        .policy-details {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .policy-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .policy-card {
            background: var(--light);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .policy-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .policy-card h4 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .policy-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .policy-info span:first-child {
            font-weight: 600;
            color: var(--dark);
        }

        .policy-info span:last-child {
            color: var(--gray);
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .status-expiring {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .status-expired {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Benefits Section */
        .benefits-section {
            margin-bottom: 4rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .benefit-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .benefit-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .benefit-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        /* FAQ Section */
        .faq-section {
            margin-bottom: 4rem;
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: white;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            transition: var(--transition);
        }

        .faq-question:hover {
            background-color: rgba(0, 160, 227, 0.05);
        }

        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, padding 0.5s ease;
        }

        .faq-item.active .faq-answer {
            padding: 0 1.5rem 1.5rem;
            max-height: 500px;
        }

        .faq-toggle {
            transition: var(--transition);
        }

        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .renewal-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .hero h2 {
                font-size: 2rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php
include 'includes/header.php';
?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Renew Your Policy with Ease</h2>
            <p>Secure your future with PaySure's seamless policy renewal process. Continue your journey towards financial growth and security.</p>
            <a href="#renewal-form" class="btn btn-primary">Renew Now</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Renewal Form Section -->
            <section id="renewal-form">
                <div class="section-title">
                    <h2>Policy Renewal</h2>
                    <p>Fill in your details to renew your policy</p>
                </div>
                
                <div class="renewal-container">
                    <!-- Renewal Form -->
                    <div class="renewal-form">
                        <h3>Renewal Information</h3>
                        <form id="policyRenewalForm">
                            <div class="form-group">
                                <label for="policyNumber">Policy Number</label>
                                <input type="text" id="policyNumber" class="form-control" placeholder="Enter your policy number" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="policyHolder">Policy Holder Name</label>
                                <input type="text" id="policyHolder" class="form-control" placeholder="Full name as per policy" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="dateOfBirth">Date of Birth</label>
                                    <input type="date" id="dateOfBirth" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contactNumber">Contact Number</label>
                                    <input type="tel" id="contactNumber" class="form-control" placeholder="Your contact number" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" placeholder="Your email address" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="policyType">Policy Type</label>
                                <select id="policyType" class="form-control" required>
                                    <option value="">Select policy type</option>
                                    <option value="life">Life Insurance</option>
                                    <option value="health">Health Insurance</option>
                                    <option value="investment">Investment Plan</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="renewalPeriod">Renewal Period</label>
                                <select id="renewalPeriod" class="form-control" required>
                                    <option value="">Select renewal period</option>
                                    <option value="1">1 Year</option>
                                    <option value="2">2 Years</option>
                                    <option value="3">3 Years</option>
                                    <option value="5">5 Years</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="paymentMethod">Payment Method</label>
                                <select id="paymentMethod" class="form-control" required>
                                    <option value="">Select payment method</option>
                                    <option value="credit">Credit Card</option>
                                    <option value="debit">Debit Card</option>
                                    <option value="netbanking">Net Banking</option>
                                    <option value="upi">UPI</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" id="terms" class="form-check-input" required>
                                    <label for="terms" class="form-check-label">I agree to the <a href="#">terms and conditions</a></label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Proceed to Renewal</button>
                        </form>
                    </div>
                    
                    <!-- Policy Details -->
                    <div class="policy-details">
                        <h3>Your Policy Details</h3>
                        
                        <div class="policy-card">
                            <h4>Bajaj Allianz Life ACE</h4>
                            <div class="policy-info">
                                <span>Policy No:</span>
                                <span>BAJ123456789</span>
                            </div>
                            <div class="policy-info">
                                <span>Premium Amount:</span>
                                <span>₹1,00,000/year</span>
                            </div>
                            <div class="policy-info">
                                <span>Next Due Date:</span>
                                <span>15 Oct 2023</span>
                            </div>
                            <div class="policy-info">
                                <span>Status:</span>
                                <span class="status-badge status-active">Active</span>
                            </div>
                        </div>
                        
                        <div class="policy-card">
                            <h4>Health Insurance Plan</h4>
                            <div class="policy-info">
                                <span>Policy No:</span>
                                <span>HLT987654321</span>
                            </div>
                            <div class="policy-info">
                                <span>Premium Amount:</span>
                                <span>₹25,000/year</span>
                            </div>
                            <div class="policy-info">
                                <span>Next Due Date:</span>
                                <span>05 Nov 2023</span>
                            </div>
                            <div class="policy-info">
                                <span>Status:</span>
                                <span class="status-badge status-expiring">Expiring Soon</span>
                            </div>
                        </div>
                        
                        <div class="policy-card">
                            <h4>Investment Plan</h4>
                            <div class="policy-info">
                                <span>Policy No:</span>
                                <span>INV456789123</span>
                            </div>
                            <div class="policy-info">
                                <span>Premium Amount:</span>
                                <span>₹50,000/year</span>
                            </div>
                            <div class="policy-info">
                                <span>Next Due Date:</span>
                                <span>20 Sep 2023</span>
                            </div>
                            <div class="policy-info">
                                <span>Status:</span>
                                <span class="status-badge status-expired">Expired</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Benefits Section -->
            <section class="benefits-section">
                <div class="section-title">
                    <h2>Benefits of Renewing with PaySure</h2>
                    <p>Why choose us for your policy renewal</p>
                </div>
                
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Continuous Protection</h3>
                        <p>Ensure uninterrupted coverage for you and your loved ones with seamless policy renewal.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h3>No Claim Bonus</h3>
                        <p>Avail attractive discounts and bonuses for claim-free years when you renew on time.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Time Saving</h3>
                        <p>Quick and hassle-free renewal process that saves your valuable time and effort.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h3>Personalized Service</h3>
                        <p>Get expert guidance and personalized recommendations for your insurance needs.</p>
                    </div>
                </div>
            </section>
            
            <!-- FAQ Section -->
            <section class="faq-section">
                <div class="section-title">
                    <h2>Frequently Asked Questions</h2>
                    <p>Find answers to common questions about policy renewal</p>
                </div>
                
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>When should I renew my policy?</span>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>It's recommended to renew your policy at least 30 days before the expiry date to ensure continuous coverage without any gaps. Early renewal also helps you avoid last-minute hassles and potential lapses in coverage.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>What documents are required for policy renewal?</span>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Generally, you need your existing policy document, KYC documents (if there are any changes), and the renewal premium amount. For health insurance, you might need to submit a health declaration form if there are changes in your health condition.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Can I make changes to my policy during renewal?</span>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, renewal is an ideal time to review and modify your policy. You can increase or decrease your sum insured, add or remove riders, update personal information, or change your payment mode. However, some changes may require additional underwriting.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>What happens if I miss the renewal deadline?</span>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>If you miss the renewal deadline, most policies have a grace period (usually 15-30 days) during which you can still renew without losing benefits. After the grace period, the policy may lapse, and you might need to undergo fresh underwriting or medical tests to reinstate it.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Are there any discounts available for early renewal?</span>
                            <i class="fas fa-chevron-down faq-toggle"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, many insurance companies offer discounts or incentives for early renewal. Additionally, if you have a claim-free history, you may be eligible for a No Claim Bonus which can significantly reduce your premium amount.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php
include 'includes/footer.php';
?>
    <script>
        // FAQ Toggle Functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });

        // Form Submission
        document.getElementById('policyRenewalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple validation
            const policyNumber = document.getElementById('policyNumber').value;
            const policyHolder = document.getElementById('policyHolder').value;
            
            if (policyNumber && policyHolder) {
                // In a real application, you would submit the form data to a server
                // For this demo, we'll just show an alert
                alert('Your policy renewal request has been submitted successfully! Our representative will contact you shortly.');
                this.reset();
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 1s ease forwards';
                }
            });
        }, observerOptions);

        // Observe elements to animate
        document.querySelectorAll('.benefit-card, .policy-card, .renewal-form, .policy-details').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    </script>
</body>
</html>