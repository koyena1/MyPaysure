<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') { header("Location: ../login.php"); exit; }
include '../includes/db.php';
$member_id = $_SESSION['username'];

$stmt = $db->prepare("SELECT * FROM matching_bonus_details WHERE member_code = ? ORDER BY date DESC");
$stmt->execute([$member_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="card-box">
    <h3>Matching Bonus Report</h3>
    <table class="table table-striped">
        <thead>
            <tr><th>Date</th><th>Matching BV</th><th>Commission</th><th>Left CF</th><th>Right CF</th></tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['matching_bv']; ?></td>
                <td class="text-success fw-bold">$<?php echo $row['matching_commission']; ?></td>
                <td><?php echo $row['left_cf']; ?></td>
                <td><?php echo $row['right_cf']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div></div></body></html>