<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - PaySure Financial Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .page-header h1:after {
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

        .page-header p {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .faq-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .faq-categories {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            height: fit-content;
            margin-bottom: 1.5rem; /* Default for mobile */
        }

        .faq-categories h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            margin-bottom: 0.5rem;
        }

        .category-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: var(--gray);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .category-link:hover {
            background-color: var(--gray-light);
            color: var(--dark);
        }

        .category-link.active {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow);
        }

        .category-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .faq-content {
            flex: 1;
        }

        .faq-section {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
            
            /* UPDATED: Hide by default, will be shown by .active-section */
            display: none;
            opacity: 0;
            transform: translateY(20px);
        }
        
        /* UPDATED: Show and animate the active section */
        .faq-section.active-section {
            display: block;
            animation: fadeInUp 0.5s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .faq-section h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            padding: 1.5rem;
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            align-items: center;
        }

        .faq-section h2 i {
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .faq-accordion {
            padding: 0;
        }

        .faq-item {
            border-bottom: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .faq-question:hover {
            background-color: #f8fafc;
        }

        .faq-question h3 {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--dark);
            margin: 0;
        }

        .faq-toggle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--gray-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
            margin-left: 0.5rem;
        }

        .faq-toggle i {
            color: var(--gray);
            transition: var(--transition);
            font-size: 0.8rem;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .faq-answer-content {
            padding: 0 1.5rem 1.5rem;
            color: var(--gray);
        }

        .faq-answer-content ul, .faq-answer-content ol {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .faq-answer-content li {
            margin-bottom: 0.5rem;
        }

        .faq-item.active .faq-question {
            background-color: #f0f9ff;
        }

        .faq-item.active .faq-toggle {
            background: var(--primary);
        }

        .faq-item.active .faq-toggle i {
            color: white;
            transform: rotate(180deg);
        }

        .contact-support {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-top: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid var(--gray-light);
        }

        .contact-support h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .contact-support p {
            color: var(--gray);
            margin-bottom: 1.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            box-shadow: var(--shadow);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn i {
            margin-right: 0.5rem;
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
            width: 200px;
            height: 200px;
            background: var(--primary);
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            background: var(--secondary);
            top: 60%;
            right: 10%;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            background: var(--primary-dark);
            bottom: 20%;
            left: 15%;
            animation-delay: -10s;
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

        .search-box {
            margin-bottom: 2rem;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 3rem;
            border: 1px solid var(--gray-light);
            border-radius: 50px;
            font-size: 1rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .highlight {
            background-color: #fff9c4;
            padding: 0 2px;
            border-radius: 2px;
            font-weight: 600;
        }

        /* --- 🖥️ Desktop (Large Screens) --- */
        @media (min-width: 992px) {
            .faq-container {
                flex-direction: row;
            }

            /* UPDATED: Sidebar styles now ONLY apply to desktop */
            .faq-categories {
                flex: 0 0 300px;
                position: sticky;
                top: 2rem;
                margin-bottom: 0;
            }
        }
        
        /* --- 📱 Mobile (Small Screens) --- */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            /* UPDATED: Added padding tweaks for small screens */
            .faq-question {
                padding: 1rem 1.25rem;
                flex-wrap: wrap; /* Allows text to wrap */
            }
            .faq-question h3 {
                flex-basis: 80%; /* Give text space before toggle */
            }
            .faq-answer-content {
                padding: 0 1.25rem 1.25rem;
            }
            .faq-section h2 {
                padding: 1.25rem;
                font-size: 1.25rem;
            }
            .contact-support {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<?php
include 'includes/header.php';
?>
<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1>Frequently Asked Questions</h1>
            <p>Find answers to common questions about PaySure's financial services and opportunities</p>
        </div>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="faq-search" placeholder="Search for questions...">
        </div>

        <div class="faq-container">
            <div class="faq-categories">
                <h3>Categories</h3>
                <ul class="category-list">
                    <li class="category-item">
                        <a href="#general" class="category-link active" data-category="general">
                            <i class="fas fa-info-circle"></i> General Information
                        </a>
                    </li>
                    <li class="category-item">
                        <a href="#services" class="category-link" data-category="services">
                            <i class="fas fa-concierge-bell"></i> Services & Products
                        </a>
                    </li>
                    <li class="category-item">
                        <a href="#bajaj-ace" class="category-link" data-category="bajaj-ace">
                            <i class="fas fa-shield-alt"></i> Bajaj Allianz ACE
                        </a>
                    </li>
                    <li class="category-item">
                        <a href="#distributor" class="category-link" data-category="distributor">
                            <i class="fas fa-user-tie"></i> Distributor Program
                        </a>
                    </li>
                    <li class="category-item">
                        <a href="#earnings" class="category-link" data-category="earnings">
                            <i class="fas fa-chart-line"></i> Earnings & Benefits
                        </a>
                    </li>
                    <li class="category-item">
                        <a href="#terms" class="category-link" data-category="terms">
                            <i class="fas fa-file-contract"></i> Terms & Conditions
                        </a>
                    </li>
                </ul>
            </div>

            <div class="faq-content">
                <section id="general" class="faq-section active-section">
                    <h2><i class="fas fa-info-circle"></i> General Information</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is PaySure?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>PaySure is a financial solutions provider that empowers individuals and businesses through smart, trustworthy, and customized financial services. We offer a comprehensive range of services including investments, mutual funds, insurance, loans, and banking advisory.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is PaySure's mission?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>Our mission is to offer comprehensive financial services tailored to meet the unique needs of our clients, educate and guide them in making informed financial decisions, build lasting relationships through transparency and integrity, continuously innovate, and create a positive impact in the communities we serve.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Which financial institutions does PaySure partner with?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>PaySure partners with leading financial institutions including Bajaj Allianz, Aditya Birla Capital, Kotak Life, PNB MetLife, TATA AIG Insurance, HDFC ERGO, Care Health Insurance, Future Generali, and others to provide reliable and secure financial products.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="services" class="faq-section">
                    <h2><i class="fas fa-concierge-bell"></i> Services & Products</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What financial services does PaySure offer?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>PaySure offers a complete range of financial services including:</p>
                                    <ul>
                                        <li><strong>Investments:</strong> Safe, reliable, and high-return investment options</li>
                                        <li><strong>Mutual Funds:</strong> Diversified portfolios to balance risk and maximize growth</li>
                                        <li><strong>Insurance Solutions:</strong> Comprehensive plans for family, assets, and future protection</li>
                                        <li><strong>Personal & Business Loans:</strong> Flexible options with simple processes and competitive rates</li>
                                        <li><strong>Banking & Financial Advisory:</strong> Expert guidance on retirement planning, tax-saving strategies, and more</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>How does PaySure ensure the quality of its financial products?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>PaySure collaborates exclusively with trusted and reputed financial institutions. We conduct thorough due diligence on all partner institutions and products to ensure they meet our standards for reliability, security, and client benefit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="bajaj-ace" class="faq-section">
                    <h2><i class="fas fa-shield-alt"></i> Bajaj Allianz ACE Insurance Plan</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is Bajaj Allianz Life ACE?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>Bajaj Allianz Life ACE is a non-linked, participating, individual life insurance savings plan designed to provide lifetime guaranteed income starting immediately from the first year, along with additional benefits at maturity.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>How does the Bajaj Allianz ACE plan work?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>The plan works as follows:</p>
                                    <ul>
                                        <li>You start the policy and pay premiums annually for a selected term (e.g., 12 years)</li>
                                        <li>From the first year itself, you start receiving annual income</li>
                                        <li>This income consists of guaranteed and non-guaranteed components</li>
                                        <li>At maturity (e.g., age 100), you receive a substantial maturity benefit</li>
                                        <li>Over the course of the plan, you get significant total benefits</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is the difference between ACE and ACE with Goal Protection Benefit?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>The main differences are:</p>
                                    <ul>
                                        <li><strong>Age at Entry:</strong> ACE: 0-60 years | ACE with Goal Protection: 18-55 years</li>
                                        <li><strong>Max Age at Maturity:</strong> ACE: 100 years | ACE with Goal Protection: 85 years</li>
                                        <li><strong>Death Benefit:</strong> ACE: 1x AP plus bonuses | ACE with Goal Protection: 1x AP</li>
                                        <li>Both offer premium waiver on death, income continuity after death, and maturity benefit payable after death</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="distributor" class="faq-section">
                    <h2><i class="fas fa-user-tie"></i> Distributor Program</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>How can I become a PaySure distributor?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>To become a PaySure distributor, follow these steps:</p>
                                    <ol>
                                        <li>Fill out the online registration form</li>
                                        <li>Upload proper KYC documents and authenticate</li>
                                        <li>Pay through the associate product purchase link</li>
                                        <li>After payment, upload and share the product purchase receipt</li>
                                        <li>After validation from backend, your code will be activated</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What are the benefits of becoming a PaySure distributor?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>As a PaySure distributor, you can benefit from:</p>
                                    <ul>
                                        <li>Distribution Guaranteed Benefit</li>
                                        <li>Anniversary Benefit</li>
                                        <li>Performance Bonus</li>
                                        <li>Extra Performance Bonus</li>
                                        <li>Distribution Creation Level Bonus</li>
                                        <li>Club Member Benefits</li>
                                        <li>Retail Bonus</li>
                                        <li>Training Conclaves (Domestic, National, International)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="earnings" class="faq-section">
                    <h2><i class="fas fa-chart-line"></i> Earnings & Benefits</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is the Distribution Guaranteed Benefit?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>The Distribution Guaranteed Benefit offers monthly 6% earnings. It's available with a new Bajaj Allianz insurance plan that:</p>
                                    <ul>
                                        <li>Starts from just ₹50,000</li>
                                        <li>Has a total plan duration of 3 years (Policy term: 100 years, Policy premium term: 12 years)</li>
                                        <li>Provides monthly payouts directly from Bajaj Allianz (starting from 3.3% to 3.7%)</li>
                                        <li>Includes a promotional bonus from PaySure (2.3% to 2.7%) with no additional payments required</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What is the Performance Bonus structure?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>The Performance Bonus provides ₹2,000 for every matching (1:1) with minimum 2 direct joinings required. Key points:</p>
                                    <ul>
                                        <li>Every one unit = ₹50,000 business</li>
                                        <li>You need to generate equal business on both sides (Right & Left)</li>
                                        <li>Example: If Right Side = ₹50,000 and Left Side = ₹50,000, you get 1 Performance Bonus</li>
                                        <li>All business done in a week is counted, and matching (Right vs. Left) is checked</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="terms" class="faq-section">
                    <h2><i class="fas fa-file-contract"></i> Terms & Conditions</h2>
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>When are payments released to distributors?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>All payments are released on the 8th of every month, except for Performance Bonus which is paid weekly.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What are the requirements to get full benefits of earning opportunities?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    <p>Distributors who introduce two direct members in both right and left sides respectively get the full benefit of earning opportunities.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="contact-support">
                    <h3>Still have questions?</h3>
                    <p>If you couldn't find the answer to your question, feel free to contact our support team.</p>
                    <a href="mailto:hello@reallygreatsite.com" class="btn">
                        <i class="fas fa-envelope"></i> Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
include 'includes/footer.php';
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            const categoryLinks = document.querySelectorAll('.category-link');
            const faqSections = document.querySelectorAll('.faq-section');
            const searchInput = document.getElementById('faq-search');
            
            // --- FAQ Accordion functionality ---
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    // Close all other items *within the same section*
                    const parentAccordion = item.closest('.faq-accordion');
                    parentAccordion.querySelectorAll('.faq-item').forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const otherAnswer = otherItem.querySelector('.faq-answer');
                            otherAnswer.style.maxHeight = null;
                        }
                    });
                    
                    // Toggle current item
                    item.classList.toggle('active');
                    const answer = item.querySelector('.faq-answer');
                    
                    if (item.classList.contains('active')) {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    } else {
                        answer.style.maxHeight = null;
                    }
                });
            });
            
            // --- Category navigation ---
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    categoryLinks.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Get target category
                    const targetCategory = this.getAttribute('data-category');
                    
                    // Hide all sections
                    faqSections.forEach(section => {
                        section.classList.remove('active-section');
                        section.style.display = 'none'; // Ensure it's hidden
                    });
                    
                    // Show target section
                    const targetSection = document.getElementById(targetCategory);
                    if (targetSection) {
                        targetSection.style.display = 'block';
                        targetSection.classList.add('active-section');
                    }
                    
                    // Close all FAQ items when switching categories
                    faqItems.forEach(item => {
                        item.classList.remove('active');
                        const answer = item.querySelector('.faq-answer');
                        answer.style.maxHeight = null;
                    });
                    
                    // Clear search
                    searchInput.value = '';
                    removeAllHighlights();
                    faqItems.forEach(item => item.style.display = 'block');
                });
            });
            
            // --- Search functionality (UPDATED) ---
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                // 1. Always remove old highlights
                removeAllHighlights();
                
                if (searchTerm.length < 2) {
                    // 2. Reset view to match active category
                    faqSections.forEach(section => {
                        section.style.display = 'none';
                        section.classList.remove('active-section');
                    });
                    
                    const activeCategory = document.querySelector('.category-link.active');
                    let targetId = 'general'; // Default to first
                    if (activeCategory) {
                        targetId = activeCategory.getAttribute('data-category');
                    }
                    const activeSection = document.getElementById(targetId);
                    if (activeSection) {
                        activeSection.style.display = 'block';
                        activeSection.classList.add('active-section');
                    }

                    // 3. Reset all items to be visible
                    faqItems.forEach(item => {
                        item.style.display = 'block';
                    });
                    
                    return; // Exit
                }
                
                // --- We are searching ---
                
                // 1. Show ALL sections to search them
                faqSections.forEach(section => {
                    section.style.display = 'block'; 
                    section.classList.remove('active-section');
                });
                
                let hasResults = false;
                
                faqSections.forEach(section => {
                    let sectionHasResults = false;
                    const sectionItems = section.querySelectorAll('.faq-item');
                    
                    sectionItems.forEach(item => {
                        const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
                        const answer = item.querySelector('.faq-answer-content').textContent.toLowerCase();
                        
                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            item.style.display = 'block';
                            sectionHasResults = true;
                            hasResults = true;
                            
                            // Highlight matching text
                            highlightText(item, searchTerm);
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    // Show/hide section based on results
                    section.style.display = sectionHasResults ? 'block' : 'none';
                });
                
                // You could add a "no results" message here if !hasResults
            });
            
            // --- Helper Functions for Search ---
            
            function removeAllHighlights() {
                faqItems.forEach(item => {
                    const questions = item.querySelectorAll('.faq-question h3');
                    const answers = item.querySelectorAll('.faq-answer-content');
                    
                    [...questions, ...answers].forEach(el => {
                        if (el) el.innerHTML = el.innerHTML.replace(/<span class="highlight">(.*?)<\/span>/gi, '$1');
                    });
                });
            }
            
            function highlightText(element, searchTerm) {
                if (!searchTerm) return;
                // Escape special regex characters
                const safeSearchTerm = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${safeSearchTerm})`, 'gi');
                
                const questionEl = element.querySelector('.faq-question h3');
                if (questionEl) {
                    questionEl.innerHTML = questionEl.innerHTML.replace(regex, '<span class="highlight">$1</span>');
                }
                
                const answerEl = element.querySelector('.faq-answer-content');
                if (answerEl) {
                    answerEl.innerHTML = answerEl.innerHTML.replace(regex, '<span class="highlight">$1</span>');
                }
            }

            // --- Animate sections on scroll (Intersection Observer) ---
            // This is less relevant now sections are hidden, but good for initial load
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // The .active-section class now handles the animation
                        entry.target.classList.add('visible'); 
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            faqSections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</body>
</html>