<?php
// Include your PDO database connection
include '../includes/db.php';

// Fetch all user activation history records
$query = "SELECT * FROM user_activation_history ORDER BY activation_date DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Activation History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #6f42c1 !important;
            color: white;
        }
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
        table th {
            background-color: #f8f9fa;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #6f42c1;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Activation History</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fa-solid fa-bolt me-2"></i>User Activation History</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Activation From ID</th>
                        <th>Member Code</th>
                        <th>Member Name</th>
                        <th>Package Name</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)): ?>
                        <?php $count = 1; ?>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= htmlspecialchars($row['activation_from_id']); ?></td>
                                <td><?= htmlspecialchars($row['member_code']); ?></td>
                                <td><?= htmlspecialchars($row['member_name']); ?></td>
                                <td><?= htmlspecialchars($row['package_name']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['activation_date'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No activation records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- FontAwesome (for icons) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

</body>
</html>
