<?php
$conn = mysqli_connect("localhost", "root", "", "university_db");

// Assuming RVCE's institute_id is 1
$institute_id = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RVCE Institute Data</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #1a1a1a;
            color: #ffd700;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #242424;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.2);
        }

        .section {
            background-color: #242424;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.2);
        }

        .department-section {
            margin-bottom: 30px;
            background-color: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
        }

        .department-header {
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        h1, h2, h3 {
            color: #ffd700;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ffd700;
        }

        th {
            background-color: #1a1a1a;
            color: #ffd700;
        }

        tr:hover {
            background-color: #333;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffd700;
            color: #1a1a1a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background-color: #ffed4a;
        }

        .student-count {
            color: #ffd700;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Updated Back Button to redirect to student_dashboard.php -->
        <a href="student_dashboard.php" class="back-btn">Back to Dashboard</a>
        
        <?php
        // Get Institute Details
        $query = "SELECT * FROM rsst WHERE institute_id = $institute_id";
        $result = mysqli_query($conn, $query);
        
        if ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='header'>";
            echo "<h1>" . $row['institute_name'] . "</h1>";
            echo "<p>Address: " . $row['address'] . "</p>";
            echo "</div>";
        }

        // Get Departments
        echo "<div class='section'>";
        echo "<h2>Departments</h2>";
        $query = "SELECT * FROM institute WHERE institute_id = $institute_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Department ID</th><th>Department Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['department_id'] . "</td>";
                echo "<td>" . $row['department_name'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No departments found.</p>";
        }
        echo "</div>";

        // Get Professors
        echo "<div class='section'>";
        echo "<h2>Professors</h2>";
        $query = "SELECT d.professor_id, d.professor_name, d.professor_designation, i.department_name 
                 FROM department d 
                 JOIN institute i ON d.department_id = i.department_id 
                 WHERE i.institute_id = $institute_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Professor ID</th><th>Name</th><th>Designation</th><th>Department</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['professor_id'] . "</td>";
                echo "<td>" . $row['professor_name'] . "</td>";
                echo "<td>" . $row['professor_designation'] . "</td>";
                echo "<td>" . $row['department_name'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No professors found.</p>";
        }
        echo "</div>";

        // Get Students Grouped by Department
        echo "<div class='section'>";
        echo "<h2>Students by Department</h2>";
        
        // First get all departments
        $dept_query = "SELECT DISTINCT i.department_id, i.department_name 
                      FROM institute i 
                      WHERE i.institute_id = $institute_id 
                      ORDER BY i.department_name";
        $dept_result = mysqli_query($conn, $dept_query);

        while ($dept = mysqli_fetch_assoc($dept_result)) {
            echo "<div class='department-section'>";
            
            // Get student count for this department
            $count_query = "SELECT COUNT(*) as count FROM student 
                           WHERE department_id = " . $dept['department_id'];
            $count_result = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);
            
            echo "<div class='department-header'>";
            echo "<h3>" . $dept['department_name'] . 
                 "<span class='student-count'>(" . $count_row['count'] . " students)</span></h3>";
            echo "</div>";

            // Get students for this department
            $student_query = "SELECT s.usn, s.student_name 
                            FROM student s 
                            WHERE s.department_id = " . $dept['department_id'] . 
                            " ORDER BY s.student_name";
            $student_result = mysqli_query($conn, $student_query);

            if (mysqli_num_rows($student_result) > 0) {
                echo "<table>";
                echo "<tr><th>USN</th><th>Name</th></tr>";
                while ($student = mysqli_fetch_assoc($student_result)) {
                    echo "<tr>";
                    echo "<td>" . $student['usn'] . "</td>";
                    echo "<td>" . $student['student_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No students in this department.</p>";
            }
            echo "</div>";
        }
        echo "</div>";
        ?>
    </div>
</body>
</html>
