<?php
session_start();
include("db.php");

if (!isset($_SESSION['usn'])) {
    header("Location: login.php");
    exit();
}

// Fetch data from database
$institutes = mysqli_query($conn, "SELECT * FROM institutes");
$departments = mysqli_query($conn, "SELECT d.*, i.institute_name FROM departments d JOIN institutes i ON d.institute_id = i.institute_id");
$faculties = mysqli_query($conn, "SELECT f.*, d.department_name FROM faculties f JOIN departments d ON f.department_id = d.department_id");
$students = mysqli_query($conn, "SELECT s.*, d.department_name FROM students s JOIN departments d ON s.department_id = d.department_id");

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
            background-color: #f5f5f5;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h2 {
            background-color: #3498db;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout {
            display: inline-block;
            padding: 10px 20px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION['student_name']; ?>!</h1>

    <h2>Institutes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($institutes)) { ?>
            <tr>
                <td><?php echo $row['institute_id']; ?></td>
                <td><?php echo $row['institute_name']; ?></td>
                <td><?php echo $row['address']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Departments</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Institute</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($departments)) { ?>
            <tr>
                <td><?php echo $row['department_id']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
                <td><?php echo $row['institute_name']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Faculties</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Department</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($faculties)) { ?>
            <tr>
                <td><?php echo $row['faculty_id']; ?></td>
                <td><?php echo $row['faculty_name']; ?></td>
                <td><?php echo $row['faculty_designation']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Students</h2>
    <table>
        <tr>
            <th>USN</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Semester</th>
            <th>Department</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?php echo $row['usn']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>