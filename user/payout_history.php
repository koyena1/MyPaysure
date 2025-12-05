<?php
session_start();
// Security Check
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
$member_id = $_SESSION['username'];

// Fetch Paid History
$stmt = $db->prepare("SELECT * FROM user_paid_unpaid_report WHERE member_id = ? ORDER BY payment_date DESC");
$stmt->execute([$member_id]);
$payouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card-box">
    <h3><i class="fa fa-history me-2"></i> Payout History</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Total Earned</th>
                    <th>Deductions (Admin + TDS)</th>
                    <th>Net Amount Paid</th>
                    <th>Transaction No</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($payouts) > 0): ?>
                    <?php foreach ($payouts as $row): ?>
                        <tr>
                            <td><?php echo date('d-M-Y', strtotime($row['payment_date'])); ?></td>
                            <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
                            <td class="text-danger">
                                -$<?php echo number_format($row['admin_charge'] + $row['tds_charge'], 2); ?>
                            </td>
                            <td class="text-success fw-bold">
                                $<?php echo number_format($row['total_payable_commission'], 2); ?>
                            </td>
                            <td><?php echo $row['transaction_no']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No payout history found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div></div></body></html>