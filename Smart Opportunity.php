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
            background: linear-gradient(rgba(26, 58, 143, 0.8), rgba(0, 162, 232, 0.8)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .card-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .card-content {
            padding: 25px;
        }
        
        .card h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .card p {
            color: #666;
            margin-bottom: 20px;
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
            <h1>Smart Financial Opportunities</h1>
            <p>Discover how PaySure can help you build a secure financial future with our innovative investment and insurance solutions.</p>
            <a href="#opportunities" class="btn">Explore Opportunities</a>
        </div>
    </section>

    <section class="section" id="opportunities">
        <div class="container">
            <div class="section-title">
                <h2>Smart Earning Opportunities</h2>
                <p>Join PaySure and unlock multiple income streams with our comprehensive distributor program</p>
            </div>
            
            <div class="opportunity-cards">
                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="card-content">
                        <h3>Distribution Guaranteed Benefit</h3>
                        <p>Secure your financial future with monthly 6% earnings through our exclusive Bajaj Allianz insurance plans.</p>
                        <a href="#" class="btn">Learn More</a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="card-content">
                        <h3>Performance Bonus</h3>
                        <p>Earn ₹2,000 for every matching business unit with our 1:1 performance bonus structure.</p>
                        <a href="#" class="btn">Learn More</a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="card-content">
                        <h3>Club Member Benefits</h3>
                        <p>Advance through our ranking system and unlock exclusive rewards, reimbursements, and international tours.</p>
                        <a href="#" class="btn">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: #f0f5ff;">
        <div class="container">
            <div class="section-title">
                <h2>How to Become a Distributor</h2>
                <p>Follow these simple steps to start your journey with PaySure</p>
            </div>
            
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Fill Registration Form</h4>
                    <p>Complete our online registration form with your details</p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Upload KYC Documents</h4>
                    <p>Submit proper KYC documents for authentication</p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Make Payment</h4>
                    <p>Pay through our associate product purchase link</p>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Get Activated</h4>
                    <p>After validation, your distributor code will be activated</p>
                </div>
            </div>
        </div>
    </section>

  <?php
include 'includes/footer.php';
?>
</body>
</html>