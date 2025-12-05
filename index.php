<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>PaySure - Financial Security That Grows With You</title>
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0B64B8",
                        "primary-light": "#E8F2FC",
                        "accent": "#2B9AF3",
                        "secondary": "#FF6B35",
                        "tertiary": "#00C9B1",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0F172A",
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E293B",
                        "text-primary": "#1E293B",
                        "text-secondary": "#64748B",
                        "border-light": "#E2E8F0"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.75rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'medium': '0 8px 30px -6px rgba(0, 0, 0, 0.1)',
                        'glow': '0 0 25px -5px rgba(43, 154, 243, 0.3)',
                    }
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @keyframes slide-up {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .animate-slide-up {
            animation: slide-up 0.7s ease-out forwards;
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .carousel-item {
            display: none;
        }
        .carousel-item.active {
            display: block;
            animation: slide-up 1s forwards;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        }
        .dark .gradient-bg {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #0B64B8 0%, #2B9AF3 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(to right, #0B64B8, #2B9AF3);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .section-padding {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        @media (min-width: 768px) {
            .section-padding {
                padding-top: 7rem;
                padding-bottom: 7rem;
            }
        }
        
        /* WhatsApp Icon Styles */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        .whatsapp-tooltip {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .whatsapp-float:hover .whatsapp-tooltip {
            opacity: 1;
        }
        
        .whatsapp-tooltip::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -5px;
            transform: translateY(-50%);
            border-width: 5px 0 5px 5px;
            border-style: solid;
            border-color: transparent transparent transparent #333;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display transition-colors duration-300 text-text-primary dark:text-white">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">

<?php
include 'includes/header.php';
?>

<main class="flex-1">
    <!-- HERO SECTION -->
<!-- Hero Section with Background Image Carousel -->
<section class="relative text-white overflow-hidden flex items-center min-h-screen sm:min-h-[90vh]">

  <!-- Background Carousel Container -->
  <div class="absolute inset-0 z-0">
    <div class="carousel-bg absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100" style="background-image: url('assets/images/hero 1.jpg');"></div>
    <div class="carousel-bg absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" style="background-image: url('assets/images/hero2.jpg');"></div>
    <div class="carousel-bg absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" style="background-image: url('assets/images/hero3.jpg');"></div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/40 to-black/30"></div>
  </div>

  <!-- Main Content -->
  <div class="relative z-10 px-6 md:px-12 lg:px-20 w-full max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center text-center lg:text-left">

      <!-- Left Content -->
      <div>
        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6 mx-auto lg:mx-0">
          <span class="material-symbols-outlined text-sm mr-2">verified</span>
          <span class="text-sm font-medium">Trusted by 50,000+ customers</span>
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
          Financial Security That 
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-100">Grows With You</span>
        </h1>

        <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-xl mx-auto lg:mx-0">
          Insurance, investments and loans — personalised plans, transparent advice for your financial journey.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <button class="flex items-center justify-center rounded-xl h-12 px-8 bg-white text-primary font-bold hover:bg-blue-50 transition-all duration-300 shadow-md transform hover:scale-105 group">
            <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">calculate</span>
            Calculate My Plan
          </button>
          <button class="flex items-center justify-center rounded-xl h-12 px-8 bg-transparent text-white font-bold border-2 border-white/30 hover:border-white transition-all duration-300 transform hover:scale-105 group">
            <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">support_agent</span>
            Talk to an Advisor
          </button>
        </div>
      </div>

      <!-- Right Info Box -->
      <div class="hidden lg:block bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">

        <div class="grid grid-cols-2 gap-4">
          <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
              <span class="material-symbols-outlined text-white">trending_up</span>
            </div>
            <h3 class="font-bold text-white">Investments</h3>
            <p class="text-sm text-blue-100 mt-1">Grow your wealth</p>
          </div>
          <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
              <span class="material-symbols-outlined text-white">shield</span>
            </div>
            <h3 class="font-bold text-white">Insurance</h3>
            <p class="text-sm text-blue-100 mt-1">Protect your family</p>
          </div>
          <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
              <span class="material-symbols-outlined text-white">credit_card</span>
            </div>
            <h3 class="font-bold text-white">Loans</h3>
            <p class="text-sm text-blue-100 mt-1">Flexible financing</p>
          </div>
          <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
              <span class="material-symbols-outlined text-white">account_balance</span>
            </div>
            <h3 class="font-bold text-white">Advisory</h3>
            <p class="text-sm text-blue-100 mt-1">Expert guidance</p>
          </div>
        </div>

        <div class="mt-6 bg-white/5 rounded-xl p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-blue-100">Average annual return</p>
              <p class="text-xl font-bold text-white">10.2%</p>
            </div>
            <div class="text-right">
              <p class="text-sm text-blue-100">Customer satisfaction</p>
              <p class="text-xl font-bold text-white">98%</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Carousel Script -->
<script>
  const slides = document.querySelectorAll('.carousel-bg');
  let index = 0;

  function showNextSlide() {
    slides[index].style.opacity = 0;
    index = (index + 1) % slides.length;
    slides[index].style.opacity = 1;
  }

  setInterval(showNextSlide, 5000);
</script>




<div class="relative w-full overflow-hidden mt-16">
  <div class="flex gap-16 animate-scroll whitespace-nowrap">
    
    <!-- First set of logos -->
    <a href="https://www.bajajallianzlife.com/" target="_blank"><img src="assets/images/bajaj.png" alt="Bajaj Allianz" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.hdfclife.com/" target="_blank"><img src="assets/images/hdfc.png" alt="HDFC Life" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://licindia.in/" target="_blank"><img src="assets/images/Lic.png" alt="LIC" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.careinsurance.com/" target="_blank"><img src="assets/images/Care_health.png" alt="Care Health" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.pnbmetlife.com/" target="_blank"><img src="assets/images/pnb.png" alt="PNB Metlife" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.adityabirlacapital.com/healthinsurance/homepage" target="_blank"><img src="assets/images/Aditya.png" alt="Aditya Birla" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.kotaklife.com/" target="_blank"><img src="assets/images/kotak.png" alt="Kotak Life" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.icicilombard.com/" target="_blank"><img src="assets/images/icici.png" alt="ICICI" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.generalicentralinsurance.com/" target="_blank"><img src="assets/images/future.png" alt="future" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>

    <!-- Duplicate set for smooth loop -->
    <a href="https://www.bajajallianzlife.com/" target="_blank"><img src="assets/images/bajaj.png" alt="Bajaj Allianz" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.hdfclife.com/" target="_blank"><img src="assets/images/hdfc.png" alt="HDFC Life" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://licindia.in/" target="_blank"><img src="assets/images/Lic.png" alt="LIC" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.careinsurance.com/" target="_blank"><img src="assets/images/Care_health.png" alt="Care Health" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.pnbmetlife.com/" target="_blank"><img src="assets/images/pnb.png" alt="PNB Metlife" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.adityabirlacapital.com/healthinsurance/homepage" target="_blank"><img src="assets/images/Aditya.png" alt="Aditya Birla" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.kotaklife.com/" target="_blank"><img src="assets/images/kotak.png" alt="Kotak Life" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.icicilombard.com/" target="_blank"><img src="assets/images/icici.png" alt="ICICI" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
    <a href="https://www.generalicentralinsurance.com/" target="_blank"><img src="assets/images/future.png" alt="future" class="h-10 md:h-12 object-contain opacity-70 hover:opacity-100 transition" /></a>
  </div>
</div>


<!-- Add this CSS (inside <style> tag or external stylesheet) -->
<style>
/* Parent — hide overflow so only visible area shows */
.relative.w-full.overflow-hidden,
.trusted-logos-wrapper {
  position: relative;
  overflow: hidden;
  width: 100%;
}

/* The moving track: must contain two identical groups of logos */
.animate-scroll {
  display: flex;
  gap: 2.5rem;               /* space between each logo item */
  align-items: center;
  width: max-content;        /* important so flex items do not shrink */
  will-change: transform;
  animation: scroll 28s linear infinite;
}

/* Ensure each logo doesn't shrink and stays inline */
.animate-scroll a,
.animate-scroll img {
  flex: 0 0 auto;            /* prevent shrinking; keep natural size */
  display: inline-block;
  vertical-align: middle;
  pointer-events: auto;
}

/* Image sizing — responsive */
.animate-scroll img {
  height: 40px;              /* default mobile size */
  max-height: 48px;
  object-fit: contain;
  opacity: .75;
  transition: opacity .2s ease, transform .15s ease;
}

/* Hover/tap effect */
.animate-scroll a:hover img,
.animate-scroll a:active img {
  opacity: 1;
  transform: translateY(-2px);
}

/* Desktop / larger screens */
@media (min-width: 768px) {
  .animate-scroll img { height: 48px; }
  .animate-scroll { gap: 3.5rem; }
}

/* Accessibility: reduce motion preference */
@media (prefers-reduced-motion: reduce) {
  .animate-scroll { animation: none; }
}

/* Keyframes: translate left by 50% of the track width (works when track = two identical groups) */
@keyframes scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}


</style>


<!-- ===== ABOUT SECTION START ===== -->
<section class="about-section" id="about">
  <div class="about-container">
    <!-- Left Image Area -->
    <div class="about-images scroll-animate">
      <div class="img main-img">
        <img src="assets/images/about-one-img-1.jpg" alt="Team Meeting">
      </div>
      <div class="img sub-img">
        <img src="assets/images/about-img-2.jpg" alt="Team Working">
      </div>
    </div>

    <!-- Right Content Area -->
    <div class="about-content scroll-animate">
      <p class="section-subtitle">>>> Who We Are <<<</p>
      <h2 class="section-title">We provide the best<br>insurance policy</h2>
      <h3 class="section-highlight">Your Partner in Financial Growth &amp; Security.</h3>

      <ul class="about-list">
        <li><span>✔</span> Comprehensive Coverage</li>
        <li><span>✔</span> Affordable Premiums</li>
        <li><span>✔</span> Trusted Support</li>
      </ul>

      <p class="about-text">
        At PaySure, we believe financial well-being is the foundation of a secure and fulfilling life. 
        With this belief at our core, we’ve built a platform that empowers both individuals and businesses 
        through smart, trustworthy, and customized financial solutions.
      </p>

      <a href="about.php" class="btn-discover">Discover More</a>
    </div>
  </div>
</section>

<!-- ===== CSS ===== -->
<style>
/* ---------- Base Layout ---------- */
.about-section {
  padding: 100px 0;
  background: #fff;
  overflow: hidden;
  position: relative;
}

.about-container {
  width: 90%;
  max-width: 1200px;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 60px;
}

/* ---------- Image Section ---------- */
.about-images {
  flex: 1 1 45%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  transform: translateY(60px);
  transition: all 1s ease;
}

.about-images.show {
  opacity: 1;
  transform: translateY(0);
}

.about-images .img {
  border-radius: 15px;
  overflow: hidden;
  position: relative;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.about-images .main-img {
  width: 340px;
  z-index: 2;
}

.about-images .sub-img {
  width: 250px;
  position: absolute;
  left: -60px;
  top: 80px;
  z-index: 1;
  filter: brightness(0.95);
}

.about-images img {
  width: 100%;
  height: auto;
  display: block;
  transition: transform 0.6s ease;
}

.about-images .img:hover img {
  transform: scale(1.05);
}

/* ---------- Text Section ---------- */
.about-content {
  flex: 1 1 50%;
  opacity: 0;
  transform: translateX(60px);
  transition: all 1s ease;
}

.about-content.show {
  opacity: 1;
  transform: translateX(0);
}

.section-subtitle {
  color: #0066cc;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  margin-bottom: 10px;
}

.section-title {
  font-size: 2.5rem;
  color: #111;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 10px;
}

.section-highlight {
  color: #0066cc;
  font-weight: 600;
  margin-bottom: 25px;
}

.about-list {
  list-style: none;
  padding: 0;
  margin-bottom: 25px;
}

.about-list li {
  margin-bottom: 10px;
  font-size: 1.05rem;
  color: #333;
  display: flex;
  align-items: center;
  gap: 10px;
}

.about-list li span {
  color: #00b4d8;
  font-size: 1.3rem;
}

/* ---------- Button ---------- */
.btn-discover {
  display: inline-block;
  background: linear-gradient(90deg, #007bff, #ff007f);
  color: #fff;
  padding: 12px 30px;
  border-radius: 6px;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  transition: all 0.4s ease;
}

.btn-discover:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

/* ---------- Responsive ---------- */
@media (max-width: 992px) {
  .about-container {
    flex-direction: column;
  }
  .about-images .sub-img {
    position: absolute;
    left: -30px;
    top: 50px;
    width: 220px;
  }
  .section-title {
    font-size: 2rem;
  }
}
</style>

<!-- ===== JavaScript Scroll Animation ===== -->
<script>
// Smooth scroll-triggered animation
const animatedElements = document.querySelectorAll('.scroll-animate');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    }
  });
}, { threshold: 0.3 });

