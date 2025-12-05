<?php
// ✅ Include the working PDO database file
include '../includes/db.php'; // this file defines $db (PDO)

// ✅ Fetch payment records using PDO
$query = "SELECT * FROM user_paid_unpaid_report ORDER BY payment_date DESC";
$stmt  = $db->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Paid/Unpaid Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .page-header {
            background-color: #d6b4e2;
            padding: 10px;
            border-radius: 5px;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Paid/Unpaid Report</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header page-header">
            <h5 class="mb-0">User Paid/Unpaid Report</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>Sr#</th>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Total Amount</th>
                        <th>Admin Charge</th>
                        <th>TDS Charge</th>
                        <th>Total Payable Commission</th>
                        <th>Transaction No</th>
                        <th>Payment Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($results) > 0): ?>
                        <?php foreach ($results as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($row['member_id']) ?></td>
                                <td><?= htmlspecialchars($row['member_name']) ?></td>
                                <td><?= htmlspecialchars($row['total_amount']) ?></td>
                                <td><?= htmlspecialchars($row['admin_charge']) ?></td>
                                <td><?= htmlspecialchars($row['tds_charge']) ?></td>
                                <td><?= htmlspecialchars($row['total_payable_commission']) ?></td>
                                <td><?= htmlspecialchars($row['transaction_no']) ?></td>
                                <td><?= htmlspecialchars($row['payment_date']) ?></td>
                                <td>
                                    <a href="delete_payment.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this record?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10" class="text-center">No payment records found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
