<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaySure - Download Center</title>
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #2ecc71;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f9f9f9;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(52, 152, 219, 0.8)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h2 {
            font-size: 42px;
            margin-bottom: 20px;
            animation: slideInDown 1s ease;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            animation: slideInUp 1s ease;
        }

        .cta-button {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: var(--transition);
            box-shadow: var(--shadow);
            animation: pulse 2s infinite;
        }

        .cta-button:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title h2 {
            font-size: 36px;
            color: var(--primary);
            display: inline-block;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--secondary);
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 48px;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--primary);
        }

        /* Download Section */
        .download {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
        }

        .download-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .download h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .download p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .download-options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .download-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            width: 250px;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .download-card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .download-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .download-btn {
            display: inline-block;
            background-color: white;
            color: var(--primary);
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: var(--transition);
        }

        .download-btn:hover {
            background-color: var(--light);
            transform: scale(1.05);
        }

        /* Partners Section */
        .partners {
            padding: 80px 0;
            background-color: var(--light);
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .partner-logo {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 120px;
        }

        .partner-logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 32px;
            }

            .download-options {
                flex-direction: column;
                align-items: center;
            }

            .download-card {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h2>Your Partner in Financial Growth & Security</h2>
                <p>Empowering individuals and businesses through smart, trustworthy, and customized financial solutions.</p>
                <a href="#download" class="cta-button">Download Now</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose PaySure?</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-chart-line feature-icon"></i>
                    <h3>Comprehensive Financial Solutions</h3>
                    <p>From investments and insurance to loans and advisory, we cover the entire spectrum of financial needs under one roof.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-handshake feature-icon"></i>
                    <h3>Trusted Partnerships</h3>
                    <p>We collaborate with leading financial institutions ensuring every product we offer is reliable and secure.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-user-tie feature-icon"></i>
                    <h3>Expert Personalized Advisory</h3>
                    <p>Our experienced financial advisors provide tailored strategies that align with your future plans.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-gem feature-icon"></i>
                    <h3>Transparent & Ethical Practices</h3>
                    <p>Integrity is at the heart of everything we do. We believe in clear, honest, and ethical guidance.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users feature-icon"></i>
                    <h3>Client-Centric Approach</h3>
                    <p>Your success is our priority. Every solution we design focuses on your growth and financial security.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-rocket feature-icon"></i>
                    <h3>Continuous Innovation</h3>
                    <p>We stay ahead with modern financial tools, updated market insights, and innovative solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="download" id="download">
        <div class="container">
            <div class="download-content">
                <h2>Download PaySure Resources</h2>
                <p>Access our comprehensive financial guides, product brochures, and application forms to start your journey towards financial freedom.</p>
                
                <div class="download-options">
                    <div class="download-card">
                        <i class="fas fa-file-pdf download-icon"></i>
                        <h3>Product Brochure</h3>
                        <p>Detailed information about our financial products and services.</p>
                        <a href="#" class="download-btn">Download PDF</a>
                    </div>
                    <div class="download-card">
                        <i class="fas fa-file-alt download-icon"></i>
                        <h3>Application Form</h3>
                        <p>Ready to get started? Download our application form here.</p>
                        <a href="#" class="download-btn">Download Form</a>
                    </div>
                    <div class="download-card">
                        <i class="fas fa-book download-icon"></i>
                        <h3>Financial Guide</h3>
                        <p>Comprehensive guide to financial planning and investment.</p>
                        <a href="#" class="download-btn">Download Guide</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners" id="partners">
        <div class="container">
            <div class="section-title">
                <h2>Our Trusted Partners</h2>
            </div>
            <div class="partners-grid">
                <div class="partner-logo">
                    <span>Bajaj Allianz</span>
                </div>
                <div class="partner-logo">
                    <span>Aditya Birla Capital</span>
                </div>
                <div class="partner-logo">
                    <span>Kotak Life</span>
                </div>
                <div class="partner-logo">
                    <span>PNB MetLife</span>
                </div>
                <div class="partner-logo">
                    <span>TATA AIG</span>
                </div>
                <div class="partner-logo">
                    <span>HDFC ERGO</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href*="#"]').on('click', function(e) {
                e.preventDefault();
                
                $('html, body').animate(
                    {
                        scrollTop: $($(this).attr('href')).offset().top - 80,
                    },
                    500,
                    'linear'
                );
            });
            
            // Add animation to feature cards on scroll
            $(window).on('scroll', function() {
                $('.feature-card').each(function() {
                    const position = $(this).offset().top;
                    const scrollPosition = $(window).scrollTop() + $(window).height() * 0.8;
                    
                    if (position < scrollPosition) {
                        $(this).addClass('animated');
                    }
                });
            });
            
            // Trigger scroll event on page load
            $(window).trigger('scroll');
            
            // Add hover effect to download cards
            $('.download-card').hover(
                function() {
                    $(this).find('.download-icon').css('transform', 'scale(1.2)');
                },
                function() {
                    $(this).find('.download-icon').css('transform', 'scale(1)');
                }
            );
        });
    </script>
</body>
</html>