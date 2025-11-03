<?php
// Include header
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Products - PaySure Financial Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #10b981;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            /* overflow-x: hidden; <-- REMOVED */
        }

        .insurance-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .insurance-hero {
                padding: 4rem 2rem;
            }
        }

        .insurance-hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
        }

        @media (min-width: 768px) {
            .hero-content h1 {
                font-size: 3rem;
            }
        }

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

        .hero-content p {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        @media (min-width: 768px) {
            .hero-content p {
                font-size: 1.2rem;
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        @media (min-width: 768px) {
            .container {
                padding: 2rem;
            }
        }

        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        @media (min-width: 768px) {
            .section-title {
                margin-bottom: 3rem;
            }
        }

        .section-title h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .section-title h2 {
                font-size: 2.5rem;
            }
        }

        .section-title p {
            font-size: 1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .section-title p {
                font-size: 1.1rem;
            }
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .insurance-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        @media (min-width: 640px) {
            .insurance-cards {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .insurance-cards {
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 2rem;
                margin-bottom: 4rem;
            }
        }

        .insurance-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards;
        }

        .insurance-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            padding: 1.25rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            display: flex;
            align-items: center;
        }

        @media (min-width: 768px) {
            .card-header {
                padding: 1.5rem;
            }
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .card-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        @media (min-width: 768px) {
            .card-title {
                font-size: 1.5rem;
            }
        }

        .card-body {
            padding: 1.25rem;
        }

        @media (min-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
        }

        .card-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .card-features li {
            padding: 0.5rem 0;
            display: flex;
            align-items: flex-start;
        }

        .card-features li i {
            color: var(--secondary);
            margin-right: 0.75rem;
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        @media (min-width: 480px) {
            .card-actions {
                flex-direction: row;
                gap: 1rem;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            border: none;
            text-align: center;
            font-size: 0.9rem;
            min-height: 48px; /* Better touch target */
        }

        @media (min-width: 768px) {
            .btn {
                font-size: 1rem;
            }
        }

        .card-actions .btn {
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .featured-product {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            margin-bottom: 3rem;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            .featured-product {
                flex-direction: row;
                margin-bottom: 4rem;
            }
        }

        .featured-image {
            flex: 1;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            min-height: 300px;
        }

        .featured-image:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%232563eb" opacity="0.05"><circle cx="50" cy="50" r="40"></circle></svg>');
            background-size: cover;
        }

        .featured-content {
            flex: 1;
            padding: 2rem;
        }

        @media (min-width: 992px) {
            .featured-content {
                padding: 3rem;
            }
        }

        .product-badge {
            display: inline-block;
            background: linear-gradient(to right, var(--accent), #f97316);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .featured-content h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .featured-content h2 {
                font-size: 2.25rem;
            }
        }

        .featured-content p {
            color: var(--gray);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        @media (min-width: 768px) {
            .featured-content p {
                font-size: 1.1rem;
            }
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 480px) {
            .benefits-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .benefits-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        .benefit-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .benefit-item i {
            color: var(--secondary);
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .comparison-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
            overflow-x: auto; /* Allow horizontal scrolling on mobile */
        }

        @media (min-width: 768px) {
            .comparison-section {
                padding: 3rem;
                margin-bottom: 4rem;
            }
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            min-width: 600px; /* Ensure table doesn't get too narrow */
        }

        .comparison-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 1px solid var(--gray-light);
        }

        .comparison-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .comparison-table tr:last-child td {
            border-bottom: none;
        }

        .checkmark {
            color: var(--secondary);
            font-weight: bold;
        }

        .partners-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        @media (min-width: 768px) {
            .partners-section {
                margin-bottom: 4rem;
            }
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }

        @media (min-width: 640px) {
            .partners-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 2rem;
            }
        }

        .partner-logo {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
            transition: var(--transition);
        }

        .partner-logo:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
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

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            background: var(--primary);
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        @media (min-width: 768px) {
            .shape-1 {
                width: 200px;
                height: 200px;
            }
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            background: var(--secondary);
            top: 60%;
            right: 10%;
            animation-delay: -5s;
        }

        @media (min-width: 768px) {
            .shape-2 {
                width: 150px;
                height: 150px;
            }
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            background: var(--primary-dark);
            bottom: 20%;
            left: 15%;
            animation-delay: -10s;
        }

        @media (min-width: 768px) {
            .shape-3 {
                width: 100px;
                height: 100px;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
            margin-top: 2rem; /* ADDED: Replaces <br> tags */
        }

        @media (min-width: 768px) {
            .stats-section {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 2rem;
                margin-bottom: 4rem;
            }
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        @media (min-width: 768px) {
            .stat-card {
                padding: 2rem;
            }
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        @media (min-width: 768px) {
            .stat-number {
                font-size: 2.5rem;
            }
        }

        .stat-label {
            color: var(--gray);
            font-weight: 500;
            font-size: 0.9rem;
        }

        @media (min-width: 768px) {
            .stat-label {
                font-size: 1rem;
            }
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 1.5rem;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .cta-section {
                padding: 4rem 2rem;
            }
        }

        .cta-section h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .cta-section h2 {
                font-size: 2.5rem;
            }
        }

        .cta-section p {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (min-width: 768px) {
            .cta-section p {
                font-size: 1.2rem;
            }
        }

        .btn-white {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Mobile-specific improvements */
        @media (max-width: 767px) {
            .comparison-table {
                font-size: 0.9rem;
            }
            
            .comparison-table th,
            .comparison-table td {
                padding: 0.75rem 0.5rem;
            }
            
            .featured-image h2 {
                font-size: 2rem;
            }
            
            .card-actions .btn {
                min-width: 140px; /* Ensure buttons are large enough on mobile */
            }
        }

        /* Extra small devices */
        @media (max-width: 480px) {
            .insurance-hero {
                padding: 2rem 1rem;
            }
            
            .hero-content h1 {
                font-size: 1.75rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .partners-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <section class="insurance-hero">
        <div class="hero-content">
            <h1>Secure Your Future with PaySure Insurance</h1>
            <p>Comprehensive insurance solutions tailored to protect what matters most to you and your family</p>
            <a href="#products" class="btn btn-white">
                <i class="fas fa-shield-alt"></i> Explore Our Plans
            </a>
        </div>
    </section>

    <div class="container">
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number">99.04%</div>
                <div class="stat-label">Claim Settlement Ratio</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">516%</div>
                <div class="stat-label">Solvency Ratio</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">75+</div>
                <div class="stat-label">Most Valuable Indian Brands</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Credit Rating</div>
            </div>
        </div>

        <section id="products">
            <div class="section-title">
                <h2>Our Insurance Products</h2>
                <p>Choose from our wide range of insurance plans designed to secure your financial future</p>
            </div>

            <div class="insurance-cards">
                <div class="insurance-card" style="animation-delay: 0.1s">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="card-title">Life Insurance</div>
                    </div>
                    <div class="card-body">
                        <p>Secure your family's financial future with comprehensive life coverage</p>
                        <ul class="card-features">
                            <li><i class="fas fa-check"></i> Financial protection for your family</li>
                            <li><i class="fas fa-check"></i> Savings and investment components</li>
                            <li><i class="fas fa-check"></i> Tax benefits under Section 80C & 10(10D)</li>
                            <li><i class="fas fa-check"></i> Loan against policy</li>
                        </ul>
                        <div class="card-actions">
                            <a href="#" class="btn btn-primary">Get Quote</a>
                            <a href="#" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="insurance-card" style="animation-delay: 0.2s">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <div class="card-title">Health Insurance</div>
                    </div>
                    <div class="card-body">
                        <p>Comprehensive health coverage for you and your family</p>
                        <ul class="card-features">
                            <li><i class="fas fa-check"></i> Cashless hospitalization</li>
                            <li><i class="fas fa-check"></i> Pre and post hospitalization cover</li>
                            <li><i class="fas fa-check"></i> Critical illness coverage</li>
                            <li><i class="fas fa-check"></i> Tax benefits under Section 80D</li>
                        </ul>
                        <div class="card-actions">
                            <a href="#" class="btn btn-primary">Get Quote</a>
                            <a href="#" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="insurance-card" style="animation-delay: 0.3s">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-title">Investment Plans</div>
                    </div>
                    <div class="card-body">
                        <p>Grow your wealth while securing your future with ULIPs and endowment plans</p>
                        <ul class="card-features">
                            <li><i class="fas fa-check"></i> Market-linked returns</li>
                            <li><i class="fas fa-check"></i> Life cover protection</li>
                            <li><i class="fas fa-check"></i> Tax saving benefits</li>
                            <li><i class="fas fa-check"></i> Flexible premium payment options</li>
                        </ul>
                        <div class="card-actions">
                            <a href="#" class="btn btn-primary">Get Quote</a>
                            <a href="#" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-product">
            <div class="featured-image">
                <div style="text-align: center; max-width: 400px;">
                    <h3 style="color: var(--primary); margin-bottom: 1rem;">Bajaj Allianz Life</h3>
                    <h2 style="font-size: 2rem; color: var(--dark); margin-bottom: 1rem;">ACE</h2>
                    <p style="color: var(--gray);">A Non-linked, Participating, Individual Life Insurance Savings Plan</p>
                </div>
            </div>
            <div class="featured-content">
                <span class="product-badge">Featured Product</span>
                <h2>Bajaj Allianz Life ACE</h2>
                <p>A comprehensive whole life policy that provides immediate income from the first year along with substantial maturity benefits.</p>
                
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Income from Year 1</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Life Cover Protection</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-rupee-sign"></i>
                        <span>Guaranteed + Bonus Returns</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-gift"></i>
                        <span>Maturity Benefits</span>
                    </div>
                </div>
                
                <div class="card-actions">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-calculator"></i> Calculate Premium
                    </a>
                    <a href="#" class="btn btn-outline">
                        <i class="fas fa-file-pdf"></i> Download Brochure
                    </a>
                </div>
            </div>
        </section>

        <section class="comparison-section">
            <div class="section-title">
                <h2>Plan Comparison</h2>
                <p>Compare our ACE plans to find the perfect fit for your financial goals</p>
            </div>

            <div style="overflow-x: auto;">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Features</th>
                            <th>ACE</th>
                            <th>ACE with Goal Protection</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Choice of Premium Payment Term</td>
                            <td class="checkmark">✔</td>
                            <td class="checkmark">✔</td>
                        </tr>
                        <tr>
                            <td>Choice of Income Amount</td>
                            <td class="checkmark">✔</td>
                            <td class="checkmark">✔</td>
                        </tr>
                        <tr>
                            <td>Choice of Income Start Year</td>
                            <td class="checkmark">✔</td>
                            <td class="checkmark">✔</td>
                        </tr>
                        <tr>
                            <td>Age at Entry</td>
                            <td>0 to 60 years</td>
                            <td>18 to 55 years</td>
                        </tr>
                        <tr>
                            <td>Max Age at Maturity</td>
                            <td>100 years</td>
                            <td>85 years</td>
                        </tr>
                        <tr>
                            <td>Benefit on Death</td>
                            <td>1x AP plus Bonuses</td>
                            <td>1x AP</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="partners-section">
            <div class="section-title">
                <h2>Our Trusted Partners</h2>
                <p>We collaborate with leading insurance providers to bring you the best products</p>
            </div>

            <div class="partners-grid">
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">Bajaj Allianz</div>
                </div>
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">Aditya Birla</div>
                </div>
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">Kotak Life</div>
                </div>
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">PNB MetLife</div>
                </div>
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">TATA AIG</div>
                </div>
                <div class="partner-logo">
                    <div style="font-weight: bold; color: var(--primary);">HDFC ERGO</div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Secure Your Future?</h2>
            <p>Get expert advice from our financial advisors and choose the perfect insurance plan for your needs</p>
            <a href="contact.php" class="btn btn-white">
                <i class="fas fa-headset"></i> Talk to an Expert
            </a>
        </section>
    </div>

    </body>
</html>

<?php
// Include footer
include('includes/footer.php');
?>