animatedElements.forEach(el => observer.observe(el));
</script>
<!-- ===== ABOUT SECTION END ===== -->



<section class="section-padding gradient-bg">
    <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-7xl">

        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-white mb-4">
                Comprehensive Financial 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">
                    Solutions
                </span>
            </h2>
            <p class="text-lg text-text-secondary dark:text-slate-400 max-w-2xl mx-auto">
                We provide a complete range of financial products tailored to your unique needs and goals.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


            <!-- Investment Card -->
            <div class="electric-card bg-white dark:bg-card-dark p-8 rounded-2xl shadow-soft">
                <div class="bg-primary-light dark:bg-primary/10 p-4 rounded-2xl mb-6 w-fit">
                    <span class="material-symbols-outlined text-primary text-3xl">trending_up</span>
                </div>

                <h3 class="text-xl font-bold text-text-primary dark:text-white mb-3">
                    Investments & Wealth
                </h3>

                <p class="text-text-secondary dark:text-slate-400 mb-6">
                    Grow your wealth with our curated investment options including mutual funds, stocks, and fixed deposits.
                </p>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                        Mutual Funds
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                        Fixed Deposits
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                        Stock Market
                    </li>
                </ul>

                <a href="#" class="text-primary font-semibold text-sm flex items-center group">
                    Explore Investments
                    <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>



            <!-- Insurance Card -->
            <div class="electric-card bg-white dark:bg-card-dark p-8 rounded-2xl shadow-soft">
                <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-2xl mb-6 w-fit">
                    <span class="material-symbols-outlined text-secondary text-3xl">shield</span>
                </div>

                <h3 class="text-xl font-bold text-text-primary dark:text-white mb-3">
                    Insurance Protection
                </h3>

                <p class="text-text-secondary dark:text-slate-400 mb-6">
                    Secure your family's future with comprehensive insurance plans for life, health, vehicle, and more.
                </p>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                        Life Insurance
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                        Health Insurance
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                        Vehicle Insurance
                    </li>
                </ul>

                <a href="#" class="text-secondary font-semibold text-sm flex items-center group">
                    Explore Insurance
                    <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>



            <!-- Loans Card -->
            <div class="electric-card bg-white dark:bg-card-dark p-8 rounded-2xl shadow-soft">
                <div class="bg-teal-50 dark:bg-teal-900/20 p-4 rounded-2xl mb-6 w-fit">
                    <span class="material-symbols-outlined text-tertiary text-3xl">real_estate_agent</span>
                </div>

                <h3 class="text-xl font-bold text-text-primary dark:text-white mb-3">
                    Loans & Credit
                </h3>

                <p class="text-text-secondary dark:text-slate-400 mb-6">
                    Access flexible financing options for personal needs, home purchases, business expansion, and more.
                </p>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-tertiary text-lg mr-3">check_circle</span>
                        Personal Loans
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-tertiary text-lg mr-3">check_circle</span>
                        Home Loans
                    </li>
                    <li class="flex items-center text-text-secondary dark:text-slate-400">
                        <span class="material-symbols-outlined text-tertiary text-lg mr-3">check_circle</span>
                        Business Loans
                    </li>
                </ul>

                <a href="#" class="text-tertiary font-semibold text-sm flex items-center group">
                    Explore Loans
                    <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

        </div>

    </div>
