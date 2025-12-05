<?php
include '../includes/db.php'; // Use existing PDO connection

// Fetch all records using PDO
$query = "SELECT * FROM my_directs ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Direct</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f3f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-content {
            margin-left: 250px; /* adjust based on your sidebar width */
            padding: 20px;
        }
        .header-bar {
            background-color: #e6b8f0;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px 6px 0 0;
            font-size: 18px;
            font-weight: 600;
        }
        .breadcrumb {
            background: none;
            margin-bottom: 0;
            padding: 0;
            font-size: 14px;
        }
        .table thead {
            background-color: #9c27b0;
            color: #fff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .inactive {
            color: red;
            font-weight: bold;
        }
        .active {
            color: green;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            .table {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>


<div class="main-content">
    <div class="breadcrumb mb-2">
        <a href="index.php">🏠 Home</a> › My Direct
    </div>

    <div class="header-bar">
        📋 My Direct
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-striped mt-3 text-center align-middle">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Sponsor ID</th>
                    <th>Sponsor Name</th>
                    <th>Parent ID</th>
                    <th>Parent Name</th>
                    <th>Active Status</th>
                    <th>Date Of Joining</th>
                    <th>Date Of Active</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && count($result) > 0) {
                    $sr = 1;
                    foreach ($result as $row) {
                        $statusClass = strtolower($row['active_status']);
                        echo "<tr>
                            <td>{$sr}</td>
                            <td>{$row['member_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['mobile']}</td>
                            <td>{$row['sponsor_id']}</td>
                            <td>{$row['sponsor_name']}</td>
                            <td>{$row['parent_id']}</td>
                            <td>{$row['parent_name']}</td>
                            <td class='{$statusClass}'>{$row['active_status']}</td>
                            <td>{$row['date_of_joining']}</td>
                            <td>{$row['date_of_active']}</td>
                        </tr>";
                        $sr++;
                    }
                } else {
                    echo "<tr><td colspan='11' class='text-center text-muted'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
