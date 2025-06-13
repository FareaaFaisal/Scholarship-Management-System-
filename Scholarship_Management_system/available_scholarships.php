<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "12345";
$db = "sms";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch scholarships from the database
$sql = "SELECT * FROM scholarships";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $scholarship_id = $_POST['delete'];
        // Delete scholarship
        $delete_sql = "DELETE FROM scholarships WHERE scholarship_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $scholarship_id);
        if ($stmt->execute()) {
            echo "✅ Scholarship deleted successfully!";
        } else {
            echo "❌ Error deleting scholarship!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Available Scholarships</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(135deg, #1e1e1e, #4b4b4b);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      /* overflow: hidden; */
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
      background: rgba(0, 0, 0, 0.6);
      border-radius: 10px;
      padding: 40px;
      width: 100%;
      max-width: 900px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
    }

    h2 {
      font-size: 2.5rem;
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    table {
      width: 100%;
      border-collapse: collapse;
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

    button {
      padding: 6px 12px;
      border-radius: 4px;
      background-color: #5b21b6;
      color: white;
      cursor: pointer;
      border: none;
    }

    button:hover {
      background-color: rgb(85, 94, 221);
      box-shadow: 0 0 15px rgb(7, 26, 92), 0 0 30px rgb(67, 40, 129);
    }
  </style>
</head>
<body>
<div class="background-animation"></div>

<div class="table-container m-6">
  <h2 class="text-3xl font-semibold text-white text-center mb-6 border-b-2 border-purple-600 pb-2 tracking-wide capitalize">
  Available Scholarships
</h2>


  <table>
    <thead>
      <tr>
        <th>Scholarship ID</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Sponsor</th>
        <th>Eligibility CGPA</th>
        <th>Application Deadline</th>
        
      </tr>
    </thead>
    <tbody>
      <?php while ($scholarship = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($scholarship['scholarship_id']) ?></td>
        <td><?= htmlspecialchars($scholarship['name']) ?></td>
        <td><?= number_format($scholarship['amount'], 2) ?></td>
        <td><?= htmlspecialchars($scholarship['sponsor']) ?></td>
        <td><?= htmlspecialchars($scholarship['eligibility_cgpa']) ?></td>
        <td><?= htmlspecialchars($scholarship['application_deadline']) ?></td>
       
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
