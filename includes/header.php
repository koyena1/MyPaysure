<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Portal Header</title>
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
:root{
  --primary:#2563eb;
  --bg-white:#ffffff;
  --bg-light:#f8fafc;
  --text-dark:#1e293b;
  --border:#e2e8f0;
  --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08);
}

/* header base (you already had similar) */
.header { position: sticky; top:0; z-index:1000; background:var(--bg-white); border-bottom:1px solid var(--border); }
.header-container{ max-width:1200px; margin:0 auto; padding:0 1.5rem; }
.header-content{ display:flex; align-items:center; justify-content:space-between; height:70px; }

/* logo */
.logo { text-decoration: none; color: inherit; } .logo-container { display: flex; align-items: center; gap: 10px; /* space between image and text */ } .logo-img { width: 45px; /* adjust size as needed */ height: 45px; object-fit: contain; } .logo-text { display: flex; flex-direction: column; line-height: 1.2; } .logo-title { font-size: 16px; font-weight: bold; color: #ff6600; /* or your brand color */ } .logo-subtitle { font-size: 10px; color: #555; }

/* main nav */
.nav-menu{ display:flex; align-items:center; gap:1rem; margin-left:auto; }

/* Links */
.nav-link{
  display:inline-flex;
  align-items:center;
  gap:.4rem;
  padding:.35rem .55rem;
  color:var(--text-dark);
  text-decoration:none;
  font-size:.95rem;
  border-radius:6px;
  transition: background .15s, color .15s, transform .08s;
}
.nav-link:hover{ background:var(--bg-light); color:var(--primary); }

/* small caret used on simple links */
.small-caret{ font-size:0.7rem; margin-left:4px; color:inherit; }

/* dropdown wrapper */
.dropdown-wrapper{ position:relative; }

/* dropdown toggle button (looks like link) */
.dropdown-toggle{
  background:none;
  border:0;
  cursor:pointer;
  padding:.35rem .55rem;
  display:inline-flex;
  align-items:center;
  gap:.4rem;
  font-size:.95rem;
  border-radius:6px;
  color:var(--text-dark);
}
.dropdown-toggle:focus{ outline:2px solid rgba(37,99,235,0.15); }

/* caret rotation */
.caret{ transition: transform .22s ease; font-size:0.85rem; color:inherit; }

/* dropdown panel */
.dropdown{
  position:absolute;
  top:calc(100% + 10px);
  left:0;
  min-width:260px;
  background:var(--bg-white);
  border-radius:8px;
  box-shadow:var(--shadow-lg);
  padding:.5rem 0;
  opacity:0;
  visibility:hidden;
  transform:translateY(6px);
  transition: opacity .18s ease, transform .18s ease, visibility .18s;
  z-index:150;
}

/* reveal on hover (desktop) */
@media (hover: hover) and (pointer: fine){
  .dropdown-wrapper:hover .dropdown{ opacity:1; visibility:visible; transform:translateY(0); }
  .dropdown-wrapper:hover .caret{ transform:rotate(180deg); }
}

/* reveal class for JS toggling */
.dropdown.open{ opacity:1; visibility:visible; transform:translateY(0); }

/* dropdown items */
.dropdown-item{
  display:flex;
  align-items:center;
  gap:.75rem;
  padding:.6rem 1rem;
  color:var(--text-dark);
  text-decoration:none;
  font-size:.92rem;
  transition: background .12s, color .12s;
}
.dropdown-item:hover{ background:var(--bg-light); color:var(--primary); }

/* left icon */
.dropdown-icon{
  width:30px; height:30px; display:flex; align-items:center; justify-content:center;
  border-radius:6px; background: #fff; color:var(--primary); font-size:1rem;
  flex-shrink:0;
}

/* header inline action buttons */
.header-actions-inline{ display:flex; gap:.6rem; align-items:center; margin-left:1rem; }
.btn-expert-inline{
  border:1px solid var(--primary); color:var(--primary); padding:.35rem .7rem; border-radius:6px; font-weight:600;
  display:inline-flex; align-items:center; gap:.45rem;
}
.btn-expert-inline:hover{ background:var(--primary); color:#fff; }
.btn-login-inline{ border:1px solid var(--border); padding:.35rem .6rem; border-radius:6px; color:var(--text-dark); }

/* mobile adjustments */
.mobile-menu-btn{ display:none; background:none; border:0; font-size:1.2rem; cursor: pointer; }

/* Mobile menu styles */
@media (max-width: 768px){
  .nav-menu{ 
    display: none; 
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-white);
    flex-direction: column;
    padding: 1rem;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    border-top: 1px solid var(--border);
    gap: 0.5rem;
  }
  
  .nav-menu.active {
    display: flex;
  }
  
  .mobile-menu-btn{ display:block; }
  
  /* Adjust dropdowns for mobile */
  .dropdown {
    position: static;
    box-shadow: none;
    background: var(--bg-light);
    border-radius: 6px;
    margin-top: 0.5rem;
    padding: 0.5rem;
    opacity: 1;
    visibility: visible;
    transform: none;
    display: none;
  }
  
  .dropdown.open {
    display: block;
  }
  
  .header-actions-inline {
    margin-left: 0;
    flex-direction: column;
    width: 100%;
  }
  
  .btn-expert-inline,
  .btn-login-inline {
    width: 100%;
    justify-content: center;
  }
  
  /* Expert dropdown adjustments for mobile */
  .expert-dropdown {
    position: static;
    box-shadow: none;
    background: var(--bg-light);
    border-radius: 6px;
    margin-top: 0.5rem;
    padding: 0.5rem;
    opacity: 1;
    visibility: visible;
    transform: none;
    display: none;
  }
  
  .expert-dropdown.open {
    display: block;
  }
}

/* Talk to Expert dropdown */
.expert-wrapper {
  position: relative;
}

.expert-dropdown {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  min-width: 270px;
  background: var(--bg-white);
  border-radius: 8px;
  box-shadow: var(--shadow-lg);
  padding: 0.6rem 0;
  opacity: 0;
  visibility: hidden;
  transform: translateY(6px);
  transition: opacity .18s ease, transform .18s ease, visibility .18s;
  z-index: 200;
}

/* Show dropdown on hover */
.expert-wrapper:hover .expert-dropdown {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

/* Dropdown items */
.expert-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: .6rem 1rem;
}

.expert-icon {
  font-size: 1.2rem;
  color: var(--primary);
  flex-shrink: 0;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.expert-text p {
  font-size: 0.85rem;
  color: #555;
  margin: 0;
}

.expert-text h4 {
  font-size: 0.95rem;
  font-weight: 600;
  margin: 2px 0 0 0;
  color: var(--text-dark);
}

.expert-dropdown hr {
  margin: 0.4rem 0;
  border: none;
  border-top: 1px solid var(--border);
}

</style>
</head>
<body>
<!-- Font Awesome for icons (replace with your kit/link if needed) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<header class="header">
  <div class="header-container">
    <div class="header-content">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <div class="logo-container">
          <img src="assets/images/logo.png" alt="PaySure Logo" class="logo-img">
          <div class="logo-text">
            <div class="logo-title">PaySure</div>
            <div class="logo-subtitle">Financial Security</div>
          </div>
        </div>
      </a>

      <!-- Nav -->
      <nav class="nav-menu" aria-label="Main Navigation">
        <!-- <a href="insuprod.php" class="nav-link">Insurance Products <i class="fa-solid fa-chevron-down small-caret"></i></a> -->
          <a href="index.php" class="nav-link">Home</a>
          <a href="about.php" class="nav-link">About Us</a>
        <!-- Renew dropdown wrapper -->
        <div class="nav-item dropdown-wrapper">
          <button class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            Products
            <i class="fa-solid fa-chevron-down caret"></i>
          </button>

          <div class="dropdown" role="menu" aria-hidden="true">
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-umbrella"></i></div>
              <div class="dropdown-text">Term Life Renewal</div>
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-piggy-bank"></i></div>
              <div class="dropdown-text">Investment Renewal</div>
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-heart"></i></div>
              <div class="dropdown-text">Health Renewal</div>
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-car"></i></div>
              <div class="dropdown-text">Motor Renewal</div>
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-motorcycle"></i></div>
              <div class="dropdown-text">Two Wheeler Renewal</div>
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-home"></i></div>
              <div class="dropdown-text">Home Insurance Renewal</div>
            </a>
          </div>
        </div>

        <a href="Smart Opportunity.php" class="nav-link">Smart Opportunity</a>
      <div class="nav-item dropdown-wrapper">
          <button class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            More
            <i class="fa-solid fa-chevron-down caret"></i>
          </button>

          <div class="dropdown" role="menu" aria-hidden="true">
            <!-- <a href="Smart Opportunity.php" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-lightbulb"></i></div>
              <div class="dropdown-text">Smart Opportunity</div>
            </a> -->
            <a href="Offers.php" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-gift"></i></div>
              <div class="dropdown-text">Offers</div>
            </a>
            <a href="Gallery.php" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-images"></i></div>
              <div class="dropdown-text">Gallery</div>
            </a>
            <a href="Training Schedule.php" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-calendar-alt"></i></div>
              <div class="dropdown-text">Training Schedule</div>
            </a>
            <a href="download.php" class="dropdown-item" role="menuitem">
              <div class="dropdown-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
              <div class="dropdown-text">Download center</div>
            </a>
          </div>
        </div>
        
        
        <a href="contact.php" class="nav-link">Contact</a>

        <!-- Right-side action buttons -->
        <div class="header-actions-inline">
          <div class="dropdown-wrapper expert-wrapper">
            <a href="#" class="nav-link btn-expert-inline">
              <i class="fa-solid fa-phone"></i> Talk to Expert
            </a>
            <div class="dropdown expert-dropdown">
              <div class="expert-item">
                <i class="fa-solid fa-headset expert-icon"></i>
                <div class="expert-text">
                  <p>Helpline for buying a new policy</p>
                  <h4>1800-208-8787</h4>
                </div>
              </div>
              <hr>
              <div class="expert-item">
                <i class="fa-solid fa-gear expert-icon"></i>
                <div class="expert-text">
                  <p>Helpline for existing policy</p>
                  <h4>1800-258-5970</h4>
                </div>
              </div>
              <hr>
              <div class="expert-item">
                <i class="fa-solid fa-file-invoice expert-icon"></i>
                <div class="expert-text">
                  <p>Helpline for claim</p>
                  <h4>1800-258-5881</h4>
                </div>
              </div>
            </div>
          </div>

          <a href="#" class="nav-link btn-login-inline">Sign in</a>
        </div>
      </nav>

      <!-- mobile button (hidden on desktop) -->
      <button class="mobile-menu-btn" aria-label="Open menu" id="mobileMenuBtn"><i class="fa-solid fa-bars"></i></button>
    </div>
  </div>
</header>

<script>
  // Mobile menu toggle functionality
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuBtn && navMenu) {
      mobileMenuBtn.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        
        // Toggle between hamburger and close icon
        const icon = this.querySelector('i');
        if (navMenu.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
          this.setAttribute('aria-label', 'Close menu');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
          this.setAttribute('aria-label', 'Open menu');
        }
      });
    }
    
    // Close menu when clicking outside on mobile
    document.addEventListener('click', function(event) {
      if (window.innerWidth <= 768 && navMenu && navMenu.classList.contains('active')) {
        if (!navMenu.contains(event.target) && event.target !== mobileMenuBtn && !mobileMenuBtn.contains(event.target)) {
          navMenu.classList.remove('active');
          const icon = mobileMenuBtn.querySelector('i');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
          mobileMenuBtn.setAttribute('aria-label', 'Open menu');
        }
      }
    });
    
    // Handle dropdowns on mobile
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          const dropdown = this.nextElementSibling;
          if (dropdown && dropdown.classList.contains('dropdown')) {
            dropdown.classList.toggle('open');
            
            // Toggle caret rotation
            const caret = this.querySelector('.caret');
            if (caret) {
              if (dropdown.classList.contains('open')) {
                caret.style.transform = 'rotate(180deg)';
              } else {
                caret.style.transform = '';
              }
            }
          }
        }
      });
    });
    
    // Handle expert dropdown on mobile
    const expertLink = document.querySelector('.btn-expert-inline');
    if (expertLink) {
      expertLink.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          const expertDropdown = this.nextElementSibling;
          if (expertDropdown && expertDropdown.classList.contains('expert-dropdown')) {
            expertDropdown.classList.toggle('open');
          }
        }
      });
    }
  });

  // Existing dropdown functionality for desktop
  (function(){
    // Elements
    const wrapper = document.querySelector('.dropdown-wrapper');
    if(!wrapper) return;

    const toggle = wrapper.querySelector('.dropdown-toggle');
    const panel = wrapper.querySelector('.dropdown');
    const caret = wrapper.querySelector('.caret');

    // Toggle function (for click / touch devices)
    function toggleDropdown(e){
      // Only run on desktop
      if (window.innerWidth <= 768) return;
      
      const isOpen = panel.classList.contains('open');
      if(isOpen){
        panel.classList.remove('open');
        toggle.setAttribute('aria-expanded','false');
        panel.setAttribute('aria-hidden','true');
        if(caret) caret.style.transform = '';
      } else {
        panel.classList.add('open');
        toggle.setAttribute('aria-expanded','true');
        panel.setAttribute('aria-hidden','false');
        if(caret) caret.style.transform = 'rotate(180deg)';
      }
    }

    // Click to toggle (desktop only)
    toggle.addEventListener('click', function(e){
      if (window.innerWidth > 768) {
        e.preventDefault();
        e.stopPropagation();
        toggleDropdown();
      }
    });

    // Close on outside click (desktop only)
    document.addEventListener('click', function(e){
      if (window.innerWidth > 768 && !wrapper.contains(e.target)){
        if(panel.classList.contains('open')){
          panel.classList.remove('open');
          toggle.setAttribute('aria-expanded','false');
          panel.setAttribute('aria-hidden','true');
          if(caret) caret.style.transform = '';
        }
      }
    });

    // Close on ESC for accessibility
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape'){
        if(panel.classList.contains('open')){
          panel.classList.remove('open');
          toggle.setAttribute('aria-expanded','false');
          panel.setAttribute('aria-hidden','true');
          if(caret) caret.style.transform = '';
          toggle.focus();
        }
      }
    });

    // Allow keyboard navigation: Enter/Space to open
    toggle.addEventListener('keydown', function(e){
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        toggleDropdown();
      }
    });

  })();
</script>

</body>
</html>