</section>


<style>
 /* ===========================
   STYLE A – ELECTRIC GLOW BORDER
   =========================== */
.electric-card {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}

.electric-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 2px;
    background: linear-gradient(
        135deg,
        #00eaff,
        #009dff,
        #00eaff
    );
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    mask:
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;

    animation: electricBorderMove 4s linear infinite;
    opacity: 0.9;
}

@keyframes electricBorderMove {
    0% { filter: hue-rotate(0deg); }
    50% { filter: hue-rotate(180deg); }
    100% { filter: hue-rotate(360deg); }
}

/* Outer glow */
.electric-card::after {
    content: "";
    position: absolute;
    inset: -10px;
    border-radius: 30px;
    background: radial-gradient(
        circle,
        rgba(0, 200, 255, 0.5),
        transparent 60%
    );
    filter: blur(20px);
    animation: electricPulse 3s ease-in-out infinite alternate;
}

@keyframes electricPulse {
    0% { opacity: 0.4; }
    100% { opacity: 0.9; }
}

/* Hover effect for electric card */
.electric-card {
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.electric-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 20px 40px rgba(0, 200, 255, 0.25);
}

/* Make electric glow stronger on hover */
.electric-card:hover::after {
    opacity: 1;
    filter: blur(25px);
}

.electric-card:hover::before {
    opacity: 1;
}

