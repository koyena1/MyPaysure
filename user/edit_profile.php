<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
$member_id = $_SESSION['username'];
$msg = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect Data
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    $ifsc_code = $_POST['ifsc_code'];
    $nominee_name = $_POST['nominee_name'];
    $nominee_relation = $_POST['nominee_relation'];

    // Insert or Update Profile
    $sql = "INSERT INTO user_profiles (member_id, email, mobile, address, bank_name, account_no, ifsc_code, nominee_name, nominee_relation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            email = VALUES(email), mobile = VALUES(mobile), address = VALUES(address),
            bank_name = VALUES(bank_name), account_no = VALUES(account_no), ifsc_code = VALUES(ifsc_code),
            nominee_name = VALUES(nominee_name), nominee_relation = VALUES(nominee_relation)";
            
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$member_id, $email, $mobile, $address, $bank_name, $account_no, $ifsc_code, $nominee_name, $nominee_relation])) {
        $msg = "<div class='alert success'><i class='fas fa-check-circle'></i> Profile updated successfully</div>";
    } else {
        $msg = "<div class='alert error'><i class='fas fa-exclamation-circle'></i> Failed to update profile</div>";
    }
}

// Fetch Current Data
$stmt = $db->prepare("SELECT * FROM user_profiles WHERE member_id = ?");
$stmt->execute([$member_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) $user = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Professional Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Modern Professional Palette (Indigo/Slate) */
            --primary: #4f46e5;       /* Indigo 600 */
            --primary-hover: #4338ca; /* Indigo 700 */
            --primary-light: #e0e7ff; /* Indigo 100 */
            
            --bg-body: #f3f4f6;       /* Gray 100 */
            --bg-card: #ffffff;
            
            --text-main: #111827;     /* Gray 900 */
            --text-secondary: #6b7280;/* Gray 500 */
            --text-placeholder: #9ca3af;
            
            --border-color: #e5e7eb;  /* Gray 200 */
            --border-focus: #6366f1;  /* Indigo 500 */
            
            --success-bg: #ecfdf5;
            --success-text: #047857;
            --error-bg: #fef2f2;
            --error-text: #b91c1c;

            --radius-md: 0.5rem;      /* 8px */
            --radius-lg: 0.75rem;     /* 12px */
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
        }

        /* Profile Header Area */
        .page-header {
            margin-bottom: 24px;
            text-align: left;
            animation: slideDown 0.4s ease-out;
        }

        .page-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.025em;
        }

        .page-header p {
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* Card Component */
        .profile-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--border-color);
            animation: fadeIn 0.5s ease-out;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            margin: 1.5rem 1.5rem 0 1.5rem;
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert.success {
            background-color: var(--success-bg);
            color: var(--success-text);
            border: 1px solid #d1fae5;
        }

        .alert.error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #fee2e2;
        }

        /* Form Structure */
        form {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 3rem;
            position: relative;
        }

        .form-section:last-child {
            margin-bottom: 1rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .section-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 400;
            margin-left: auto;
        }

        /* Grid System */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        /* Labels & Inputs */
        label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .required::after {
            content: "*";
            color: var(--error-text);
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); /* Soft focus ring */
        }

        .form-control::placeholder {
            color: var(--text-placeholder);
        }

        .form-control:read-only {
            background-color: #f9fafb;
            color: var(--text-secondary);
            cursor: default;
            user-select: none;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Action Bar */
        .form-actions {
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }

        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--shadow-sm);
        }

        .submit-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Loading & Animation States */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading .submit-btn i {
            animation: spin 1s linear infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 20px 10px;
            }
            
            form {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .section-subtitle {
                margin-left: 0;
            }

            .submit-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="page-header">
            <h1>Settings & Profile</h1>
            <p>Manage your personal information and banking details.</p>
        </div>

        <div class="profile-card">
            
            <?php echo $msg; ?>
            
            <form method="POST" id="profileForm">
                
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-user"></i></div>
                        <h3 class="section-title">Personal Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="required">Member ID</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($member_id); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="required">Full Name</label>
                            <input type="text" class="form-control" value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="required">Email Address</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" 
                                   required placeholder="e.g. name@company.com">
                        </div>
                        <div class="form-group">
                            <label class="required">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" 
                                   value="<?php echo isset($user['mobile']) ? htmlspecialchars($user['mobile']) : ''; ?>" 
                                   required placeholder="+91 00000 00000">
                        </div>
                        <div class="form-group full-width">
                            <label>Residential Address</label>
                            <textarea name="address" class="form-control" placeholder="Street, City, State, Zip Code..."><?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-building-columns"></i></div>
                        <h3 class="section-title">Banking Information</h3>
                        <span class="section-subtitle">For secure payouts</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" 
                                   value="<?php echo isset($user['bank_name']) ? htmlspecialchars($user['bank_name']) : ''; ?>"
                                   placeholder="e.g. HDFC Bank">
                        </div>
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="account_no" class="form-control" 
                                   value="<?php echo isset($user['account_no']) ? htmlspecialchars($user['account_no']) : ''; ?>"
                                   placeholder="000000000000">
                        </div>
                        <div class="form-group">
                            <label>IFSC Code</label>
                            <input type="text" name="ifsc_code" class="form-control" 
                                   value="<?php echo isset($user['ifsc_code']) ? htmlspecialchars($user['ifsc_code']) : ''; ?>"
                                   placeholder="HDFC0001234">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-shield-heart"></i></div>
                        <h3 class="section-title">Nominee Details</h3>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nominee Name</label>
                            <input type="text" name="nominee_name" class="form-control" 
                                   value="<?php echo isset($user['nominee_name']) ? htmlspecialchars($user['nominee_name']) : ''; ?>"
                                   placeholder="Full legal name">
                        </div>
                        <div class="form-group">
                            <label>Relationship</label>
                            <input type="text" name="nominee_relation" class="form-control" 
                                   value="<?php echo isset($user['nominee_relation']) ? htmlspecialchars($user['nominee_relation']) : ''; ?>"
                                   placeholder="e.g. Spouse, Parent">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Form submission handler
        const form = document.getElementById('profileForm');
        const submitBtn = form.querySelector('.submit-btn');
        const originalBtnContent = submitBtn.innerHTML;
        
        form.addEventListener('submit', function(e) {
            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#ef4444';
                    // Optional: shake animation
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                return;
            }
            
            // Add loading state
            submitBtn.innerHTML = '<i class="fas fa-circle-notch"></i> Saving...';
            form.classList.add('loading');
            submitBtn.style.opacity = '0.7';
            submitBtn.style.pointerEvents = 'none';
        });
        
        // Real-time validation visual feedback
        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.hasAttribute('required') && this.value.trim()) {
                    this.style.borderColor = '#10b981'; // Green hint
                } else {
                    this.style.borderColor = ''; // Reset
                }
            });
            
            // Clear specific error color on focus to show focus ring
            input.addEventListener('focus', function() {
                this.style.borderColor = '';
            });
        });
        
        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        if(alerts.length > 0) {
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        }
    </script>
</body>
</html>