<?php
include('../includes/db.php'); // ✅ Use your PDO db connection

// Fetch data safely using PDO
try {
    $stmt = $db->prepare("SELECT * FROM user_pending_payments");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    $results = [];
    $error_message = "⚠️ Database table 'user_pending_payments' not found or query failed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Pending Payment Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .card-header {
      background: #d9b3ff;
      color: #333;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .card-header i {
      margin-right: 10px;
      color: #6a1b9a;
    }
    table th, table td {
      text-align: center;
      vertical-align: middle;
    }
    .toolbar i {
      font-size: 16px;
      margin-right: 10px;
      cursor: pointer;
      color: #333;
    }
    .toolbar i:hover { color: #6a1b9a; }
    .error-box {
      background-color: #ffebee;
      color: #b71c1c;
      border: 1px solid #ef9a9a;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="container-fluid mt-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">User Pending Payment Details</li>
    </ol>
  </nav>

  <div class="card shadow-sm">
    <div class="card-header">
      <div><i class="fa-solid fa-table-list"></i> User Pending Payment Details</div>
      <div class="toolbar">
        <i class="fa-solid fa-plus" title="Add New"></i>
        <i class="fa-solid fa-pen-to-square" title="Edit"></i>
        <i class="fa-solid fa-trash" title="Delete"></i>
        <i class="fa-solid fa-file-lines" title="Export"></i>
        <i class="fa-solid fa-rotate" title="Refresh" onclick="location.reload();"></i>
      </div>
    </div>

    <div class="card-body table-responsive">
      <?php if (!empty($error_message)): ?>
        <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
      <?php endif; ?>

      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Sl No</th>
            <th>User Id</th>
            <th>Name</th>
            <th>Bank</th>
            <th>Branch</th>
            <th>AC No</th>
            <th>IFSC</th>
            <th>PAN No</th>
            <th>Pair No</th>
            <th>Pending Pair</th>
            <th>Total Bonus</th>
            <th>Admin Charge</th>
            <th>TDS</th>
            <th>Total Payable Commission</th>
            <th>Status</th>
            <th>KYC Status</th>
            <th>Transaction No</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($results) > 0): ?>
            <?php $count = 1; foreach ($results as $row): ?>
              <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['user_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['bank_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['branch'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['ac_no'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['ifsc'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['pan_no'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['pair_no'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['pending_pair'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['total_bonus'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['admin_charge'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['tds'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['total_commission'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['kyc_status'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['transaction_no'] ?? '') ?></td>
                <td>
                  <a href='#' class='text-primary me-2'><i class='fa-solid fa-pen'></i></a>
                  <a href='#' class='text-danger'><i class='fa-solid fa-trash'></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="18" class="text-center text-muted">No records found</td></tr>
          <?php endif; ?>
        </tbody>
        <tfoot class="table-light">
          <tr>
            <td colspan="9" class="text-end fw-bold">Total:</td>
            <td colspan="4">0</td>
            <td colspan="5"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

</body>
</html>
