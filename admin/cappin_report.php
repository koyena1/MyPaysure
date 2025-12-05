<?php
include('../includes/db.php'); // ✅ includes your PDO connection

// Initialize date filters
$from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';

$query = "SELECT * FROM cappin_report WHERE 1";
$params = [];

// ✅ Safely filter by date range if provided
if (!empty($from_date) && !empty($to_date)) {
    $from = date('Y-m-d', strtotime($from_date));
    $to = date('Y-m-d', strtotime($to_date));
    $query .= " AND report_date BETWEEN ? AND ?";
    $params = [$from, $to];
} elseif (!empty($from_date)) {
    $from = date('Y-m-d', strtotime($from_date));
    $query .= " AND report_date >= ?";
    $params = [$from];
} elseif (!empty($to_date)) {
    $to = date('Y-m-d', strtotime($to_date));
    $query .= " AND report_date <= ?";
    $params = [$to];
}

try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $results = [];
    $error_message = "⚠️ Database query failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cappin Report Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #eef3f8; }
    .card-header {
      background-color: #dda8f3;
      color: #333;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .card-header i {
      color: #6a1b9a;
      margin-right: 8px;
    }
    .toolbar i {
      font-size: 16px;
      margin-right: 10px;
      cursor: pointer;
      color: #333;
    }
    .toolbar i:hover { color: #6a1b9a; }
    table th, table td {
      text-align: center;
      vertical-align: middle;
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
      <li class="breadcrumb-item active" aria-current="page">Cappin Report</li>
    </ol>
  </nav>

  <div class="card shadow-sm">
    <div class="card-header">
      <div><i class="fa-solid fa-table-list"></i> Cappin Report Details</div>
      <div class="toolbar">
        <i class="fa-solid fa-plus" title="Add New"></i>
        <i class="fa-solid fa-pen" title="Edit"></i>
        <i class="fa-solid fa-trash" title="Delete"></i>
        <i class="fa-solid fa-file-lines" title="Export"></i>
        <i class="fa-solid fa-rotate" title="Refresh" onclick="location.reload();"></i>
      </div>
    </div>

    <div class="card-body">
      <?php if (!empty($error_message)): ?>
        <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
      <?php endif; ?>

      <form method="GET" class="row g-2 mb-3 align-items-center">
        <div class="col-auto">
          <label>From Date</label>
          <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($from_date) ?>">
        </div>
        <div class="col-auto">
          <label>To Date</label>
          <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($to_date) ?>">
        </div>
        <div class="col-auto mt-4">
          <button type="submit" class="btn btn-secondary">Search</button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Member Code</th>
              <th>Member Name</th>
              <th>Matching BV</th>
              <th>Matching Commission</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($results) > 0): ?>
              <?php $count = 1; foreach ($results as $row): ?>
                <tr>
                  <td><?= $count++ ?></td>
                  <td><?= htmlspecialchars($row['member_code'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['member_name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['matching_bv'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['matching_commission'] ?? '') ?></td>
                  <td><?= !empty($row['report_date']) ? date('d-m-Y', strtotime($row['report_date'])) : '' ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center text-muted">No records found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
