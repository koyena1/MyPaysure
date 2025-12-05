<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Opportunity - PaySure</title>
    <style>
        :root {
            --primary: #1a3a8f;
            --secondary: #00a2e8;
            --accent: #ff6b00;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }
        
        .hero {
            /* Kept the background image for the hero as it is a header, 
               but you can remove the url() part if you want it purely blue */
            background: linear-gradient(rgba(26, 58, 143, 0.9), rgba(0, 162, 232, 0.9)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            animation: fadeInUp 1s ease 0.3s both;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            animation: fadeInUp 1s ease 0.6s both;
        }
        
        .btn:hover {
            background-color: #e55a00;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--accent);
        }
        
        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .opportunity-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            /* Added border-top to make it pop without images */
            border-top: 4px solid var(--secondary);
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            border-top: 4px solid var(--accent);
        }
        
        /* Removed .card-img styles as they are no longer used */
        
        .card-content {
            padding: 35px 25px; /* Increased padding slightly for text-only look */
        }
        
        .card h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .card p {
            color: #666;
            margin-bottom: 10px;
        }
        
        /* Added a specific style for lists inside cards if needed */
        .card ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        .card ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            color: #555;
        }
        
        .card ul li::before {
            content: "•";
            color: var(--accent);
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .steps {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        
        .step {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            flex: 1;
            min-width: 200px;
            max-width: 250px;
            transition: all 0.3s ease;
        }
        
        .step:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: var(--secondary);
            color: white;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .step h4 {
            color: var(--primary);
            margin-bottom: 10px;
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
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <?php
include 'includes/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Build Your Career</h1>
            <p>Start with a Smart Insurance Plan and unlock sustainable income streams. A clean, transparent path to financial growth.</p>
            <a href="#opportunities" class="btn">View Income Plans</a>
        </div>
    </section>

    <section class="section" id="opportunities">
        <div class="container">
            <div class="section-title">
                <h2>Income Opportunities</h2>
                <p>Simple, transparent ways to earn with PaySure.</p>
            </div>
            
            <div class="opportunity-cards">
                <div class="card">
                    <div class="card-content">
                        <h3>Retail Income</h3>
                        <p>Earn direct profit from your personal sales.</p>
                        <ul>
                            <li>Instant earnings on every plan sold.</li>
                            <li>Transparent commission structure.</li>
                            <li>No cap on personal retail volume.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-content">
                        <h3>Referral Income</h3>
                        <p>Build a career by expanding the network.</p>
                        <ul>
                            <li>Earn bonuses for introducing new distributors.</li>
                            <li>Benefit from team growth and mentorship.</li>
                            <li>Create a passive income stream.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-content">
                        <h3>ROI (Return on Investment)</h3>
                        <p>Secure returns on your own financial planning.</p>
                        <ul>
                            <li>Consistent returns on your insurance plan.</li>
                            <li>Smart wealth accumulation over time.</li>
                            <li>Financial security for your future.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: #f0f5ff;">
        <div class="container">
            <div class="section-title">
                <h2>How to Start Your Career</h2>
                <p>Follow these simple steps to become a Distributor</p>
            </div>
            
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Register</h4>
                    <p>Fill out the online application form.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>KYC</h4>
                    <p>Upload documents for verification.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Activate</h4>
                    <p>Purchase a plan to activate your ID.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Earn</h4>
                    <p>Start earning Retail, Referral & ROI income.</p>
                </div>
            </div>
        </div>
    </section>

  <?php
include 'includes/footer.php';
?>
</body>
</html>