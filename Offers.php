<?php
// Include database connection
require_once 'includes/db.php'; 

// Fetch Active Monthly Offers from Database
$sql = "SELECT * FROM monthly_offers WHERE is_active = 1 ORDER BY id DESC";
$monthly_offers = $database->fetchAll($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers - PaySure</title>
    <style>
        /* CSS variables and base styles */
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
            background: linear-gradient(rgba(26, 58, 143, 0.8), rgba(0, 162, 232, 0.8)), url('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        }
        
        .btn:hover {
            background-color: #e55a00;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* NEW: Smaller Button Style */
        .btn-small {
            padding: 8px 20px;
            font-size: 0.9rem;
            margin-top: auto;
            align-self: flex-start;
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
        
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .offer-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .offer-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            z-index: 2;
        }
        
        .offer-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .offer-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .offer-card h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .offer-card p {
            color: #666;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        
        .offer-features {
            list-style: none;
            margin-bottom: 20px;
        }
        
        .offer-features li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 25px;
        }
        
        .offer-features li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--secondary);
            font-weight: bold;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .comparison-table th, .comparison-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .comparison-table th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }
        
        .comparison-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .comparison-table tr:hover {
            background-color: #f0f5ff;
        }
        
        .highlight {
            background-color: #fff9e6 !important;
            font-weight: 600;
        }

        /* --- MODAL STYLES --- */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.6); 
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 0;
            border-radius: 15px;
            width: 90%; 
            max-width: 800px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            animation: fadeInUp 0.4s ease;
            position: relative;
        }

        .modal-header {
            background: var(--primary);
            color: white;
            padding: 20px 30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 { margin: 0; font-size: 1.8rem; }
        .close-btn { color: white; font-size: 28px; font-weight: bold; cursor: pointer; transition: 0.2s; }
        .close-btn:hover { color: var(--accent); }

        .modal-body { padding: 30px; max-height: 70vh; overflow-y: auto; }
        
        .detail-row { margin-bottom: 25px; }
        .detail-label { font-weight: 700; color: var(--primary); font-size: 1.1rem; margin-bottom: 8px; display: block; border-bottom: 2px solid #eee; padding-bottom: 5px; }
        .detail-text { color: #444; line-height: 1.7; white-space: pre-line; }
        
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; background: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #e9ecef; }
        .contact-item strong { display: block; color: var(--secondary); margin-bottom: 3px; }
        
        .validity-tag { background: #e0f2fe; color: #0284c7; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-top: 5px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .section-title h2 { font-size: 2rem; }
            .offers-grid { grid-template-columns: 1fr; }
            .comparison-table { font-size: 0.9rem; }
        }
    </style>
</head>
<body>
<?php
include 'includes/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Exclusive Financial Offers</h1>
            <p>Discover our premium insurance and investment products designed to secure your financial future</p>
            <a href="#products" class="btn">View Products</a>
        </div>
    </section>

    <section class="section" id="products">
        <div class="container">
            <div class="section-title">
                <h2>Our Premium Products</h2>
                <p>Explore our range of financial products tailored to meet your unique needs</p>
            </div>
            
            <div class="offers-grid">
                <div class="offer-card">
                    <div class="offer-badge">Popular</div>
                    <div class="offer-img" style="background-image: url('https://images.unsplash.com/photo-1554224154-2604c2c2591b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="offer-content">
                        <h3>Bajaj Allianz Life ACE</h3>
                        <p>A non-linked, participating, individual life insurance savings plan that provides lifetime guaranteed income starting immediately.</p>
                        <ul class="offer-features">
                            <li>Immediate income from year 1</li>
                            <li>Policy term up to age 100</li>
                            <li>Guaranteed and non-guaranteed income</li>
                            <li>Premium payment for limited years only</li>
                        </ul>
                        <a href="#" class="btn">Get Details</a>
                    </div>
                </div>
                
                <div class="offer-card">
                    <div class="offer-badge">New</div>
                    <div class="offer-img" style="background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="offer-content">
                        <h3>ACE with Goal Protection</h3>
                        <p>Enhanced protection with death benefits, premium waivers, and continued income for your family.</p>
                        <ul class="offer-features">
                            <li>Death benefit of ₹11 lakhs</li>
                            <li>Premium waiver on claim</li>
                            <li>Income continues after claim</li>
                            <li>Maturity benefit of ₹1.2 crores</li>
                        </ul>
                        <a href="#" class="btn">Get Details</a>
                    </div>
                </div>
                
                <div class="offer-card">
                    <div class="offer-badge">Limited Time</div>
                    <div class="offer-img" style="background-image: url('https://images.unsplash.com/photo-1554224154-22dec7ec8818?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="offer-content">
                        <h3>Three Generation Income Plan</h3>
                        <p>A unique plan that provides income across three generations - for you, your children, and their children.</p>
                        <ul class="offer-features">
                            <li>Income for father until daughter's marriage</li>
                            <li>Income for daughter until age 99</li>
                            <li>Lump sum for grandchild at age 100</li>
                            <li>Legacy planning for future generations</li>
                        </ul>
                        <a href="#" class="btn">Get Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="monthly-offers">
        <div class="container">
            <div class="section-title">
                <h2>Our Monthly Offers</h2>
                <p>Limited time exclusive deals selected just for you</p>
            </div>
            
            <div class="offers-grid">
                <?php if ($monthly_offers): ?>
                    <?php foreach ($monthly_offers as $offer): ?>
                        <?php $modalId = 'modal-' . $offer['id']; ?>
                        
                        <div class="offer-card">
                            <?php if (!empty($offer['badge_text'])): ?>
                                <div class="offer-badge"><?php echo htmlspecialchars($offer['badge_text']); ?></div>
                            <?php endif; ?>
                            
                            <?php 
                                $bg_image = !empty($offer['image_url']) 
                                    ? htmlspecialchars($offer['image_url']) 
                                    : 'https://images.unsplash.com/photo-1554224154-2604c2c2591b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                            ?>
                            <div class="offer-img" style="background-image: url('<?php echo $bg_image; ?>');"></div>
                            
                            <div class="offer-content">
                                <h3><?php echo htmlspecialchars($offer['title']); ?></h3>
                                
                                <?php if(!empty($offer['offer_validity'])): ?>
                                    <div style="margin-bottom: 10px;">
                                        <span class="validity-tag">📅 <?php echo htmlspecialchars($offer['offer_validity']); ?></span>
                                    </div>
                                <?php endif; ?>

                                <p><?php echo substr(htmlspecialchars($offer['description']), 0, 100) . '...'; ?></p>
                                
                                <?php if(!empty($offer['key_benefits'])): ?>
                                    <ul class="offer-features">
                                        <?php 
                                            $benefits = explode("\n", $offer['key_benefits']);
                                            $count = 0;
                                            foreach($benefits as $benefit) {
                                                if($count < 2 && !empty(trim($benefit))) {
                                                    echo '<li>' . htmlspecialchars($benefit) . '</li>';
                                                    $count++;
                                                }
                                            }
                                        ?>
                                    </ul>
                                <?php endif; ?>

                                <button class="btn btn-small" onclick="openModal('<?php echo $modalId; ?>')">Get Details</button>
                            </div>
                        </div>

                        <div id="<?php echo $modalId; ?>" class="modal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2><?php echo htmlspecialchars($offer['title']); ?></h2>
                                    <span class="close-btn" onclick="closeModal('<?php echo $modalId; ?>')">&times;</span>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="detail-row">
                                        <span class="detail-label">Offer Summary</span>
                                        <div class="detail-text"><?php echo nl2br(htmlspecialchars($offer['description'])); ?></div>
                                        <?php if(!empty($offer['offer_validity'])): ?>
                                            <div style="margin-top:10px; color: #666;"><strong>Validity:</strong> <?php echo htmlspecialchars($offer['offer_validity']); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(!empty($offer['key_benefits'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">Key Benefits</span>
                                        <ul class="offer-features">
                                            <?php 
                                                $all_benefits = explode("\n", $offer['key_benefits']);
                                                foreach($all_benefits as $b) {
                                                    if(!empty(trim($b))) echo '<li>' . htmlspecialchars($b) . '</li>';
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!empty($offer['investment_details'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">A. Investment Products</span>
                                        <div class="detail-text"><?php echo nl2br(htmlspecialchars($offer['investment_details'])); ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!empty($offer['loan_details'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">B. Loan Products</span>
                                        <div class="detail-text"><?php echo nl2br(htmlspecialchars($offer['loan_details'])); ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!empty($offer['insurance_details'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">C. Insurance Plans</span>
                                        <div class="detail-text"><?php echo nl2br(htmlspecialchars($offer['insurance_details'])); ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!empty($offer['terms_conditions'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">Terms & Conditions</span>
                                        <div class="detail-text" style="font-size:0.9rem; color:#666;"><?php echo nl2br(htmlspecialchars($offer['terms_conditions'])); ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="detail-row">
                                        <span class="detail-label">Contact Information</span>
                                        <div class="contact-grid">
                                            <?php if(!empty($offer['contact_support'])): ?>
                                                <div class="contact-item"><strong>Support:</strong> <?php echo htmlspecialchars($offer['contact_support']); ?></div>
                                            <?php endif; ?>
                                            <?php if(!empty($offer['contact_phone'])): ?>
                                                <div class="contact-item"><strong>Phone:</strong> <?php echo htmlspecialchars($offer['contact_phone']); ?></div>
                                            <?php endif; ?>
                                            <?php if(!empty($offer['contact_email'])): ?>
                                                <div class="contact-item"><strong>Email:</strong> <?php echo htmlspecialchars($offer['contact_email']); ?></div>
                                            <?php endif; ?>
                                            <?php if(!empty($offer['contact_website'])): ?>
                                                <div class="contact-item"><strong>Website:</strong> <a href="<?php echo htmlspecialchars($offer['contact_website']); ?>" target="_blank">Visit Link</a></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(!empty($offer['branch_locations'])): ?>
                                    <div class="detail-row">
                                        <span class="detail-label">Branch Locations</span>
                                        <div class="detail-text"><?php echo nl2br(htmlspecialchars($offer['branch_locations'])); ?></div>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1/-1; text-align: center;">
                        <p>No monthly offers available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: #f0f5ff;">
        <div class="container">
            <div class="section-title">
                <h2>Product Comparison</h2>
                <p>Compare our ACE insurance plans to find the perfect fit for your needs</p>
            </div>
            
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>ACE</th>
                        <th>ACE with Goal Protection</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Choice of Premium payment term</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Choice of Income amount</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Choice of Income start year</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Choice of Income Period</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Age at Entry</td>
                        <td>0 to 60</td>
                        <td>18 to 55</td>
                    </tr>
                    <tr>
                        <td>Max. Age at Maturity</td>
                        <td>Age 100 years</td>
                        <td>Age 85 years</td>
                    </tr>
                    <tr class="highlight">
                        <td>Benefit on death</td>
                        <td>11x AP plus Bonuses</td>
                        <td>11x AP</td>
                    </tr>
                    <tr>
                        <td>Waiver of premiums on death</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Income continuity after death</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Maturity benefit payable after death</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

<?php
include 'includes/footer.php';
?>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
        document.body.style.overflow = "hidden"; // Prevent scrolling behind modal
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
        document.body.style.overflow = "auto"; // Restore scrolling
    }

    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
            document.body.style.overflow = "auto";
        }
    }
</script>

</body>
</html>