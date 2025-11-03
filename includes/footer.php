<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaySure Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(to bottom, #ffffff, #f1f5f9);
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.03);
            margin-top: 60px;
        }

        .footer-main {
            padding: 60px 0 40px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .footer-section h3 {
            color: #1e3a8a;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: #3b82f6;
            border-radius: 2px;
        }

       .footer-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-logo-img {
    height: 60px;        /* adjust as needed */
    width: auto;
    object-fit: contain;
}

.footer-logo img:hover {
    transform: scale(1.05);
    transition: 0.3s ease;
}

        .logo-placeholder {
            width: 50px;
            height: 50px;
            background: #1e40af;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 4px 6px rgba(30, 64, 175, 0.2);
        }

        .logo-placeholder i {
            color: white;
            font-size: 24px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .footer-description {
            color: #64748b;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #475569;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: #3b82f6;
            transform: translateX(5px);
        }

        .footer-links i {
            margin-right: 10px;
            color: #3b82f6;
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .contact-info i {
            color: #3b82f6;
            margin-right: 12px;
            margin-top: 4px;
            font-size: 16px;
            width: 16px;
            text-align: center;
        }

        .contact-info span {
            color: #475569;
        }

        .newsletter-form {
            display: flex;
            flex-direction: column;
        }

        .newsletter-text {
            color: #64748b;
            margin-bottom: 20px;
        }

        .newsletter-input {
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .newsletter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .subscribe-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .subscribe-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }

        .subscribe-btn i {
            margin-left: 8px;
        }

        .social-section {
            display: flex;
            flex-direction: column;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .social-icon.facebook:hover {
            background: #1877f2;
            color: white;
        }

        .social-icon.twitter:hover {
            background: #1da1f2;
            color: white;
        }

        .social-icon.linkedin:hover {
            background: #0a66c2;
            color: white;
        }

        .social-icon.instagram:hover {
            background: #e4405f;
            color: white;
        }

        .footer-bottom {
            background: #1e293b;
            color: #cbd5e1;
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid #334155;
        }

        .footer-bottom p {
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-main {
                padding: 40px 0 30px;
            }
            
            .social-icons {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .logo-text {
                font-size: 20px;
            }
            
            .footer-section h3 {
                font-size: 16px;
            }
            
            .newsletter-form {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
  

    <footer>
        <div class="container">
            <div class="footer-main">
                <div class="footer-content">
                    <!-- Company Info Section -->
                    <div class="footer-section">
                        <div class="footer-logo">
    <a href="index.php">
        <img src="assets/images/logo.png" alt="PaySure Insurance Logo" class="footer-logo-img">
    </a>
</div>

                        <p class="footer-description">
                            Your trusted partner for comprehensive insurance solutions. We protect what matters most to you with reliable coverage and exceptional service.
                        </p>
                        <div class="social-section">
                            <h3>Follow Us</h3>
                            <div class="social-icons">
                                <a href="#" class="social-icon facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-icon twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-icon linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="social-icon instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Section -->
                    <div class="footer-section">
                        <h3>Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <li><a href="our plans.php"><i class="fas fa-chevron-right"></i> Our Plans</a></li>
                            <li><a href="renew.php"><i class="fas fa-chevron-right"></i> Renew Policy</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Claims</a></li>
                            <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                            <li><a href="faq.php"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info Section -->
                    <div class="footer-section">
                        <h3>Get in Touch</h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>123 Insurance Avenue, Financial District, NY 10001</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>+91 8001454567</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>nirmalya.ghosh@gmail.com</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>Mon - Fri: 9:00 AM - 6:00 PM</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Newsletter Section -->
                    <div class="footer-section">
                        <h3>Newsletter</h3>
                        <p class="newsletter-text">Subscribe to our newsletter for insurance tips, updates, and exclusive offers.</p>
                        <form class="newsletter-form">
                            <input type="email" class="newsletter-input" placeholder="Your email address" required>
                            <button type="submit" class="subscribe-btn">
                                Subscribe <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025 PaySure Insurance. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple animation for footer elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const footerSections = document.querySelectorAll('.footer-section');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            footerSections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(section);
            });
        });
    </script>
</body>
</html>