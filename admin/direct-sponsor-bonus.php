<?php
include '../includes/db.php'; // ✅ adjust if your db.php path differs

// Fetch all bonus details
$query = "SELECT * FROM direct_sponsor_bonus ORDER BY date DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Direct Sponsor Bonus Details</title>
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
table.dataTable thead th {
    background-color: #f2f2f2;
}
</style>
</head>
<body>

<div class="container">
    <div class="page-title">Direct Sponsor Bonus Details</div>

    <table id="bonusTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>Franchise Code</th>
                <th>Sponsor Bonus</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['member_code']) ?></td>
                        <td><?= htmlspecialchars($row['member_name']) ?></td>
                        <td><?= htmlspecialchars($row['franchise_code']) ?></td>
                        <td><?= htmlspecialchars($row['sponsor_bonus']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No Records Found</td></tr>
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