</style>

    <!-- LOWEST PRICE GUARANTEE SECTION -->
    <section class="section-padding bg-white dark:bg-slate-900/50">
        <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content Column -->
                <div class="animate-fade-in">
                    <div class="inline-flex items-center bg-primary-light dark:bg-primary/10 text-primary rounded-full px-4 py-2 mb-6">
                        <span class="material-symbols-outlined text-sm mr-2">verified</span>
                        <span class="text-sm font-medium">Price Match Guarantee</span>
                    </div>
                    
                    <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-white mb-6">
                        Lowest Price <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Guarantee</span>
                    </h2>
                    
                    <p class="text-lg text-text-secondary dark:text-slate-400 mb-8">
                        We promise the most competitive rates in the market. If you find a lower price elsewhere, we'll match it and give you an additional discount.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center p-4 bg-primary-light dark:bg-primary/5 rounded-xl border border-border-light dark:border-slate-700">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-4">
                                <span class="material-symbols-outlined text-primary">verified</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-text-primary dark:text-white">0% GST on All Plans</h4>
                                <p class="text-sm text-text-secondary dark:text-slate-400">Complete tax savings</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-orange-50 dark:bg-orange-900/10 rounded-xl border border-border-light dark:border-slate-700">
                            <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center mr-4">
                                <span class="material-symbols-outlined text-secondary">family_restroom</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-text-primary dark:text-white">In-built Life Cover</h4>
                                <p class="text-sm text-text-secondary dark:text-slate-400">Automatic protection</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <button class="flex items-center justify-center rounded-xl h-12 px-6 bg-gradient-to-r from-primary to-accent text-white text-sm font-bold hover:shadow-glow transition-all duration-300 shadow-md transform hover:scale-105 group">
                            <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">verified_user</span>
                            Claim Your Discount
                        </button>
                        <button class="flex items-center justify-center rounded-xl h-12 px-6 bg-white dark:bg-card-dark text-text-primary dark:text-white text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300 shadow-md transform hover:scale-105 border border-border-light dark:border-slate-700 group">
                            <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">compare</span>
                            Compare Plans
                        </button>
                    </div>
                </div>
                
                <!-- Insurance Products Column -->
                <div class="animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-8 shadow-soft border border-border-light dark:border-slate-700">
                        <h3 class="text-2xl font-bold text-text-primary dark:text-white mb-6 text-center">Our Insurance Products</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <h4 class="font-bold text-primary text-lg mb-3">Life & Health Insurance</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                                        Term Life Insurance
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                                        Health Insurance
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                                        Family Health Plans
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-primary text-lg mr-3">check_circle</span>
                                        Retirement Plans
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-4">
                                <h4 class="font-bold text-secondary text-lg mb-3">General Insurance</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                                        Car Insurance
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                                        Bike Insurance
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                                        Travel Insurance
                                    </li>
                                    <li class="flex items-center text-text-secondary dark:text-slate-300">
                                        <span class="material-symbols-outlined text-secondary text-lg mr-3">check_circle</span>
                                        Commercial Insurance
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-medium">
                                <span class="material-symbols-outlined text-lg mr-2">verified</span>
                                All plans come with our Lowest Price Guarantee
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT WE OFFER SECTION -->
    <section class="section-padding bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-blue-900/20">
        <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-white mb-4">What We <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Offer</span></h2>
                <p class="text-lg text-text-secondary dark:text-slate-400 max-w-2xl mx-auto">Discover our comprehensive suite of financial services designed to meet all your financial needs.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Service 1 -->
                <div class="bg-white dark:bg-card-dark p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-light dark:bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">trending_up</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Smart Investments</h3>
                    <p class="text-sm text-text-secondary dark:text-slate-400">Expertly curated investment portfolios for optimal growth and returns.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="bg-white dark:bg-card-dark p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                    <div class="w-16 h-16 rounded-full bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-secondary text-2xl">shield</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Complete Protection</h3>
                    <p class="text-sm text-text-secondary dark:text-slate-400">Comprehensive insurance coverage for life, health, and assets.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="bg-white dark:bg-card-dark p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                    <div class="w-16 h-16 rounded-full bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-tertiary text-2xl">credit_card</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Flexible Loans</h3>
                    <p class="text-sm text-text-secondary dark:text-slate-400">Tailored loan solutions with competitive rates and easy approvals.</p>
                </div>
                
                <!-- Service 4 -->
                <div class="bg-white dark:bg-card-dark p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                    <div class="w-16 h-16 rounded-full bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-purple-500 text-2xl">account_balance</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Expert Advisory</h3>
                    <p class="text-sm text-text-secondary dark:text-slate-400">Personalized financial guidance from certified experts.</p>
                </div>
            </div>
            
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mr-4 flex-shrink-0">
                        <span class="material-symbols-outlined text-primary">support_agent</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-text-primary dark:text-white mb-2">24/7 Customer Support</h4>
                        <p class="text-text-secondary dark:text-slate-400 text-sm">Round-the-clock assistance for all your financial queries and concerns.</p>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center mr-4 flex-shrink-0">
                        <span class="material-symbols-outlined text-secondary">security</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-text-primary dark:text-white mb-2">Secure & Trusted</h4>
                        <p class="text-text-secondary dark:text-slate-400 text-sm">Bank-level security and trusted partnerships with leading financial institutions.</p>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-tertiary/10 flex items-center justify-center mr-4 flex-shrink-0">
                        <span class="material-symbols-outlined text-tertiary">payments</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-text-primary dark:text-white mb-2">Transparent Pricing</h4>
                        <p class="text-text-secondary dark:text-slate-400 text-sm">No hidden charges with complete transparency in all our financial products.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section class="section-padding gradient-bg">
        <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-7xl">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-text-primary dark:text-white mb-4">How It Works in <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">4 Simple Steps</span></h2>
            <p class="text-lg text-text-secondary dark:text-slate-400 text-center max-w-2xl mx-auto mb-16">Getting started with PaySure is easy. Follow these simple steps to secure your financial future.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-2xl">checklist</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-md">1</div>
                    </div>
                    <h4 class="font-bold text-text-primary dark:text-white">Choose Plan</h4>
                    <p class="text-sm text-text-secondary dark:text-slate-400 mt-2">Select the best plan for your financial needs and goals.</p>
                </div>
                
                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-secondary to-orange-400 flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-2xl">payments</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm shadow-md">2</div>
                    </div>
                    <h4 class="font-bold text-text-primary dark:text-white">Pay Premium</h4>
                    <p class="text-sm text-text-secondary dark:text-slate-400 mt-2">Easily pay your premium through our secure payment channels.</p>
                </div>
                
                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-tertiary to-teal-400 flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-2xl">account_balance_wallet</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-tertiary text-white flex items-center justify-center font-bold text-sm shadow-md">3</div>
                    </div>
                    <h4 class="font-bold text-text-primary dark:text-white">Receive Income</h4>
                    <p class="text-sm text-text-secondary dark:text-slate-400 mt-2">Get regular payouts or a lump sum as per your selected plan.</p>
                </div>
                
                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-2xl">shield</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-purple-500 text-white flex items-center justify-center font-bold text-sm shadow-md">4</div>
                    </div>
                    <h4 class="font-bold text-text-primary dark:text-white">Secure Future</h4>
                    <p class="text-sm text-text-secondary dark:text-slate-400 mt-2">Enjoy financial security and peace of mind for years to come.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- PB ADVANTAGE SECTION -->
    <section class="section-padding bg-white dark:bg-slate-900/50">
    <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-white mb-4">PB <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Advantage</span></h2>
            <p class="text-lg text-text-secondary dark:text-slate-400 max-w-3xl mx-auto">When you buy insurance from us, you get more than just financial safety. You also get: our promise of simplifying complex insurance terms and conditions, quick stress-free claims, instant quotes from top insurers and being present for you in the toughest of times.</p>
            
            <button id="openModalBtn" class="mt-6 flex items-center justify-center rounded-xl h-12 px-6 bg-primary text-white text-sm font-bold hover:shadow-glow transition-all duration-300 shadow-md transform hover:scale-105 group mx-auto">
                <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">info</span>
                Know More
            </button>
            </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-blue-900/20 p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                <div class="w-16 h-16 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-green-500 text-2xl">savings</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">One of the best Prices</h3>
                <p class="text-sm text-text-secondary dark:text-slate-400 font-semibold">Guaranteed</p>
            </div>
            
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-blue-900/20 p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                <div class="w-16 h-16 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-blue-500 text-2xl">balance</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Unbiased Advice</h3>
                <p class="text-sm text-text-secondary dark:text-slate-400 font-semibold">Keeping customers first</p>
            </div>
            
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-blue-900/20 p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                <div class="w-16 h-16 rounded-full bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-purple-500 text-2xl">verified</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">100% Reliable</h3>
                <p class="text-sm text-text-secondary dark:text-slate-400 font-semibold">Regulated by IRDAI</p>
            </div>
            
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-blue-900/20 p-6 rounded-2xl shadow-soft card-hover border border-border-light dark:border-slate-700 text-center">
                <div class="w-16 h-16 rounded-full bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-orange-500 text-2xl">support_agent</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-white mb-2">Claims Support</h3>
                <p class="text-sm text-text-secondary dark:text-slate-400 font-semibold">Made stress-free</p>
            </div>
        </div>
        
    </div>
