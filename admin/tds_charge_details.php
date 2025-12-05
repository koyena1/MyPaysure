<?php
include '../includes/db.php'; // ✅ uses PDO connection ($db)

$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';

$query = "SELECT * FROM tds_charge_details WHERE 1=1";
$params = [];

// ✅ Use parameterized query for safety
if (!empty($from_date) && !empty($to_date)) {
    $query .= " AND DATE(created_at) BETWEEN ? AND ?";
    $params[] = $from_date;
    $params[] = $to_date;
}

try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $results = [];
    $error = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TDS Charge Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }
        .container {
            margin: 40px auto;
            width: 90%;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        h2 {
            background: #d4a3e3;
            padding: 10px;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        td, th {
            padding: 8px;
        }
        .error {
            background: #ffdddd;
            color: #900;
            padding: 10px;
            border: 1px solid #d33;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style> 
</head>
<body>
<div class="container">
    <h2>TDS Charge Details</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="GET">
        From Date: <input type="date" name="from_date" value="<?= htmlspecialchars($from_date) ?>">
        To Date: <input type="date" name="to_date" value="<?= htmlspecialchars($to_date) ?>">
        <button type="submit">Search</button>
    </form>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>PAN No</th>
                <th>TDS Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($results)): ?>
            <?php $i = 1; foreach ($results as $row): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['member_code'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['member_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['pan_no'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['tds_amount'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" align="center">No records found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
