<?php
// business-opportunity.php
// This page is designed to be included in your site where header.php and footer.php exist.
// Usage: place this file in your project and ensure header.php & footer.php are in the same folder or adjust include paths.
?>

<?php include 'includes/header.php'; ?>

<!-- Business Opportunity Page - PaySure -->
<main class="business-opportunity-page">
  <section class="bo-hero">
    <div class="container">
      <div class="hero-grid">
        <div class="hero-content">
          <h1 class="title">Business Opportunity with <span class="accent">PaySure</span></h1>
          <p class="lead">Join a trusted financial platform that delivers income plans, promotional bonuses and long-term wealth-building solutions. Built for partners who want honest growth, excellent support and attractive returns.</p>
          <a href="#contact-cta" class="btn-primary">Become a Partner</a>
        </div>
        <div class="hero-cards">
          <div class="card card-1" data-tilt>
            <h3>High Commissions</h3>
            <p>Earn competitive direct and level commissions with clear payout rules.</p>
          </div>
          <div class="card card-2" data-tilt>
            <h3>Promotional Bonuses</h3>
            <p>Extra rewards from PaySure for campaign performance and matching pairs.</p>
          </div>
          <div class="card card-3" data-tilt>
            <h3>Trusted Partners</h3>
            <p>Work with established insurers and financial institutions for secure products.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bo-features">
    <div class="container">
      <h2 class="section-title">Why Join PaySure?</h2>
      <div class="features-grid">
        <article class="feature" tabindex="0">
          <div class="icon">💼</div>
          <h4>Simple Onboarding</h4>
          <p>Fast verification and training — start selling in days, not weeks.</p>
        </article>
        <article class="feature" tabindex="0">
          <div class="icon">📈</div>
          <h4>Attractive Returns</h4>
          <p>Fixed and performance-based incentives that grow with your team.</p>
        </article>
        <article class="feature" tabindex="0">
          <div class="icon">🔒</div>
          <h4>Transparent Policies</h4>
          <p>Clear T&amp;C, documented commission rules and fair dispute resolution.</p>
        </article>
        <article class="feature" tabindex="0">
          <div class="icon">🤝</div>
          <h4>Dedicated Support</h4>
          <p>Partner managers and sales collateral to help you convert faster.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="bo-plans">
    <div class="container">
      <h2 class="section-title">Sample Earning Plan</h2>
      <div class="plans-grid">
        <div class="plan" tabindex="0">
          <header>
            <h3>Standard Partner</h3>
            <div class="price">Direct <span>40%</span></div>
          </header>
          <ul>
            <li>Matching Bonus — ₹2,000 per matched pair</li>
            <li>Level commissions up to 12 levels</li>
            <li>Team & promotional bonuses</li>
          </ul>
          <a class="btn-outline" href="#contact-cta">Join Now</a>
        </div>
        <div class="plan best" tabindex="0">
          <header>
            <h3>Premium Partner</h3>
            <div class="price">Direct <span>60%</span></div>
          </header>
          <ul>
            <li>Higher matching incentives</li>
            <li>Priority payout & manager</li>
            <li>Co-branded marketing support</li>
          </ul>
          <a class="btn-primary" href="#contact-cta">Apply</a>
        </div>
        <div class="plan" tabindex="0">
          <header>
            <h3>Agency</h3>
            <div class="price">Team <span>Tiered</span></div>
          </header>
          <ul>
            <li>Custom team splits</li>
            <li>Bulk onboarding assistance</li>
            <li>Exclusive campaigns</li>
          </ul>
          <a class="btn-outline" href="#contact-cta">Talk to Sales</a>
        </div>
      </div>
    </div>
  </section>

  <section class="bo-cta" id="contact-cta">
    <div class="container cta-inner">
      <div>
        <h2>Ready to grow with PaySure?</h2>
        <p>Fill the quick form and our partner manager will contact you within 24 hours.</p>
      </div>
      <form class="contact-form" action="/submit-partner.php" method="post">
        <input name="name" placeholder="Full name" required>
        <input name="phone" placeholder="Phone number" required>
        <input name="email" type="email" placeholder="Email address" required>
        <select name="interest">
          <option value="partner">Become Partner</option>
          <option value="agency">Start Agency</option>
          <option value="channel">Channel Partnership</option>
        </select>
        <button class="btn-primary" type="submit">Submit</button>
      </form>
    </div>
  </section>

  <section class="bo-logos">
    <div class="container">
      <h3 class="section-sub">Our Trusted Partners</h3>
      <div class="logos-strip" aria-hidden="true">
        <div class="logos-track">
          <!-- Example logos. Replace href and img src with real partner links & images -->
          <a href="#" class="logo-item"><img src="assets/partners/bajaj-allianz.svg" alt="Bajaj Allianz"></a>
          <a href="#" class="logo-item"><img src="assets/partners/partner2.svg" alt="Partner 2"></a>
          <a href="#" class="logo-item"><img src="assets/partners/partner3.svg" alt="Partner 3"></a>
          <a href="#" class="logo-item"><img src="assets/partners/partner4.svg" alt="Partner 4"></a>
          <!-- cloned set for continuous scroll -->
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'includes/footer.php'; ?>

