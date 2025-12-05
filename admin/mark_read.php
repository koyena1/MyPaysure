<?php
// mark_read.php
session_start();
require 'includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error'=>'not_logged_in']); exit;
}

$user_id = (int)$_SESSION['user_id'];

if (isset($_POST['all']) && $_POST['all'] == '1') {
    $stmt = $conn->prepare("UPDATE notifications SET is_read=1 WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    echo json_encode(['ok'=>true]);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(['error'=>'missing_id']); exit;
}

$id = (int)$_POST['id'];
$stmt = $conn->prepare("UPDATE notifications SET is_read=1 WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
echo json_encode(['ok'=>true]);
