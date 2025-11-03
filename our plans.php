<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Insurance Plans - PaySure</title>
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

        html {
            scroll-behavior: smooth;
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

        
        .btn {
            padding: 0.6rem 1.5rem;
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

        .btn-outline {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background-color: white;
            color: var(--primary);
            transform: translateY(-2px);
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

        /* Plans Filter */
        .plans-filter {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .filter-btn {
            padding: 0.8rem 1.5rem;
            background: white;
            border: 2px solid var(--primary);
            border-radius: 50px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
        }

        /* Plans Grid */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .plan-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            position: relative;
        }

        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .plan-card.featured::before {
            content: 'Most Popular';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--accent);
            color: white;
            padding: 0.5rem 3rem;
            font-size: 0.8rem;
            font-weight: 600;
            transform: rotate(45deg);
            z-index: 1;
        }

        .plan-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .plan-header h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .plan-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .plan-period {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .plan-features {
            padding: 2rem;
        }

        .plan-features ul {
            list-style: none;
            margin-bottom: 2rem;
        }

        .plan-features li {
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features i {
            color: var(--success);
        }

        .plan-actions {
            padding: 0 2rem 2rem;
        }

        .btn-block {
            display: block;
            width: 100%;
            padding: 0.9rem;
            font-size: 1.1rem;
        }

        /* Plan Details Section */
        .plan-details {
            margin-bottom: 4rem;
        }

        .plan-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 2rem;
        }

        .tab-btn {
            padding: 1rem 2rem;
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .tab-btn.active {
            color: var(--primary);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .comparison-table th, .comparison-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .comparison-table th {
            background: var(--light);
            font-weight: 600;
        }

        .comparison-table tr:hover {
            background: rgba(0, 160, 227, 0.05);
        }

        .feature-check {
            color: var(--success);
            font-weight: bold;
        }

        .feature-cross {
            color: var(--danger);
            font-weight: bold;
        }

        /* Calculator Section */
        .calculator-section {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 4rem;
        }

        .calculator-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .calculator-form .form-group {
            margin-bottom: 1.5rem;
        }

        .calculator-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .calculator-form input, .calculator-form select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .calculator-form input:focus, .calculator-form select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(0, 160, 227, 0.2);
            outline: none;
        }

        .calculator-result {
            background: var(--light);
            border-radius: 12px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
        }

        .result-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        /* Partners Section */
        .partners-section {
            margin-bottom: 4rem;
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
        }

        .partner-logo {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .partner-logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .partner-logo img {
            max-width: 100%;
            max-height: 60px;
            filter: grayscale(100%);
            transition: var(--transition);
        }

        .partner-logo:hover img {
            filter: grayscale(0%);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4rem 0;
            text-align: center;
            border-radius: 12px;
        }

        .cta-section h2 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--accent);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 0.8rem;
        }

        .footer-column a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-column a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .calculator-container {
                grid-template-columns: 1fr;
            }
            
            nav ul {
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .plans-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php
include 'includes/header.php';
?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Our Insurance Plans</h2>
            <p>Discover comprehensive insurance solutions designed to protect your future and secure your financial goals.</p>
            <a href="#plans" class="btn btn-primary">View All Plans</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Plans Filter -->
            <section class="plans-filter">
                <button class="filter-btn active" data-filter="all">All Plans</button>
                <button class="filter-btn" data-filter="life">Life Insurance</button>
                <button class="filter-btn" data-filter="health">Health Insurance</button>
                <button class="filter-btn" data-filter="investment">Investment Plans</button>
                <button class="filter-btn" data-filter="savings">Savings Plans</button>
            </section>

            <!-- Plans Grid -->
            <section id="plans" class="plans-grid">
                <!-- ACE Plan -->
                <div class="plan-card featured" data-category="life savings">
                    <div class="plan-header">
                        <h3>Bajaj Allianz Life ACE</h3>
                        <div class="plan-price">₹1,00,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Whole Life Policy - Till Age 100</li>
                            <li><i class="fas fa-check"></i> Immediate Income from Year 1</li>
                            <li><i class="fas fa-check"></i> Premium Payment: 12 Years Only</li>
                            <li><i class="fas fa-check"></i> Maturity Benefit: ₹1.44 Crore</li>
                            <li><i class="fas fa-check"></i> Total Benefit: ₹1.67 Crore</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>

                <!-- ACE with Goal Protection -->
                <div class="plan-card" data-category="life">
                    <div class="plan-header">
                        <h3>ACE with Goal Protection</h3>
                        <div class="plan-price">₹1,00,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Policy Term: 40 Years</li>
                            <li><i class="fas fa-check"></i> Immediate Income from Year 1</li>
                            <li><i class="fas fa-check"></i> Death Benefit: ₹11 Lakhs</li>
                            <li><i class="fas fa-check"></i> Premium Waiver on Claim</li>
                            <li><i class="fas fa-check"></i> Maturity Benefit: ₹1.2 Crores</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>

                <!-- Health Insurance -->
                <div class="plan-card" data-category="health">
                    <div class="plan-header">
                        <h3>Comprehensive Health Plan</h3>
                        <div class="plan-price">₹25,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Coverage: Up to ₹10 Lakhs</li>
                            <li><i class="fas fa-check"></i> Cashless Hospitalization</li>
                            <li><i class="fas fa-check"></i> Pre & Post Hospitalization</li>
                            <li><i class="fas fa-check"></i> Day Care Procedures</li>
                            <li><i class="fas fa-check"></i> Annual Health Checkup</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>

                <!-- Investment Plan -->
                <div class="plan-card" data-category="investment">
                    <div class="plan-header">
                        <h3>Wealth Builder</h3>
                        <div class="plan-price">₹50,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Policy Term: 15-25 Years</li>
                            <li><i class="fas fa-check"></i> Life Cover Included</li>
                            <li><i class="fas fa-check"></i> Market-Linked Returns</li>
                            <li><i class="fas fa-check"></i> Partial Withdrawal Option</li>
                            <li><i class="fas fa-check"></i> Tax Benefits Under 80C & 10(10D)</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>

                <!-- Three Generation Plan -->
                <div class="plan-card" data-category="life savings">
                    <div class="plan-header">
                        <h3>Three Generation Plan</h3>
                        <div class="plan-price">₹1,00,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Income for 3 Generations</li>
                            <li><i class="fas fa-check"></i> Premium Payment: 12 Years</li>
                            <li><i class="fas fa-check"></i> Legacy Planning</li>
                            <li><i class="fas fa-check"></i> Lump Sum Benefit: ₹7 Crore</li>
                            <li><i class="fas fa-check"></i> Flexible Income Options</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>

                <!-- Term Insurance -->
                <div class="plan-card" data-category="life">
                    <div class="plan-header">
                        <h3>Secure Term Plan</h3>
                        <div class="plan-price">₹12,000</div>
                        <div class="plan-period">per year</div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li><i class="fas fa-check"></i> High Sum Assured</li>
                            <li><i class="fas fa-check"></i> Affordable Premiums</li>
                            <li><i class="fas fa-check"></i> Critical Illness Rider</li>
                            <li><i class="fas fa-check"></i> Accidental Death Benefit</li>
                            <li><i class="fas fa-check"></i> Tax Benefits Under 80C & 10(10D)</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#" class="btn btn-primary btn-block">Get Quote</a>
                    </div>
                </div>
            </section>

            <!-- Plan Details Section -->
            <section class="plan-details">
                <div class="section-title">
                    <h2>Plan Comparison</h2>
                    <p>Compare our featured plans to find the perfect fit for your needs</p>
                </div>

                <div class="plan-tabs">
                    <button class="tab-btn active" data-tab="ace">ACE Plan</button>
                    <button class="tab-btn" data-tab="ace-protection">ACE with Protection</button>
                    <button class="tab-btn" data-tab="three-gen">Three Generation Plan</button>
                </div>

                <div class="tab-content active" id="ace">
                    <h3>Bajaj Allianz Life ACE - Whole Life Immediate Income</h3>
                    <p>This plan is designed to provide lifetime guaranteed income starting immediately from the first year, along with additional benefits at maturity.</p>
                    
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Plan Type</td>
                                <td>Whole life policy – income starts from the first year and continues till age 100</td>
                            </tr>
                            <tr>
                                <td>Entry Age</td>
                                <td>35 years</td>
                            </tr>
                            <tr>
                                <td>Policy Term</td>
                                <td>65 years (from age 35 to age 100)</td>
                            </tr>
                            <tr>
                                <td>Premium Payment</td>
                                <td>Annual premium of ₹1,00,000 for 12 years only</td>
                            </tr>
                            <tr>
                                <td>Income Benefits</td>
                                <td>₹44,000 per year (40% guaranteed + 60% non-guaranteed)</td>
                            </tr>
                            <tr>
                                <td>Maturity Benefit</td>
                                <td>₹1.44 Crore at age 100</td>
                            </tr>
                            <tr>
                                <td>Total Benefits</td>
                                <td>₹1.67 Crore (guaranteed income + bonuses + maturity benefit)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-content" id="ace-protection">
                    <h3>ACE with Goal Protection Benefit</h3>
                    <p>This plan offers the benefits of ACE with additional protection for your family in case of unfortunate events.</p>
                    
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Entry Age</td>
                                <td>35 years</td>
                            </tr>
                            <tr>
                                <td>Policy Term</td>
                                <td>40 years (covers you until age 75)</td>
                            </tr>
                            <tr>
                                <td>Premium Payment</td>
                                <td>₹1 lakh per year, paid for 12 years</td>
                            </tr>
                            <tr>
                                <td>Income</td>
                                <td>₹44,000 annually from the first year</td>
                            </tr>
                            <tr>
                                <td>Death Benefit</td>
                                <td>₹11 lakhs lump sum to family</td>
                            </tr>
                            <tr>
                                <td>Premium Waiver</td>
                                <td>All future premiums waived after claim</td>
                            </tr>
                            <tr>
                                <td>Maturity Benefit</td>
                                <td>₹1.2 crores at age 75</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-content" id="three-gen">
                    <h3>Three Generation Income Plan</h3>
                    <p>A unique plan that provides financial benefits across three generations, ensuring legacy planning and continuous income.</p>
                    
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Generation</th>
                                <th>Benefits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1st Generation</td>
                                <td>Parent receives income of ₹40,000 p.a. from 1st policy year till child gets married</td>
                            </tr>
                            <tr>
                                <td>2nd Generation</td>
                                <td>Child gets income of ₹40,000 p.a. post marriage till age 99</td>
                            </tr>
                            <tr>
                                <td>3rd Generation</td>
                                <td>Grandchild receives lump sum amount of ₹7 Crore when child turns 100 years</td>
                            </tr>
                            <tr>
                                <td>Premium</td>
                                <td>₹1 Lakh per annum for 12 years</td>
                            </tr>
                            <tr>
                                <td>Entry Age</td>
                                <td>Child age 5 years</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Calculator Section -->
            <section class="calculator-section">
                <div class="section-title">
                    <h2>Premium Calculator</h2>
                    <p>Estimate your premium based on your requirements</p>
                </div>

                <div class="calculator-container">
                    <div class="calculator-form">
                        <div class="form-group">
                            <label for="calc-plan">Select Plan</label>
                            <select id="calc-plan" class="form-control">
                                <option value="ace">Bajaj Allianz Life ACE</option>
                                <option value="ace-protection">ACE with Goal Protection</option>
                                <option value="three-gen">Three Generation Plan</option>
                                <option value="health">Health Insurance</option>
                                <option value="investment">Wealth Builder</option>
                                <option value="term">Secure Term Plan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="calc-age">Your Age</label>
                            <input type="number" id="calc-age" class="form-control" min="18" max="65" value="35">
                        </div>
                        <div class="form-group">
                            <label for="calc-income">Desired Annual Income (₹)</label>
                            <input type="number" id="calc-income" class="form-control" min="10000" value="44000">
                        </div>
                        <div class="form-group">
                            <label for="calc-term">Policy Term (Years)</label>
                            <select id="calc-term" class="form-control">
                                <option value="10">10 Years</option>
                                <option value="15">15 Years</option>
                                <option value="20">20 Years</option>
                                <option value="25">25 Years</option>
                                <option value="30">30 Years</option>
                                <option value="40" selected>40 Years</option>
                            </select>
                        </div>
                        <button id="calculate-btn" class="btn btn-primary btn-block">Calculate Premium</button>
                    </div>
                    <div class="calculator-result">
                        <h3>Estimated Premium</h3>
                        <div class="result-item">
                            <span>Annual Premium:</span>
                            <span id="annual-premium">₹1,00,000</span>
                        </div>
                        <div class="result-item">
                            <span>Total Premium (12 years):</span>
                            <span id="total-premium">₹12,00,000</span>
                        </div>
                        <div class="result-item">
                            <span>Estimated Maturity Value:</span>
                            <span id="maturity-value">₹1,44,00,000</span>
                        </div>
                        <div class="result-item">
                            <span>Total Benefits:</span>
                            <span id="total-benefits">₹1,67,00,000</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Partners Section -->
            <section class="partners-section">
                <div class="section-title">
                    <h2>Our Trusted Partners</h2>
                    <p>We collaborate with leading financial institutions to bring you the best products</p>
                </div>

                <div class="partners-grid">
                    <div class="partner-logo">
                        <img src="assets/images/bajaj.png" alt="Bajaj Allianz">
                    </div>
                    <div class="partner-logo">
                        <img src="assets/images/Aditya.png" alt="Aditya Birla Capital">
                    </div>
                    <div class="partner-logo">
                        <img src="assets/images/kotak.png" alt="Kotak Life">
                    </div>
                    <div class="partner-logo">
                        <img src="assets/images/pnb.png" alt="PNB MetLife">
                    </div>
                    <div class="partner-logo">
                        <img src="assets/images/Tata.png" alt="TATA AIG Insurance">
                    </div>
                    <div class="partner-logo">
                        <img src="assets/images/hdfc.png" alt="HDFC ERGO">
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="cta-section">
                <h2>Ready to Secure Your Future?</h2>
                <p>Contact our financial advisors today to find the perfect plan for your needs</p>
                <a href="#" class="btn btn-outline">Contact Us</a>
                <a href="#" class="btn btn-primary">Get Free Consultation</a>
            </section>
        </div>
    </main>

    <!-- Footer -->
   <?php
include 'includes/footer.php';
?>

    <script>
        // Plan Filtering
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                
                // Filter plans
                const filter = button.getAttribute('data-filter');
                const plans = document.querySelectorAll('.plan-card');
                
                plans.forEach(plan => {
                    if (filter === 'all' || plan.getAttribute('data-category').includes(filter)) {
                        plan.style.display = 'block';
                        setTimeout(() => {
                            plan.style.opacity = '1';
                            plan.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        plan.style.opacity = '0';
                        plan.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            plan.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Tab Switching
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Update active tab button
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                
                // Show active tab content
                const tabId = button.getAttribute('data-tab');
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Premium Calculator
        document.getElementById('calculate-btn').addEventListener('click', function() {
            const plan = document.getElementById('calc-plan').value;
            const age = parseInt(document.getElementById('calc-age').value);
            const income = parseInt(document.getElementById('calc-income').value);
            const term = parseInt(document.getElementById('calc-term').value);
            
            // Simple calculation logic (in a real app, this would be more complex)
            let annualPremium, totalPremium, maturityValue, totalBenefits;
            
            if (plan === 'ace' || plan === 'ace-protection' || plan === 'three-gen') {
                annualPremium = Math.round(income * 2.27); // Based on ₹44,000 income for ₹1,00,000 premium
                totalPremium = annualPremium * 12;
                maturityValue = Math.round(totalPremium * 12); // 12x return
                totalBenefits = Math.round(maturityValue * 1.16); // Additional 16% from bonuses
            } else if (plan === 'health') {
                annualPremium = Math.round(income * 0.05); // 5% of desired coverage
                totalPremium = annualPremium * 1;
                maturityValue = 0; // No maturity for pure health insurance
                totalBenefits = income; // Sum insured
            } else if (plan === 'investment') {
                annualPremium = Math.round(income * 1.14); // Based on example
                totalPremium = annualPremium * term;
                maturityValue = Math.round(totalPremium * 2.5); // 2.5x return
                totalBenefits = maturityValue;
            } else if (plan === 'term') {
                annualPremium = Math.round(income * 0.003); // 0.3% of sum assured
                totalPremium = annualPremium * term;
                maturityValue = 0; // No maturity for pure term insurance
                totalBenefits = income; // Sum assured on death
            }
            
            // Update results
            document.getElementById('annual-premium').textContent = '₹' + annualPremium.toLocaleString('en-IN');
            document.getElementById('total-premium').textContent = '₹' + totalPremium.toLocaleString('en-IN');
            document.getElementById('maturity-value').textContent = '₹' + maturityValue.toLocaleString('en-IN');
            document.getElementById('total-benefits').textContent = '₹' + totalBenefits.toLocaleString('en-IN');
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
        document.querySelectorAll('.plan-card, .calculator-section, .partners-grid').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    </script>
</body>
</html>