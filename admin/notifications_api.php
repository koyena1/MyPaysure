<?php
// notifications_api.php
session_start();
require 'includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// optionally accept ?limit=...
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// fetch last N notifications
$stmt = $conn->prepare("SELECT id, title, message, is_read, created_at FROM notifications WHERE user_id=? ORDER BY created_at DESC LIMIT ?");
$stmt->bind_param("ii", $user_id, $limit);
$stmt->execute();
$res = $stmt->get_result();
$notifications = $res->fetch_all(MYSQLI_ASSOC);

// unread count
$countStmt = $conn->prepare("SELECT COUNT(*) AS unread FROM notifications WHERE user_id=? AND is_read=0");
$countStmt->bind_param("i", $user_id);
$countStmt->execute();
$unread = $countStmt->get_result()->fetch_assoc()['unread'];

echo json_encode([
    'notifications' => $notifications,
    'unread' => (int)$unread
]);