</section>
<div id="knowMoreModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-3xl w-full max-h-[90vh] flex flex-col">
        
        <div class="flex items-center justify-between p-5 md:p-6 border-b border-border-light dark:border-slate-700">
            <h3 class="text-xl md:text-2xl font-bold text-text-primary dark:text-white">
                Buy Insurance at PaySureInsurance.com
            </h3>
            <button id="closeModalBtn" class="text-slate-400 hover:text-red-600 dark:hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined text-3xl">close</span>
            </button>
        </div>
        
        <div class="p-5 md:p-8 overflow-y-auto space-y-4 text-text-secondary dark:text-slate-400">
            <p>Based out of Kolkata, West Bengal, PaySure Insurance is a trusted insurance service provider approved by IRDA of India. We offer a secure online platform for insurance buyers where they can easily compare different insurance policies such as car insurance, life insurance, bike insurance, term insurance, pension plans, and more. Customers can make an informed choice within a few clicks—right from the comfort of their home.</p>

            <p>As the insurance sector continues to evolve, PaySure Insurance has also taken proactive steps to provide advanced insurance solutions, including coronavirus term insurance and coronavirus health insurance plans.</p>

            <p>Moreover, in accordance with IRDAI regulations, all health and general insurers are now offering two specific products—Corona Kavach Policy and Corona Rakshak Policy. These policies provide coverage for COVID-19 hospitalization, home treatment, AYUSH treatment, and the cost of PPE kits and other medical consumables.</p>

            <p>IRDAI has also introduced another standard health insurance policy for people who prefer affordable premium options. Such customers can buy the Arogya Sanjeevani Policy directly through PaySureInsurance.com.</p>

            <p>By comparing online, applicants can easily find the best health insurance plans and term insurance plans—completely free of cost. We have partnered with 50+ top insurance companies across India to bring a wide range of insurance options. With the use of smart technology, PaySure Insurance makes the insurance-buying process faster, simpler, and more transparent.</p>

            <h4 class="text-xl font-semibold text-text-primary dark:text-white pt-2">What’s More?</h4>
            <p>Apart from buying insurance online, existing policyholders can renew insurance plans, file claims, and track their policy status seamlessly. Additionally, users can explore top-performing investment plans, mutual funds, and tax-saving options directly through our platform.</p>
            <p>At PaySure, you can compare life insurance quotes and explore detailed information on various plans such as the best term insurance plans, NRI term insurance, LIC term plans, HDFC child plans, LIC pension plans, and much more—whichever best fits your financial goals and needs.</p>
            <p>Our primary objective is to help insurance applicants make well-informed decisions when they buy a policy online. Every insurance company offers a variety of plans to meet different needs, and at PaySure, you can compare them based on features, benefits, coverage, and premium rates to find the perfect fit.</p>

            <h4 class="text-xl font-semibold text-text-primary dark:text-white pt-2">Our Insurance Categories</h4>
            <p>Our platform showcases insurance plans offered by 50+ leading public and private insurers in India, divided mainly into two categories:</p>

            <h5 class="text-lg font-semibold text-text-primary dark:text-white">1. Life Insurance</h5>
            <p>Life insurance is a contract between the insurer and the policyholder. Under this plan, the insurer promises to provide financial protection in exchange for regular premium payments. In case of the policyholder’s unfortunate demise during the policy term, the insurer pays the chosen death benefit as per the terms and conditions. Besides life coverage, many life insurance plans also provide wealth creation and tax-saving benefits.</p>
            <p>Life Insurance includes:</p>
            <ul class="list-disc list-inside pl-4 space-y-1">
                <li>Term Life Insurance Plans</li>
                <li>Whole Life Policies</li>
                <li>Endowment Plans</li>
                <li>NRI Investment Plans</li>
                <li>Money Back Plans</li>
                <li>ULIPs (Unit Linked Insurance Plans)</li>
                <li>Child Plans</li>
                <li>Investment & Retirement Plans</li>
            </ul>

            <h5 class="text-lg font-semibold text-text-primary dark:text-white pt-2">2. General Insurance</h5>
            <p>General insurance, also called non-life insurance, includes all types of insurance other than life insurance. It offers pre-decided coverage to the insured in exchange for a specific premium amount. Depending on the policy, general insurance can cover damage, loss, or risk related to health, vehicles, property, or travel.</p>
            <p>General Insurance includes:</p>
            <ul class="list-disc list-inside pl-4 space-y-1">
                <li>Car Insurance</li>
                <li>Health Insurance</li>
                <li>Two-Wheeler Insurance</li>
                <li>Travel Insurance</li>
                <li>Home Insurance</li>
                <li>Corporate Insurance</li>
                <li>Critical Illness Cover</li>
                <li>Personal Accident Insurance</li>
            </ul>

            <h4 class="text-xl font-semibold text-text-primary dark:text-white pt-2">Our Partners</h4>
            <p>Our partners come from diverse sectors such as motor, term, health, travel, and corporate insurance. Through these partnerships, PaySure Insurance serves as a one-stop solution for all your insurance needs.</p>

            <h4 class="text-xl font-semibold text-text-primary dark:text-white pt-2">Benefits of Buying/Renewing Insurance through PaySure Insurance</h4>
            <ul class="space-y-3">
                <li><strong class="text-text-primary dark:text-white">✅ Quick Decision Making:</strong> Our online platform helps you make informed insurance decisions easily and conveniently. You can compare costs, features, and benefits of multiple policies in seconds and shortlist the plan that suits your lifestyle.</li>
                <li><strong class="text-text-primary dark:text-white">💰 High Coverage at Low Premium:</strong> Compared to offline methods, PaySure offers higher coverage at lower premiums. With no agents involved, there are no commission charges—allowing you to buy policies at the most affordable rates. At PaySure, you can compare premium rates from top insurers like LIC, HDFC Life, ICICI Lombard, and more to make a smart, informed choice.</li>
                <li><strong class="text-text-primary dark:text-white">⚙️ Seamless Navigation:</strong> Our robust technology ensures a smooth and quick insurance application experience. Online forms adapt dynamically to your demographics and profile, making the process effortless.</li>
                <li><strong class="text-text-primary dark:text-white">🧮 Error-Free Calculation:</strong> All insurance quotes are system-generated, ensuring 100% accuracy and eliminating human error. Plus, the premium calculation process is instant and transparent.</li>
            </ul>
        </div>

    </div>
