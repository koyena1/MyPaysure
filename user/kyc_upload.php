<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') { header("Location: ../login.php"); exit; }
include '../includes/db.php';
$member_id = $_SESSION['username'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $target_dir = "../uploads/kyc/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $file_name = $member_id . "_" . basename($_FILES["document"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
        // Update DB
        $stmt = $db->prepare("INSERT INTO member_kyc (member_id, document_type, document_front_url, status) VALUES (?, 'ID Proof', ?, 'pending')");
        $stmt->execute([$member_id, $file_name]);
        $msg = "<div class='alert alert-success'>KYC Uploaded Successfully! Wait for admin approval.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Upload failed.</div>";
    }
}
?>
<div class="card-box">
    <h3>Upload KYC Document</h3>
    <?php echo $msg; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Select Document (Aadhar/PAN)</label>
            <input type="file" name="document" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Upload</button>
    </form>
</div>
</div></div></body></html>