<!-- Styles & Animations (self-contained so you can paste directly) -->
<style>
:root{ --accent:#0ea5a4; --bg:#ffffff; --muted:#6b7280; --card:#f8fafc; --glass: rgba(255,255,255,0.06); }
.business-opportunity-page { font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#0f172a; }
.container{ max-width:1200px; margin:0 auto; padding:2rem; }
.bo-hero{ background:linear-gradient(135deg, rgba(14,165,164,0.06), rgba(2,6,23,0.02)); padding:4rem 0 2rem; border-bottom:1px solid rgba(2,6,23,0.04); }
.hero-grid{ display:grid; grid-template-columns:1fr 420px; gap:2rem; align-items:center; }
.title{ font-size:2.25rem; margin:0 0 0.75rem; line-height:1.05; }
.accent{ color:var(--accent); }
.lead{ color:var(--muted); margin-bottom:1.25rem; }
.btn-primary{ background:var(--accent); color:white; padding:0.75rem 1.1rem; border-radius:10px; display:inline-block; text-decoration:none; box-shadow:0 8px 22px rgba(14,165,164,0.12); transition:transform .18s ease, box-shadow .18s ease; }
.btn-primary:hover{ transform:translateY(-4px); box-shadow:0 18px 40px rgba(14,165,164,0.12); }
.btn-outline{ border:1px solid rgba(15,23,42,0.06); padding:0.6rem 1rem; border-radius:10px; display:inline-block; text-decoration:none; color:inherit; }
.hero-cards{ display:flex; flex-direction:column; gap:1rem; }
.card{ background:linear-gradient(180deg,#fff,#fbfdff); padding:1rem; border-radius:12px; box-shadow:0 6px 18px rgba(2,6,23,0.06); transform-origin:center; transition:transform .28s cubic-bezier(.2,.8,.2,1), box-shadow .28s; }
.card h3{ margin:0 0 .4rem; }
.card p{ color:var(--muted); margin:0; font-size:0.95rem; }
.card:hover{ transform:translateY(-10px) scale(1.02); box-shadow:0 22px 40px rgba(2,6,23,0.08); }

.bo-features{ padding:3rem 0; }
.section-title{ font-size:1.4rem; margin-bottom:1rem; }
.features-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; }
.feature{ background:linear-gradient(180deg,#fff,#fbfdff); padding:1.25rem; border-radius:12px; text-align:center; box-shadow:0 12px 30px rgba(2,6,23,0.04); transition:transform .18s ease; }
.feature:focus, .feature:hover{ transform:translateY(-8px); }
.feature .icon{ font-size:1.6rem; margin-bottom:0.6rem; }

.bo-plans{ padding:3rem 0; }
.plans-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
.plan{ background:#fff; padding:1.25rem; border-radius:14px; border:1px solid rgba(2,6,23,0.04); text-align:left; box-shadow:0 10px 28px rgba(2,6,23,0.04); transition:transform .2s ease, box-shadow .2s ease; }
.plan.best{ border:1px solid rgba(14,165,164,0.12); box-shadow:0 20px 40px rgba(14,165,164,0.06); transform:translateY(-6px); }
.plan header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem; }
.plan .price span{ font-weight:700; color:var(--accent); }
.plan ul{ color:var(--muted); margin:0 0 1rem 0; padding-left:1rem; }
.plan a{ text-decoration:none; }

.bo-cta{ background:linear-gradient(90deg, rgba(14,165,164,0.06), rgba(59,130,246,0.02)); padding:2rem 0; margin-top:2rem; border-radius:12px; }
.cta-inner{ display:flex; gap:2rem; align-items:center; justify-content:space-between; }
.contact-form{ display:flex; gap:.6rem; align-items:center; }
.contact-form input, .contact-form select{ padding:0.6rem 0.75rem; border-radius:10px; border:1px solid rgba(2,6,23,0.06); }
.contact-form button{ margin-left:.4rem; }

.bo-logos{ padding:2rem 0; }
.logos-strip{ overflow:hidden; position:relative; height:64px; }
.logos-track{ display:flex; gap:2.5rem; align-items:center; position:absolute; left:0; top:0; height:100%; will-change:transform; }
.logo-item img{ height:48px; opacity:0.9; filter:grayscale(.02); transition:transform .18s ease, opacity .18s; }
.logo-item:hover img{ transform:translateY(-6px) scale(1.02); opacity:1; }

/* Responsive */
@media (max-width:900px){ .hero-grid{ grid-template-columns:1fr; } .features-grid{ grid-template-columns:repeat(2,1fr); } .plans-grid{ grid-template-columns:1fr; } .cta-inner{ flex-direction:column; align-items:stretch; } }

</style>

<!-- Animations & Interaction -->
<script>
// Tilt-like hover for cards (simple, lightweight)
(function(){
  const cards = document.querySelectorAll('[data-tilt]');
  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;
      card.style.transform = `perspective(900px) rotateX(${ -y * 6 }deg) rotateY(${ x * 8 }deg) translateZ(6px)`;
    });
    card.addEventListener('mouseleave', () => card.style.transform = 'translateZ(0)');
  });
})();

// Logos continuous scroll
(function(){
  const track = document.querySelector('.logos-track');
  if(!track) return;
  // duplicate children to create seamless loop
  track.innerHTML += track.innerHTML;
  let pos = 0;
  function loop(){
    pos -= 0.6; // speed
    if(Math.abs(pos) >= track.scrollWidth/2) pos = 0;
    track.style.transform = `translateX(${pos}px)`;
    requestAnimationFrame(loop);
  }
  requestAnimationFrame(loop);
})();

// Simple appear-on-scroll
(function(){
  const observer = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting) e.target.classList.add('in-view');
    });
  }, {threshold:0.12});
  document.querySelectorAll('.card, .feature, .plan, .section-title').forEach(el=>observer.observe(el));
})();
</script>

<!-- End of business-opportunity.php -->
