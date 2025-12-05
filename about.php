<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PAYSURE</title>
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    
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
 <main>
        
        <section class="fade-in-section relative bg-white py-20 md:py-32 overflow-hidden">
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

        <section class="fade-in-section bg-slate-50 py-16 sm:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="bg-white p-8 md:p-12 rounded-2xl shadow-lg transform transition-transform duration-300 hover:shadow-xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24">
                        
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
                                financial products are within everyone's reach—helping people secure
                                their goals and build a better tomorrow.
                            </p>
                        </div>

                        <div class="flex flex-col items-start border-t md:border-t-0 md:border-l border-slate-100 md:pl-12 pt-12 md:pt-0">
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
            </div>
        </section>

        <section class="fade-in-section bg-white py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto lg:max-w-none text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Project Parts
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        Explore our diverse range of financial services designed to secure your future.
                    </p>
                </div>
                <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl flex flex-col">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Investments</h3>
                        <div class="mt-2 text-base leading-7 text-slate-600 flex-grow">
                            <span>We provide safe and high-return investment options tailored to your risk appetite.</span>
                            <span class="more-content hidden">
                                Our strategies focus on wealth accumulation, portfolio diversification, and minimizing market volatility. 
                                Whether you are looking for short-term gains or long-term security, our expert-curated plans ensure your money works as hard as you do.
                            </span>
                        </div>
                        <button class="read-more-btn mt-4 text-sm font-semibold text-primary self-start hover:underline focus:outline-none">Read More</button>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl flex flex-col">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Mutual Funds</h3>
                        <div class="mt-2 text-base leading-7 text-slate-600 flex-grow">
                            <span>Unlock the power of the markets with our diversified mutual fund portfolios designed for long-term gains.</span>
                            <span class="more-content hidden">
                                We offer systematic investment plans (SIPs) and lump-sum options across equity, debt, and hybrid funds. 
                                Our goal is to help you beat inflation and build a substantial corpus for your future aspirations through professional fund management.
                            </span>
                        </div>
                        <button class="read-more-btn mt-4 text-sm font-semibold text-primary self-start hover:underline focus:outline-none">Read More</button>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl flex flex-col">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Insurance Solutions</h3>
                        <div class="mt-2 text-base leading-7 text-slate-600 flex-grow">
                            <span>Protecting your family and assets is our top priority with our comprehensive insurance plans.</span>
                            <span class="more-content hidden">
                                From life and health insurance to vehicle and property coverage, we ensure you are prepared for life's uncertainties. 
                                We help you navigate complex policies to find the coverage that offers the best security and peace of mind for your loved ones.
                            </span>
                        </div>
                        <button class="read-more-btn mt-4 text-sm font-semibold text-primary self-start hover:underline focus:outline-none">Read More</button>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl flex flex-col">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Personal & Business Loans</h3>
                        <div class="mt-2 text-base leading-7 text-slate-600 flex-grow">
                            <span>We offer easy-term loan facilities designed to fuel your dreams, whether it's buying a new home or expanding your business.</span>
                            <span class="more-content hidden">
                                With competitive interest rates, quick approval processes, and minimal documentation, we make borrowing stress-free. 
                                Our customized repayment plans ensure that your financial growth is never hindered by lack of capital.
                            </span>
                        </div>
                        <button class="read-more-btn mt-4 text-sm font-semibold text-primary self-start hover:underline focus:outline-none">Read More</button>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl flex flex-col">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Banking & Financial Advisory</h3>
                        <div class="mt-2 text-base leading-7 text-slate-600 flex-grow">
                            <span>Get expert guidance on retirement planning, tax savings, and overall wealth management from our seasoned advisors.</span>
                            <span class="more-content hidden">
                                We analyze your financial health and create a roadmap that aligns with your life stages and retirement goals. 
                                Our objective advice helps you optimize your taxes and make smart banking decisions for a secure and comfortable future.
                            </span>
                        </div>
                        <button class="read-more-btn mt-4 text-sm font-semibold text-primary self-start hover:underline focus:outline-none">Read More</button>
                    </div>

                </div>
            </div>
        </section>

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
                    
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12.75l.75-1.5.75 1.5m.75-1.5l.75 1.5.75-1.5m0 6l.75-1.5.75 1.5m.75-1.5l.75 1.5.75-1.5M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5M3.75 17.25h16.5" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Comprehensive Solutions</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">From investments and insurance to loans and advisory, we cover all your financial needs under one roof.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.333 9-6.03 9-11.623 0-1.314-.21-2.571-.602-3.751A11.959 11.959 0 0115 2.714" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Trusted Partnerships</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">We collaborate with leading institutions to ensure every product is reliable, secure, and designed for your benefit.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-4.682 2.72a3 3 0 01-4.682-2.72 9.094 9.094 0 013.741.479m-4.255 0a9.094 9.094 0 00-3.741-.479 3 3 0 00-4.682 2.72m9.364 0a3 3 0 01-4.682 2.72 9.094 9.094 0 013.741-.479m-4.255 0a9.094 9.094 0 00-3.741-.479 3 3 0 00-4.682 2.72M12 12.75a3 3 0 110-6 3 3 0 010 6z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Expert Personalized Advisory</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Our experienced advisors understand your unique goals and provide tailored strategies that align with your future plans.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Transparent & Ethical Practices</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Integrity is at our heart. We believe in clear, honest, and ethical guidance that builds long-term trust.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold leading-6 text-slate-900">Client-Centric Approach</h3>
                        <p class="mt-2 text-base leading-7 text-slate-600">Your success is our priority. Every solution we design is focused on your growth and long-term prosperity.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary text-white">
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
      

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Existing Animation Code
            const sections = document.querySelectorAll('.fade-in-section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.1 
            });

            sections.forEach(section => {
                observer.observe(section);
            });

            // NEW: Read More / Read Less Functionality
            const readMoreBtns = document.querySelectorAll('.read-more-btn');

            readMoreBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    // Find the previous sibling element which contains the text
                    const container = e.target.previousElementSibling;
                    const moreContent = container.querySelector('.more-content');
                    
                    if (moreContent) {
                        moreContent.classList.toggle('hidden');
                        
                        // Change button text based on visibility
                        if (moreContent.classList.contains('hidden')) {
                            e.target.textContent = 'Read More';
                        } else {
                            e.target.textContent = 'Read Less';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>