<?php
// admin/send_notification.php
session_start();
// optional: check admin privileges. e.g. if (!$_SESSION['is_admin']) die('forbidden');
require '../includes/db.php';

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['to'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($title === '') $error = 'Title required';
    else {
        if ($to === 'all') {
            // insert for all users
            $users = $conn->query("SELECT id FROM users");
            $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
            foreach ($users as $u) {
                $stmt->bind_param("iss", $u['id'], $title, $message);
                $stmt->execute();
            }
            $sent = true;
        } else {
            // single user id
            $user_id = (int)$to;
            $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $title, $message);
            $stmt->execute();
            $sent = true;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Send Notification (Admin)</title>
    <style>
        body{font-family:Arial; padding:20px}
        form {max-width:600px}
        label{display:block;margin-top:10px}
        input, textarea, select{width:100%;padding:8px;margin-top:6px}
        .ok{color:green}
        .err{color:red}
    </style>
</head>
<body>
    <h2>Send Notification</h2>
    <?php if($sent): ?><p class="ok">Notification sent.</p><?php endif; ?>
    <?php if($error): ?><p class="err"><?=htmlspecialchars($error)?></p><?php endif; ?>

    <form method="post">
        <label>Send to
            <select name="to">
                <option value="all">All Users</option>
                <?php
                $users = $conn->query("SELECT id, full_name, email FROM users ORDER BY full_name");
                while ($u = $users->fetch_assoc()):
                ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['full_name'].' ('.$u['email'].')') ?></option>
                <?php endwhile; ?>
            </select>
        </label>

        <label>Title
            <input type="text" name="title" required>
        </label>

        <label>Message
            <textarea name="message" rows="5"></textarea>
        </label>

        <button type="submit">Send Notification</button>
    </form>
</body>
</html>
