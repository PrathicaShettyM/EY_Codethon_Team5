<?php
session_start();
include("db.php");

if (!isset($_SESSION['usn'])) {
    header("Location: login.php");
    exit();
}

// Fetch all institutes from the `rsst` table
$institutes_query = $conn->query("SELECT * FROM rsst");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            border-bottom: 2px solid white;
            padding-bottom: 10px;
        }
        .sidebar button {
            display: block;
            width: 100%;
            background: #3498db;
            color: white;
            border: none;
            padding: 10px;
            margin: 10px 0;
            text-align: left;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .sidebar button:hover {
            background: #2980b9;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
            background: #f5f5f5;
        }
        h1 {
            background: #3498db;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Institutes</h2>
        <?php while ($row = $institutes_query->fetch_assoc()) { ?>
            <button onclick="loadInstitute(<?php echo $row['id']; ?>)">
                <?php echo htmlspecialchars($row['institute_name']); ?>
            </button>
        <?php } ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Student Dashboard</h1>
        <p>Select an institute from the menu.</p>
        <div id="instituteData"></div>
    </div>

    <script>
        function loadInstitute(id) {
            alert("Load institute with ID: " + id);
            // You can implement AJAX here to load institute details dynamically
        }
    </script>

</body>
</html>
