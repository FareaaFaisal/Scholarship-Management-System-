<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "12345";
$db = "sms";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch applied scholarships for the logged-in user
$email = $_SESSION['email'];
$sql = "SELECT a.full_name, a.email, a.phone, a.cnic, a.city, a.district, a.country, a.department, a.degree_program, a.year_of_study, a.cgpa, a.income, a.selection_type, a.submission_date, s.name AS scholarship_name
        FROM applications a
        JOIN scholarships s ON a.scholarship_id = s.scholarship_id
        WHERE a.email = '$email' ORDER BY a.submission_date DESC";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Applied Scholarships</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e1e1e, #4b4b4b);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative;
        }

        .background-animation {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/diamond-pattern.png');
            background-size: 100px 100px;
            animation: moveBackground 10s linear infinite;
            z-index: -1;
        }

        @keyframes moveBackground {
            0% { background-position: 0 0; }
            100% { background-position: 100px 100px; }
        }

        .table-container {
            background: rgba(0,0,0,0.6);
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 750px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            backdrop-filter: blur(10px);
        }

        h2 {
            font-size: 2rem;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #fff;
        }

        th {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: #333;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #5b21b6;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        .back-btn:hover {
            background-color: #4a1f93;
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>

    <div class="table-container m-4">
         <h2 class="text-3xl font-semibold text-white text-center mb-6 border-b-2 border-purple-600 pb-2 tracking-wide capitalize">
             Applied Scholarships
        </h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Scholarship Name</th>
                        <th>Full Name</th>
                        <th>Selection Type</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['scholarship_name']) ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['selection_type']) ?></td>
                            <td><?= date('F j, Y', strtotime($row['submission_date'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-300">You have not applied for any scholarships yet.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
