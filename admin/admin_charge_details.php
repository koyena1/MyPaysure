<?php
/*****************************
 * DATABASE CONNECTION
 *****************************/
$servername = "localhost";  // Database host
$username   = "root";       // Database username
$password   = "";           // Database password
$dbname     = "paysure_insurance"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// ✅ Handle connection errors cleanly
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/*****************************
 * FILTER DATA BASED ON DATE
 *****************************/
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$query = "SELECT * FROM admin_charge_details WHERE 1=1";

if (!empty($from_date) && !empty($to_date)) {
    $query .= " AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Charge Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fafafa;
            margin: 0;
        }
        .container {
            margin: 40px auto;
            width: 90%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        h2 {
            background: #d4a3e3;
            color: #fff;
            padding: 15px;
            margin: 0;
        }
        form {
            padding: 15px;
            background: #f7f7f7;
        }
        form input, form button {
            padding: 8px;
            margin-right: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            background: #d4a3e3;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background: #b782cf;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f2f2f2;
            text-align: left;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #faf0ff;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Charge Details</h2>

    <form method="GET">
        From Date:
        <input type="date" name="from_date" value="<?= htmlspecialchars($from_date) ?>">
        To Date:
        <input type="date" name="to_date" value="<?= htmlspecialchars($to_date) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>PAN No</th>
                <th>Admin Charge</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['member_code']}</td>
                            <td>{$row['member_name']}</td>
                            <td>{$row['pan_no']}</td>
                            <td>{$row['admin_charge']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='6' class='no-data'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
