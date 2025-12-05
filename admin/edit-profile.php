<?php
include '../includes/db.php';

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $father_name = $_POST['father_name'];
    $dob = $_POST['date_of_birth'];
    $mobile = $_POST['mobile'];
    $aadhar_no = $_POST['aadhar_no'];
    $pan_no = $_POST['pan_no'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $pin_no = $_POST['pin_no'];
    $account_no = $_POST['account_no'];
    $bank_name = $_POST['bank_name'];
    $branch_name = $_POST['branch_name'];
    $account_name = $_POST['account_name'];
    $ifsc_code = $_POST['ifsc_code'];
    $phone_pay_no = $_POST['phone_pay_no'];
    $google_pay_no = $_POST['google_pay_no'];
    $paytm_no = $_POST['paytm_no'];
    $gst_no = $_POST['gst_no'];
    $nominee_name = $_POST['nominee_name'];
    $nominee_relation = $_POST['nominee_relation'];

    // Handle image upload
    $imagePath = "";
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    // Insert or update record
    $stmt = $db->prepare("
        INSERT INTO user_profiles (member_id, full_name, gender, email, password, father_name, date_of_birth, mobile, 
        aadhar_no, pan_no, country, state, district, address, pin_no, account_no, bank_name, branch_name, account_name, ifsc_code,
        phone_pay_no, google_pay_no, paytm_no, gst_no, nominee_name, nominee_relation, image)
        VALUES (:member_id, :full_name, :gender, :email, :password, :father_name, :date_of_birth, :mobile, 
        :aadhar_no, :pan_no, :country, :state, :district, :address, :pin_no, :account_no, :bank_name, :branch_name, :account_name, :ifsc_code,
        :phone_pay_no, :google_pay_no, :paytm_no, :gst_no, :nominee_name, :nominee_relation, :image)
        ON DUPLICATE KEY UPDATE
        full_name = VALUES(full_name),
        gender = VALUES(gender),
        email = VALUES(email),
        password = VALUES(password),
        father_name = VALUES(father_name),
        date_of_birth = VALUES(date_of_birth),
        mobile = VALUES(mobile),
        aadhar_no = VALUES(aadhar_no),
        pan_no = VALUES(pan_no),
        country = VALUES(country),
        state = VALUES(state),
        district = VALUES(district),
        address = VALUES(address),
        pin_no = VALUES(pin_no),
        account_no = VALUES(account_no),
        bank_name = VALUES(bank_name),
        branch_name = VALUES(branch_name),
        account_name = VALUES(account_name),
        ifsc_code = VALUES(ifsc_code),
        phone_pay_no = VALUES(phone_pay_no),
        google_pay_no = VALUES(google_pay_no),
        paytm_no = VALUES(paytm_no),
        gst_no = VALUES(gst_no),
        nominee_name = VALUES(nominee_name),
        nominee_relation = VALUES(nominee_relation),
        image = VALUES(image)
    ");

    $stmt->execute([
        ':member_id' => $member_id,
        ':full_name' => $full_name,
        ':gender' => $gender,
        ':email' => $email,
        ':password' => $password,
        ':father_name' => $father_name,
        ':date_of_birth' => $dob,
        ':mobile' => $mobile,
        ':aadhar_no' => $aadhar_no,
        ':pan_no' => $pan_no,
        ':country' => $country,
        ':state' => $state,
        ':district' => $district,
        ':address' => $address,
        ':pin_no' => $pin_no,
        ':account_no' => $account_no,
        ':bank_name' => $bank_name,
        ':branch_name' => $branch_name,
        ':account_name' => $account_name,
        ':ifsc_code' => $ifsc_code,
        ':phone_pay_no' => $phone_pay_no,
        ':google_pay_no' => $google_pay_no,
        ':paytm_no' => $paytm_no,
        ':gst_no' => $gst_no,
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':image' => $imagePath
    ]);

    $message = "✅ Profile updated successfully!";
}

// Fetch existing user data (for demo: static member_id)
$member_id = "PS123456";
$stmt = $db->prepare("SELECT * FROM user_profiles WHERE member_id = ?");
$stmt->execute([$member_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f6fa; font-family: 'Segoe UI', sans-serif; }
        .container-box {
            background-color: #fff; padding: 25px; border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        h3 { background-color: #6f42c1; color: #fff; padding: 12px 20px; border-radius: 6px 6px 0 0; }
        label { font-weight: 600; color: #444; }
        input, select, textarea { border-radius: 5px !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .btn-danger { background-color: #dc3545; border: none; }
    </style>
</head>
<body>


<div class="main-content" style="margin-left:250px; padding:20px;">
    <h3>✏ Edit Profile</h3>

    <?php if ($message): ?>
        <div class="alert alert-success mt-3"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="container-box">
        <div class="row g-3">
            <div class="col-md-6">
                <label>Member ID</label>
                <input type="text" name="member_id" class="form-control" value="<?= $user['member_id'] ?? '' ?>" required>
            </div>
            <div class="col-md-6">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="<?= $user['password'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>Father Name</label>
                <input type="text" name="father_name" class="form-control" value="<?= $user['father_name'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">--Select--</option>
                    <option value="Male" <?= ($user['gender'] ?? '')=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?= ($user['gender'] ?? '')=='Female'?'selected':'' ?>>Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="<?= $user['date_of_birth'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?= $user['mobile'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Aadhar No</label>
                <input type="text" name="aadhar_no" class="form-control" value="<?= $user['aadhar_no'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>PAN No</label>
                <input type="text" name="pan_no" class="form-control" value="<?= $user['pan_no'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="<?= $user['country'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>State</label>
                <input type="text" name="state" class="form-control" value="<?= $user['state'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>District</label>
                <input type="text" name="district" class="form-control" value="<?= $user['district'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>PIN No</label>
                <input type="text" name="pin_no" class="form-control" value="<?= $user['pin_no'] ?? '' ?>">
            </div>

            <div class="col-md-12">
                <label>Address</label>
                <textarea name="address" class="form-control"><?= $user['address'] ?? '' ?></textarea>
            </div>

            <div class="col-md-6">
                <label>Account No</label>
                <input type="text" name="account_no" class="form-control" value="<?= $user['account_no'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="form-control" value="<?= $user['bank_name'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Branch Name</label>
                <input type="text" name="branch_name" class="form-control" value="<?= $user['branch_name'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>Account Name</label>
                <input type="text" name="account_name" class="form-control" value="<?= $user['account_name'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control" value="<?= $user['ifsc_code'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Phone Pay No</label>
                <input type="text" name="phone_pay_no" class="form-control" value="<?= $user['phone_pay_no'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Google Pay No</label>
                <input type="text" name="google_pay_no" class="form-control" value="<?= $user['google_pay_no'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Paytm No</label>
                <input type="text" name="paytm_no" class="form-control" value="<?= $user['paytm_no'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>GST No</label>
                <input type="text" name="gst_no" class="form-control" value="<?= $user['gst_no'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Nominee Name</label>
                <input type="text" name="nominee_name" class="form-control" value="<?= $user['nominee_name'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label>Nominee Relation</label>
                <input type="text" name="nominee_relation" class="form-control" value="<?= $user['nominee_relation'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-danger">Block</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>