<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "paysure_insurance");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sponsor_id = $_POST['sponsor_id'];
    $sponsor_name = $_POST['sponsor_name'];
    $position = $_POST['position'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $father_name = $_POST['father_name'];
    $adhar = $_POST['adhar'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $bank_name = $_POST['bank_name'];
    $ifsc = $_POST['ifsc'];
    $account_number = $_POST['account_number'];
    $confirm_account_number = $_POST['confirm_account_number'];
    $nominee = $_POST['nominee'];

    $sql = "INSERT INTO registrations (sponsor_id, sponsor_name, position, full_name, gender, dob, mobile, email, father_name, adhar, country, state, district, city, address, pincode, bank_name, ifsc, account_number, confirm_account_number, nominee)
            VALUES ('$sponsor_id', '$sponsor_name', '$position', '$full_name', '$gender', '$dob', '$mobile', '$email', '$father_name', '$adhar', '$country', '$state', '$district', '$city', '$address', '$pincode', '$bank_name', '$ifsc', '$account_number', '$confirm_account_number', '$nominee')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration saved successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f9f9f9; font-family: Arial; }
        .section-title {
            background: #ff6600;
            color: #fff;
            padding: 6px 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .form-section { background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .btn-submit { background: #003b5c; color: white; padding: 10px 20px; border: none; }
        .btn-submit:hover { background: #025b8e; }
    </style>
</head>
<body>

<div class="container mt-4">
    <form method="POST" action="">
        
        <!-- Sponsor Details -->
        <div class="form-section">
            <div class="section-title">Sponsor Details</div>
            <div class="row">
                <div class="col-md-4">
                    <label>Sponsor ID</label>
                    <input type="text" name="sponsor_id" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Sponsor Name</label>
                    <input type="text" name="sponsor_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Position</label>
                    <select name="position" class="form-select">
                        <option value="Left">Left</option>
                        <option value="Right">Right</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="form-section">
            <div class="section-title">Personal Details</div>
            <div class="row">
                <div class="col-md-4">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Father Name</label>
                    <input type="text" name="father_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Aadhar</label>
                    <input type="text" name="adhar" class="form-control">
                </div>
            </div>
        </div>

        <!-- Address Details -->
        <div class="form-section">
            <div class="section-title">Address Details</div>
            <div class="row">
                <div class="col-md-4">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="India">
                </div>
                <div class="col-md-4">
                    <label>State</label>
                    <input type="text" name="state" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>District</label>
                    <input type="text" name="district" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>City/Village</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="col-md-8">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Pin Code</label>
                    <input type="text" name="pincode" class="form-control">
                </div>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="form-section">
            <div class="section-title">Bank Details</div>
            <div class="row">
                <div class="col-md-4">
                    <label>Bank Name</label>
                    <input type="text" name="bank_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>IFSC Code</label>
                    <input type="text" name="ifsc" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Account Number</label>
                    <input type="text" name="account_number" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Confirm Account Number</label>
                    <input type="text" name="confirm_account_number" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Nominee Account Holder</label>
                    <input type="text" name="nominee" class="form-control">
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <input type="checkbox" required> I agree to terms and conditions<br><br>
            <button type="submit" class="btn-submit">Submit</button>
        </div>
    </form>
</div>

</body>
</html>
