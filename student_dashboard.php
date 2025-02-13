<?php
session_start();
include("db.php"); // Include the database connection file

// Check if the student is logged in
if (!isset($_SESSION['usn'])) {
    header("Location: login.php");
    exit();
}

// Fetch all institutes from the `rsst` table
$institutes_query = $conn->query("SELECT * FROM rsst");

// Error checking for the query
if (!$institutes_query) {
    die("Error fetching institutes: " . mysqli_error($conn));
}
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
            display: flex;
            flex-direction: column;
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

        /* Logout Box at the Bottom */
        .logout-box {
            margin-top: auto; /* Pushes it to the bottom */
            padding: 10px;
            font-size: 16px;
            background-color: #e74c3c;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .logout-box:hover {
            background-color: #c0392b;
        }
        .logout-box a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Institutes</h2>
        <?php 
        // Check if we have any institutes
        if (mysqli_num_rows($institutes_query) > 0) {
            while ($row = $institutes_query->fetch_assoc()) { 
                // Linking to respective institute pages
                if ($row['institute_name'] === 'RV Institute of Technology') {
                    echo '<button onclick="window.location.href=\'rvit.php\'">' . htmlspecialchars($row['institute_name']) . '</button>';
                } elseif ($row['institute_name'] === 'RV College of Engineering') {
                    echo '<button onclick="window.location.href=\'rvce.php\'">' . htmlspecialchars($row['institute_name']) . '</button>';
                } elseif ($row['institute_name'] === 'RV School of Architecture') {
                    echo '<button onclick="window.location.href=\'rvsa.php\'">' . htmlspecialchars($row['institute_name']) . '</button>';
                } elseif ($row['institute_name'] === 'RV Institute of Management') {
                    echo '<button onclick="window.location.href=\'rvim.php\'">' . htmlspecialchars($row['institute_name']) . '</button>';
                } elseif ($row['institute_name'] === 'RV College of Nursing') {
                    echo '<button onclick="window.location.href=\'rvcn.php\'">' . htmlspecialchars($row['institute_name']) . '</button>';
                } else {
                    echo '<button onclick="loadInstitute(' . $row['institute_id'] . ')">' . htmlspecialchars($row['institute_name']) . '</button>';
                }
            }
        } else {
            echo "<p>No institutes found.</p>";
        }
        ?>

        <!-- Logout Box at Bottom -->
        <div class="logout-box">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Student Dashboard</h1>
        <p>Select an institute from the menu.</p>
        <div id="instituteData"></div>
    </div>

    <script>
        function loadInstitute(instituteId) {
            if (!instituteId) {
                console.error("Error: Institute ID is undefined.");
                return;
            }
            window.location.href = "institute.php?id=" + instituteId;
        }
    </script>

</body>
</html>
