<?php
include('../includes/db.php'); // ✅ uses your PDO connection

// Get filters
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$status = $_GET['status'] ?? '';

$query = "SELECT * FROM user_details WHERE 1";
$params = [];

// ✅ Date filtering safely with parameters
if (!empty($from_date) && !empty($to_date)) {
    $from = date('Y-m-d', strtotime($from_date));
    $to = date('Y-m-d', strtotime($to_date));
    $query .= " AND joining_date BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
} elseif (!empty($from_date)) {
    $from = date('Y-m-d', strtotime($from_date));
    $query .= " AND joining_date >= ?";
    $params[] = $from;
} elseif (!empty($to_date)) {
    $to = date('Y-m-d', strtotime($to_date));
    $query .= " AND joining_date <= ?";
    $params[] = $to;
}

// ✅ Status filter
if (!empty($status)) {
    $query .= " AND status = ?";
    $params[] = $status;
}

// ✅ Execute query
try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $results = [];
    $error_message = "⚠️ Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #eef3f8; }
    .card-header {
      background-color: #dda8f3;
      font-weight: 600;
      color: #333;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .toolbar i {
      margin-right: 10px;
      cursor: pointer;
      color: #333;
    }
    .toolbar i:hover { color: #6a1b9a; }
    table th, table td {
      text-align: center;
      vertical-align: middle;
      font-size: 14px;
    }
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
      <li class="breadcrumb-item active" aria-current="page">User Details</li>
    </ol>
  </nav>

  <div class="card shadow-sm">
    <div class="card-header">
      <div><i class="fa-solid fa-file-lines"></i> User Details</div>
      <div class="toolbar">
        <i class="fa-solid fa-plus" title="Add New"></i>
        <i class="fa-solid fa-pen" title="Edit"></i>
        <i class="fa-solid fa-trash" title="Delete"></i>
        <i class="fa-solid fa-file-export" title="Export"></i>
        <i class="fa-solid fa-rotate" title="Refresh" onclick="location.reload();"></i>
      </div>
    </div>

    <div class="card-body">
      <?php if (!empty($error_message)): ?>
        <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
      <?php endif; ?>

      <form method="GET" class="row g-2 mb-3 align-items-end">
        <div class="col-auto">
          <label>From Date</label>
          <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($from_date) ?>">
        </div>
        <div class="col-auto">
          <label>To Date</label>
          <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($to_date) ?>">
        </div>
        <div class="col-auto">
          <label>Status</label>
          <select name="status" class="form-select">
            <option value="">--Select Status--</option>
            <option value="Active" <?= ($status=="Active"?"selected":"") ?>>Active</option>
            <option value="Inactive" <?= ($status=="Inactive"?"selected":"") ?>>Inactive</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-secondary">Search</button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Action</th>
              <th>Name</th>
              <th>Member ID</th>
              <th>Password</th>
              <th>Sponsor ID</th>
              <th>Sponsor Name</th>
              <th>Mobile</th>
              <th>Available Balance</th>
              <th>Joining Amount</th>
              <th>Pair No</th>
              <th>PAN No</th>
              <th>Aadhaar No</th>
              <th>District</th>
              <th>Bank Name</th>
              <th>Account No</th>
              <th>IFSC Code</th>
              <th>Branch</th>
              <th>Joining Date</th>
              <th>Active Date</th>
              <th>Self BV</th>
              <th>Rep Left CF</th>
              <th>Rep Right CF</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($results) > 0): ?>
              <?php $count = 1; foreach ($results as $row): ?>
                <tr>
                  <td><?= $count++ ?></td>
                  <td>
                    <i class="fa fa-pen text-success me-2"></i>
                    <i class="fa fa-trash text-danger"></i>
                  </td>
                  <td><?= htmlspecialchars($row['member_name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['member_id'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['password'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['sponsor_id'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['sponsor_name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['mobile'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['available_balance'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['joining_amount'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['pair_no'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['pan_no'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['aadhaar_no'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['district'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['bank_name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['account_no'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['ifsc_code'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['branch'] ?? '') ?></td>
                  <td><?= !empty($row['joining_date']) ? date('d-m-Y', strtotime($row['joining_date'])) : '' ?></td>
                  <td><?= !empty($row['active_date']) ? date('d-m-Y', strtotime($row['active_date'])) : '' ?></td>
                  <td><?= htmlspecialchars($row['self_bv'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['rep_left_cf'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['rep_right_cf'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="24" class="text-center text-muted">No user records found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
