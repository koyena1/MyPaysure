<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') { header("Location: ../login.php"); exit; }
include '../includes/db.php';
$member_id = $_SESSION['username'];

// Fetch Directs
$stmt = $db->prepare("SELECT * FROM registrations WHERE sponsor_id = ?");
$stmt->execute([$member_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="card-box">
    <h3>My Direct Team</h3>
    <table class="table table-bordered">
        <thead>
            <tr><th>Name</th><th>Position</th><th>Mobile</th><th>Join Date</th></tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['position']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div></div></body></html>