</div>


  <!-- CTA SECTION -->
    <section class="section-padding gradient-bg">
        <div class="px-4 md:px-8 lg:px-16 mx-auto max-w-4xl text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-white mb-6">Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">Secure Your Future</span>?</h2>
            <p class="text-lg text-text-secondary dark:text-slate-400 mb-8 max-w-2xl mx-auto">Join thousands of satisfied customers who have already taken the first step towards financial security with PaySure.</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <button class="flex items-center justify-center rounded-xl h-12 px-8 bg-gradient-to-r from-primary to-accent text-white text-base font-bold hover:shadow-glow transition-all duration-300 shadow-md transform hover:scale-105 group">
                    <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">rocket_launch</span>
                    Get Started Today
                </button>
                <button class="flex items-center justify-center rounded-xl h-12 px-8 bg-white dark:bg-card-dark text-text-primary dark:text-white text-base font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300 shadow-md transform hover:scale-105 border border-border-light dark:border-slate-700 group">
                    <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">support_agent</span>
                    Schedule a Call
                </button>
            </div>
            <p class="text-sm text-text-secondary dark:text-slate-400 mt-6">No commitment. No hidden fees. 100% transparent.</p>
        </div>
    </section>

</main>

<!-- WhatsApp Floating Icon -->
<a href="https://wa.me/917908273202?text=Hi%20PaySure%2C%20I%20would%20like%20to%20know%20more%20about%20your%20financial%20services" 
   class="whatsapp-float" 
   target="_blank"
   aria-label="Chat with us on WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12.017 2.047c-5.502 0-9.969 4.467-9.969 9.979 0 1.762.46 3.484 1.333 4.994l-1.395 5.084 5.195-1.363c1.463.783 3.102 1.195 4.777 1.195 5.515 0 9.981-4.466 9.981-9.978 0-5.513-4.466-9.979-9.981-9.979zm5.687 13.812c-.147.417-.867.762-1.213.802-.325.044-.741.063-1.169-.069-.288-.09-.649-.21-1.123-.412-1.926-.822-3.187-2.737-3.284-2.863-.097-.126-.78-1.037-.78-1.978 0-.941.484-1.399.681-1.623.178-.2.388-.25.517-.25l.378.006c.122.006.278-.037.434.275.178.356.597 1.234.647 1.324.05.09.1.206.025.325-.075.119-.113.206-.225.325-.112.119-.237.275-.338.375-.131.131-.269.275-.116.525.153.25.675 1.081 1.453 1.75.988.856 1.819 1.119 2.069 1.244.25.125.397.106.544-.063.147-.169.631-.738.8-.988.169-.25.338-.206.569-.119.231.088 1.456.688 1.706.813.25.125.419.188.481.294.063.106.063.606-.084 1.022z"/>
    </svg>
    <span class="whatsapp-tooltip">Chat with us on WhatsApp</span>
