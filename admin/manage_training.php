<?php
session_start();

// FIX: Correct path to connect to database from the admin folder
if (file_exists('../includes/config.php')) {
    include '../includes/config.php';
} else {
    die("Error: Could not find config.php. Please check file path.");
}

// 1. Initialize Edit Variables
$edit_mode = false;
$edit_id = '';
$e_title = '';
$e_date = '';
$e_start_raw = '';
$e_start_ampm = 'AM';
$e_end_raw = '';
$e_end_ampm = 'AM';
$e_trainer = '';
$e_link = '';
$e_desc = '';

// 2. Handle Add Event (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    if (!isset($conn)) { die("Database connection failed."); }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    
    // Time Conversion
    $start_time = date("H:i:s", strtotime($_POST['start_time_raw'] . " " . $_POST['start_ampm']));
    $end_time = date("H:i:s", strtotime($_POST['end_time_raw'] . " " . $_POST['end_ampm']));

    $link = $_POST['link'];

    $sql = "INSERT INTO training_events (title, description, trainer_name, event_date, start_time, end_time, meeting_link) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $title, $description, $trainer, $date, $start_time, $end_time, $link);
    $stmt->execute();
    header("Location: manage_training.php?msg=added");
    exit();
}

// 3. Handle Update Event (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    if (!isset($conn)) { die("Database connection failed."); }

    $id = $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];

    // Time Conversion
    $start_time = date("H:i:s", strtotime($_POST['start_time_raw'] . " " . $_POST['start_ampm']));
    $end_time = date("H:i:s", strtotime($_POST['end_time_raw'] . " " . $_POST['end_ampm']));

    $link = $_POST['link'];

    $sql = "UPDATE training_events SET title=?, description=?, trainer_name=?, event_date=?, start_time=?, end_time=?, meeting_link=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $title, $description, $trainer, $date, $start_time, $end_time, $link, $id);
    $stmt->execute();
    header("Location: manage_training.php?msg=updated");
    exit();
}

// 4. Handle Delete Request (GET)
if (isset($_GET['delete'])) {
    if (!isset($conn)) { die("Database connection failed."); }
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM training_events WHERE id = $id");
    header("Location: manage_training.php?msg=deleted");
    exit();
}

// 5. Handle Edit Request (GET) - Fetch Data for Form
if (isset($_GET['edit'])) {
    if (!isset($conn)) { die("Database connection failed."); }
    $edit_id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM training_events WHERE id = $edit_id");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $edit_mode = true;
        
        $e_title = $row['title'];
        $e_date = $row['event_date'];
        $e_trainer = $row['trainer_name'];
        $e_link = $row['meeting_link'];
        $e_desc = $row['description'];

        // Convert DB 24h Time back to 12h + AM/PM
        $e_start_raw = date('h:i', strtotime($row['start_time']));
        $e_start_ampm = date('A', strtotime($row['start_time']));
        
        $e_end_raw = date('h:i', strtotime($row['end_time']));
        $e_end_ampm = date('A', strtotime($row['end_time']));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Training - Admin</title>
    <style>
        /* Base Layout for Sidebar */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: #f4f6f9; 
            margin: 0; 
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #212529;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar h3 {
            text-align: center;
            border-bottom: 1px solid #495057;
            padding-bottom: 15px;
            margin-top: 0;
        }

        .sidebar a {
            color: #c2c7d0;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 1rem;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #343a40;
            color: white;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white !important;
            margin-top: auto;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #c82333 !important;
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        /* Container Styles */
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        
        /* Form Styles */
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        
        .btn-cancel { background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 4px; color: white; font-size: 13.33px;}
        .btn-cancel:hover { background: #5a6268; }

        /* Time Input Group Styling */
        .time-group {
            display: flex;
            gap: 10px;
        }
        .time-group input {
            flex: 2;
        }
        .time-group select {
            flex: 1;
        }

        /* Table Styles */
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        
        /* Action Buttons */
        .btn-edit { background: #ffc107; font-size: 0.8rem; padding: 5px 10px; text-decoration: none; color: #212529; border-radius: 3px; margin-right: 5px; }
        .btn-delete { background: #dc3545; font-size: 0.8rem; padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="manage_training.php" class="active">📅 Manage Training</a>
        <a href="logout.php" class="logout-btn">🚪 Logout</a>
    </div>

    <div class="main-content">
        <div class="container">
            <h2><?php echo $edit_mode ? 'Edit Training Event' : 'Add New Training Event'; ?></h2>
            
            <form method="POST" action="">
                <?php if($edit_mode): ?>
                    <input type="hidden" name="event_id" value="<?php echo $edit_id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Event Title</label>
                    <input type="text" name="title" required value="<?php echo htmlspecialchars($e_title); ?>">
                </div>
                <div style="display: flex; gap: 20px;">
                    <div class="form-group" style="flex:1">
                        <label>Date</label>
                        <input type="date" name="date" required value="<?php echo $e_date; ?>">
                    </div>
                    
                    <div class="form-group" style="flex:1">
                        <label>Start Time</label>
                        <div class="time-group">
                            <input type="text" name="start_time_raw" placeholder="09:30" pattern="[0-9]{1,2}:[0-9]{2}" required value="<?php echo $e_start_raw; ?>">
                            <select name="start_ampm">
                                <option value="AM" <?php if($e_start_ampm == 'AM') echo 'selected'; ?>>AM</option>
                                <option value="PM" <?php if($e_start_ampm == 'PM') echo 'selected'; ?>>PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="flex:1">
                        <label>End Time</label>
                        <div class="time-group">
                            <input type="text" name="end_time_raw" placeholder="11:30" pattern="[0-9]{1,2}:[0-9]{2}" required value="<?php echo $e_end_raw; ?>">
                            <select name="end_ampm">
                                <option value="AM" <?php if($e_end_ampm == 'AM') echo 'selected'; ?>>AM</option>
                                <option value="PM" <?php if($e_end_ampm == 'PM') echo 'selected'; ?>>PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Trainer Name</label>
                    <input type="text" name="trainer" placeholder="e.g. Mr. Anirban Das" value="<?php echo htmlspecialchars($e_trainer); ?>">
                </div>
                <div class="form-group">
                    <label>Meeting Link (Zoom/Google Meet)</label>
                    <input type="text" name="link" placeholder="https://zoom.us/..." value="<?php echo htmlspecialchars($e_link); ?>">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3"><?php echo htmlspecialchars($e_desc); ?></textarea>
                </div>
                
                <?php if($edit_mode): ?>
                    <button type="submit" name="update_event">Update Event</button>
                    <a href="manage_training.php" class="btn-cancel">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_event">Add Event</button>
                <?php endif; ?>
            </form>

            <h2>Existing Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Time (AM/PM)</th>
                        <th>Trainer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($conn)) {
                        $result = $conn->query("SELECT * FROM training_events ORDER BY event_date DESC");
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['event_date'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                echo "<td>" . date('h:i A', strtotime($row['start_time'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['trainer_name']) . "</td>";
                                echo "<td>";
                                // Added Edit Button
                                echo "<a href='?edit=".$row['id']."' class='btn-edit'>Edit</a>";
                                echo "<a href='?delete=".$row['id']."' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No events found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='color:red; text-align:center;'>Database connection error.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>