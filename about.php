<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PAYSURE</title>
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Load Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Custom styles for animations and theme colors */
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Define theme colors based on the PDF logo */
        :root {
            --theme-primary: #00a9b7; /* Teal/Blue */
            --theme-secondary: #e83e80; /* Pink/Red */
        }

        .text-primary { color: var(--theme-primary); }
        .bg-primary { background-color: var(--theme-primary); }
        .border-primary { border-color: var(--theme-primary); }

        .text-secondary { color: var(--theme-secondary); }
        .bg-secondary { background-color: var(--theme-secondary); }

        /* Animation: Fade in on scroll */
        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animated underline */
        .animated-underline {
            position: relative;
            display: inline-block;
        }
        .animated-underline::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            display: block;
            margin-top: 5px;
            right: 0;
            background: var(--theme-primary);
            transition: width 0.3s ease;
        }
        .fade-in-section.is-visible .animated-underline::after {
            width: 100%;
            left: 0;
            background: var(--theme-primary);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    
    <?php include 'includes/header.php'; ?>  
 <!--  -->
      

    <main>
        
        <!-- Section 1: Hero / About Us Intro -->
        <section class="fade-in-section relative bg-white py-20 md:py-32 overflow-hidden">
            <!-- Background decorative shape -->
            <div class="absolute top-0 right-0 -translate-y-1/4 translate-x-1/4 w-72 h-72 lg:w-96 lg:h-96 bg-primary opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-72 h-72 lg:w-96 lg:h-96 bg-secondary opacity-10 rounded-full blur-3xl"></div>

            <div class="container mx-auto px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-base font-semibold leading-7 text-primary">About Us</h2>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                        Your Partner in Financial Growth & Security
                    </p>
                    <p class="mt-6 text-lg leading-8 text-slate-600">
                        At PaySure, we believe financial well-being is the foundation of a
                        secure and fulfilling life. With this belief at our core, we've built a
                        platform that empowers both individuals and businesses through
                        smart, trustworthy, and customized financial solutions.
                    </p>
                </div>
            </div>
        </section>

        <!-- Section 2: Our Vision & Mission -->
        <section class="fade-in-section bg-white py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24">
                    
                    <!-- Our Vision -->
                    <div class="flex flex-col items-start">
                        <span class="animated-underline text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                            Our Vision
                        </span>
                        <p class="mt-6 text-base leading-7 text-slate-600">
                            To be a trusted and leading financial solutions provider that empowers
                            individuals and businesses to achieve financial freedom and long-term
                            success through smart, ethical, and personalized financial services.
                        </p>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            We envision a future where financial literacy and access to quality
                            financial products are within everyone's reach-helping people secure
                            their goals and build a better tomorrow.
                        </p>
                    </div>

                    <!-- Our Mission -->
                    <div class="flex flex-col items-start">
                        <span class="animated-underline text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                            Our Mission
                        </span>
                        <ul role="list" class="mt-6 space-y-4 text-slate-600">
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Offer a comprehensive range of financial services tailored to client needs.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Educate and guide clients in making informed financial decisions.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Build lasting relationships through transparency, integrity, and satisfaction.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Continuously innovate and partner with top financial institutions.</span>
                            </li>
                             <li class="flex gap-x-3">
                                <svg class="mt-1 h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Promote financial awareness and inclusion in the communities we serve.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <!-- Section 3: Why Choose PaySure -->
        <section class="fade-in-section bg-slate-50 py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto lg:max-w-none text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Why Choose PaySure?
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        We are committed to providing you with the best financial solutions and support.
                    </p>
                </div>
                <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: Collection -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12.75l.75-1.5.75 1.5m.75-1.5l.75 1.5.75-1.5m0 6l.75-1.5.75 1.5m.75-1.5l.75 1.5.75-1.5M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5M3.75 17.25h16.5" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Comprehensive Solutions</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">From investments and insurance to loans and advisory, we cover all your financial needs under one roof.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: ShieldCheck -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.333 9-6.03 9-11.623 0-1.314-.21-2.571-.602-3.751A11.959 11.959 0 0115 2.714" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Trusted Partnerships</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">We collaborate with leading institutions to ensure every product is reliable, secure, and designed for your benefit.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: UserGroup -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-4.682 2.72a3 3 0 01-4.682-2.72 9.094 9.094 0 013.741.479m-4.255 0a9.094 9.094 0 00-3.741-.479 3 3 0 00-4.682 2.72m9.364 0a3 3 0 01-4.682 2.72 9.094 9.094 0 013.741-.479m-4.255 0a9.094 9.094 0 00-3.741-.479 3 3 0 00-4.682 2.72M12 12.75a3 3 0 110-6 3 3 0 010 6z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Expert Personalized Advisory</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Our experienced advisors understand your unique goals and provide tailored strategies that align with your future plans.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: Eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Transparent & Ethical Practices</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Integrity is at our heart. We believe in clear, honest, and ethical guidance that builds long-term trust.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: Heart -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Client-Centric Approach</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Your success is our priority. Every solution we design is focused on your growth and long-term prosperity.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <!-- Icon: Sparkles -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM18 12.75l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 18l-1.035.259a3.375 3.375 0 00-2.456 2.456L18 21.75l-.259-1.035a3.375 3.375 0 00-2.456-2.456L14.25 18l1.035-.259a3.375 3.375 0 002.456-2.456L18 12.75z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Continuous Innovation</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">We stay ahead with modern financial tools, updated market insights, and innovative solutions for tomorrow.</p>
                    </div>

                </div>
            </div>
        </section>
        
    </main>

 <?php include 'includes/footer.php'; ?>
      

    <!-- Simple JS for scroll animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('.fade-in-section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Optional: unobserve after it's visible so it doesn't re-animate
                        // observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1 // Trigger when 10% of the element is visible
            });

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>

</body>
</html>
