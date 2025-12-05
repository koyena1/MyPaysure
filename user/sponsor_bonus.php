<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') { header("Location: ../login.php"); exit; }
include '../includes/db.php';
$member_id = $_SESSION['username'];

$stmt = $db->prepare("SELECT * FROM direct_sponsor_bonus WHERE member_code = ? ORDER BY date DESC");
$stmt->execute([$member_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="card-box">
    <h3>Direct Sponsor Bonus</h3>
    <table class="table table-striped">
        <thead>
            <tr><th>Date</th><th>From Member (Franchise Code)</th><th>Bonus Amount</th></tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['franchise_code']; ?></td>
                <td class="text-success fw-bold">$<?php echo $row['sponsor_bonus']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div></div></body></html>