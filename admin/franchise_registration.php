<?php
include '../includes/db.php'; // your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = [
        'sponsor_id', 'sponsor_name', 'franchise_name', 'mobile_no', 'email', 'pan_no',
        'country', 'state', 'district', 'city', 'address', 'pin_code',
        'franchise_type', 'joining_amount', 'product_amount', 'pin_amount',
        'product_commission', 'pin_commission', 'transaction_no',
        'bank_name', 'ifsc_code', 'account_number', 'confirm_account_number', 'account_holder_name'
    ];

    $values = [];
    foreach ($fields as $field) {
        $values[$field] = $_POST[$field] ?? '';
    }

    $sql = "INSERT INTO franchise_registration (" . implode(',', $fields) . ")
            VALUES ('" . implode("','", array_map('addslashes', $values)) . "')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Franchise registered successfully!'); window.location.href='franchise_registration.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Franchise Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .section-title {
            background: linear-gradient(90deg, #183d1d, #7a5f00);
            color: #fff;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        .card { margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-4">Franchise Registration</h3>
    <form method="POST" action="save_franchise.php">
        <!-- Sponsor Details -->
        <div class="card p-3">
            <div class="section-title">Sponsor Details</div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Sponsor ID</label>
                    <input type="text" name="sponsor_id" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Sponsor Name</label>
                    <input type="text" name="sponsor_name" class="form-control">
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="card p-3">
            <div class="section-title">Personal Details</div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Franchise Name *</label>
                    <input type="text" name="franchise_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Mobile No *</label>
                    <input type="text" name="mobile_no" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Email ID</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>PAN No</label>
                    <input type="text" name="pan_no" class="form-control">
                </div>
            </div>
        </div>

        <!-- Address Details -->
        <div class="card p-3">
            <div class="section-title">Address Details</div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Country *</label>
                    <input type="text" name="country" value="India" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>State *</label>
                    <input type="text" name="state" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>District *</label>
                    <input type="text" name="district" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>City/Village</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Pin Code *</label>
                    <input type="text" name="pin_code" class="form-control" required>
                </div>
            </div>
        </div>

        <!-- Franchise Details -->
        <div class="card p-3">
            <div class="section-title">Franchise Details</div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Select Franchise Type *</label>
                    <input type="text" name="franchise_type" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Joining Amount</label>
                    <input type="number" name="joining_amount" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Product Amount</label>
                    <input type="number" name="product_amount" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Pin Amount</label>
                    <input type="number" name="pin_amount" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Product Commission (%)</label>
                    <input type="number" name="product_commission" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Pin Commission (%)</label>
                    <input type="number" name="pin_commission" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Transaction No</label>
                    <input type="text" name="transaction_no" class="form-control">
                </div>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="card p-3">
            <div class="section-title">Bank Details</div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Bank Name *</label>
                    <input type="text" name="bank_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>IFSC Code *</label>
                    <input type="text" name="ifsc_code" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Account Number *</label>
                    <input type="text" name="account_number" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Confirm Account Number *</label>
                    <input type="text" name="confirm_account_number" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Name of Account Holder *</label>
                    <input type="text" name="account_holder_name" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" required>
            <label class="form-check-label">I agree to terms and conditions</label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
</body>
</html>
