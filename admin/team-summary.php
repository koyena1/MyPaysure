<?php
include '../includes/db.php'; // adjust path if needed

// Fetch all team data
$query = "SELECT * FROM team_summary ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Summary</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body {
            background-color: #f7f9fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .team-summary {
            margin: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .team-summary h2 {
            background: #d3a7e0;
            color: white;
            padding: 15px;
            margin: 0;
            font-size: 22px;
        }

        .inactive {
            background-color: #ff4d4d;
            color: white;
            padding: 3px 10px;
            border-radius: 5px;
        }

        .active {
            background-color: #28a745;
            color: white;
            padding: 3px 10px;
            border-radius: 5px;
        }

        table.dataTable thead {
            background: #f2f2f2;
        }

        table {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="team-summary">
    <h2><i class="fa fa-table"></i> Team Summary</h2>
    <div style="padding: 20px;">
        <table id="teamTable" class="display">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Member ID</th>
                    <th>Member Name</th>
                    <th>Sponsor ID</th>
                    <th>Sponsor Name</th>
                    <th>Parent ID</th>
                    <th>Parent Name</th>
                    <th>Wallet Balance</th>
                    <th>Joining Amount</th>
                    <th>Status</th>
                    <th>Date Of Joining</th>
                    <th>Active Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && count($result) > 0):
                    $i = 1;
                    foreach ($result as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['member_id']); ?></td>
                            <td><?= htmlspecialchars($row['member_name']); ?></td>
                            <td><?= htmlspecialchars($row['sponsor_id']); ?></td>
                            <td><?= htmlspecialchars($row['sponsor_name']); ?></td>
                            <td><?= htmlspecialchars($row['parent_id']); ?></td>
                            <td><?= htmlspecialchars($row['parent_name']); ?></td>
                            <td><?= htmlspecialchars($row['wallet_balance']); ?></td>
                            <td><?= htmlspecialchars($row['joining_amount']); ?></td>
                            <td>
                                <?php if ($row['status'] === 'Active'): ?>
                                    <span class="active">Active</span>
                                <?php else: ?>
                                    <span class="inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['date_of_joining']); ?></td>
                            <td><?= htmlspecialchars($row['active_date']); ?></td>
                        </tr>
                    <?php endforeach; 
                else: ?>
                    <tr>
                        <td colspan="12" class="text-center text-muted">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        $('#teamTable').DataTable();
    });
</script>
</body>
</html>
