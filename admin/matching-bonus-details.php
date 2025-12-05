<?php
include '../includes/db.php'; // ✅ your db.php path

// Initialize filters
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date   = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$query = "SELECT * FROM matching_bonus_details WHERE 1";
$params = [];

if (!empty($from_date) && !empty($to_date)) {
    $query .= " AND date BETWEEN ? AND ?";
    $params = [$from_date, $to_date];
} elseif (!empty($from_date)) {
    $query .= " AND date >= ?";
    $params = [$from_date];
} elseif (!empty($to_date)) {
    $query .= " AND date <= ?";
    $params = [$to_date];
}

// Safely run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log and gracefully handle the error
    error_log("DB Error: " . $e->getMessage());
    $results = []; // Empty array to prevent fatal errors

    // Optional: Show message if table missing
    $error_message = "⚠️ Database table 'matching_bonus_details' not found. Please verify the table name or create it in the database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matching Bonus Details</title>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f7f9fb;
}
.page-title {
    background-color: #d79ae0;
    padding: 10px;
    font-weight: bold;
    color: white;
}
.container {
    padding: 20px;
}
.search-section {
    margin-bottom: 15px;
}
table.dataTable thead th {
    background-color: #f2f2f2;
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

<div class="container">
    <div class="page-title">Matching Bonus Details</div>

    <?php if (!empty($error_message)): ?>
        <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="GET" class="search-section">
        <label>From Date:</label>
        <input type="date" name="from_date" value="<?= htmlspecialchars($from_date) ?>">
        <label>To Date:</label>
        <input type="date" name="to_date" value="<?= htmlspecialchars($to_date) ?>">
        <button type="submit">Search</button>
    </form>

    <table id="bonusTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>Matching BV</th>
                <th>Matching Commission</th>
                <th>Date</th>
                <th>Left CF</th>
                <th>Right CF</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['member_code'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['member_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['matching_bv'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['matching_commission'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['date'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['left_cf'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['right_cf'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" style="text-align:center;">No Records Found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#bonusTable').DataTable();
});
</script>

</body>
</html>