</a>

<!-- Footer would go here -->
 <?php
include 'includes/footer.php';
?>
</div>
</div>

<script>
    // Simple carousel functionality
    const carouselContainer = document.querySelector('.carousel-container');
    if (carouselContainer) {
        const items = carouselContainer.querySelectorAll('.carousel-item');
        let currentIndex = 0;
        
        function showItem(index) {
            items.forEach((item, i) => {
                item.classList.remove('active');
                if (i === index) {
                    item.classList.add('active');
                }
            });
        }
        
        function nextItem() {
            currentIndex = (currentIndex + 1) % items.length;
            showItem(currentIndex);
        }
        
        setInterval(nextItem, 4000); // Change slide every 4 seconds
    }
</script>

<script>
  // Get the modal and the buttons
  const modal = document.getElementById('knowMoreModal');
  const openBtn = document.getElementById('openModalBtn');
  const closeBtn = document.getElementById('closeModalBtn');

  // Function to open the modal
  function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex'); // Use flex to center it
  }

  // Function to close the modal
  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  // Add click event listeners
  openBtn.addEventListener('click', openModal);
  closeBtn.addEventListener('click', closeModal);

  // Also close the modal if the user clicks on the dark overlay
  modal.addEventListener('click', function(event) {
    // Check if the click was on the overlay itself (event.target) and not the content box
    if (event.target === modal) {
      closeModal();
    }
  });
</script>

</body>
</html>