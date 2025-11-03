<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - PaySure</title>
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .hero-bg {
      background: linear-gradient(to right, rgba(11, 100, 184, 0.85), rgba(43, 154, 243, 0.85)),
                  url('assets/images/contact-bg.jpg') center/cover no-repeat;
    }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
  </style>
</head>

<body class="bg-gray-50 text-gray-900">
  <?php include 'includes/header.php'; ?>

  <!-- HERO SECTION -->
  <section class="hero-bg text-white py-24 px-6 text-center">
    <div class="max-w-3xl mx-auto">
      <h1 class="text-5xl font-bold mb-4">Get in Touch with PaySure</h1>
      <p class="text-lg opacity-90">We’re here to answer your queries and guide you through your financial journey.</p>
    </div>
  </section>

  <!-- CONTACT FORM SECTION -->
  <section class="relative py-20">
    <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-12">
      
      <!-- Contact Form Card -->
      <div class="bg-white rounded-2xl p-10 shadow-xl card-hover border border-gray-100">
        <h2 class="text-2xl font-semibold mb-6 text-primary">Send Us a Message</h2>
        <form id="contactForm" class="space-y-5">
          <div class="grid md:grid-cols-2 gap-4">
            <input type="text" placeholder="First Name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" required>
            <input type="text" placeholder="Last Name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" required>
          </div>
          <input type="email" placeholder="Email Address" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" required>
          <input type="tel" placeholder="Phone Number" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
          <select class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Select Subject</option>
            <option>Investment Inquiry</option>
            <option>Insurance Services</option>
            <option>Customer Support</option>
            <option>Other</option>
          </select>
          <textarea rows="5" placeholder="Your Message..." class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
          <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all">Send Message</button>
        </form>
      </div>

      <!-- Map and Contact Info -->
      <div class="space-y-6">
        <div class="rounded-2xl overflow-hidden shadow-md border border-gray-200">
          <iframe class="w-full h-80" src="https://www.google.com/maps?q=New+York,+NY&output=embed" loading="lazy"></iframe>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-white p-6 rounded-2xl shadow-md border text-center">
            <div class="text-blue-600 text-3xl mb-2">📞</div>
            <h3 class="font-semibold text-lg">Call Us</h3>
            <p class="text-sm text-gray-600 mb-2">Mon–Fri: 8AM–6PM</p>
            <a href="tel:+18005550123" class="text-blue-600 font-medium hover:underline">+91 8001454567</a>
          </div>
          <div class="bg-white p-6 rounded-2xl shadow-md border text-center">
            <div class="text-blue-600 text-3xl mb-2">📧</div>
            <h3 class="font-semibold text-lg">Email Us</h3>
            <p class="text-sm text-gray-600 mb-2">We’ll respond within 24 hours</p>
            <a href="mailto:nirmalya.ghosh@gmail.com" class="text-blue-600 font-medium hover:underline">nirmalya.ghosh@gmail.com</a>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md border">
          <h3 class="font-semibold text-lg mb-3 flex items-center gap-2"><span>🕒</span> Office Hours</h3>
          <ul class="space-y-2 text-gray-700 text-sm">
            <li class="flex justify-between"><span>Monday–Friday</span> <strong>8:00 AM – 6:00 PM</strong></li>
            <li class="flex justify-between"><span>Saturday</span> <strong>9:00 AM – 2:00 PM</strong></li>
            <li class="flex justify-between"><span>Sunday</span> <strong>Closed</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- BRANCHES SECTION -->
  <section class="bg-white py-20 border-t">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold mb-8 text-gray-900">Our Branch Locations</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-md">
          <h3 class="font-semibold text-lg mb-1">New York HQ</h3>
          <p class="text-sm text-gray-600 mb-2">123 Financial District, NY</p>
          <span class="text-gray-700 text-sm">📞 +1 (212) 555-0100</span>
        </div>
        <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-md">
          <h3 class="font-semibold text-lg mb-1">Chicago Branch</h3>
          <p class="text-sm text-gray-600 mb-2">456 Michigan Avenue, IL</p>
          <span class="text-gray-700 text-sm">📞 +1 (312) 555-0200</span>
        </div>
        <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-md">
          <h3 class="font-semibold text-lg mb-1">San Francisco</h3>
          <p class="text-sm text-gray-600 mb-2">789 Market Street, CA</p>
          <span class="text-gray-700 text-sm">📞 +1 (415) 555-0300</span>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script>
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const btn = form.querySelector('button');
      btn.textContent = 'Sending...';
      btn.disabled = true;
      setTimeout(() => {
        btn.textContent = 'Message Sent!';
        btn.classList.add('bg-green-500');
        setTimeout(() => { form.reset(); btn.textContent = 'Send Message'; btn.classList.remove('bg-green-500'); btn.disabled = false; }, 2000);
      }, 1200);
    });
  </script>
</body>
</html>
