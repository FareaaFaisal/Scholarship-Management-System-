<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "12345";
$db = "sms";

// Create DB connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user info using email
$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br p-8 from-gray-800 via-purple-900 to-black text-white min-h-screen flex flex-col items-center justify-center px-4">

  <div class="bg-gray-900 bg-opacity-70 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-3xl">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-400">Welcome, <?= htmlspecialchars($userData['name']) ?> 🎓</h1>

   <!-- Student Information Display -->
<div class="bg-gray-900 text-white rounded-lg p-6 shadow-md w-full max-w-4xl mx-auto mt-10">
  <h2 class="text-2xl font-bold mb-4">🎓 Student Dashboard</h2>
  <p><strong>Name:</strong> <?= htmlspecialchars($userData['name']) ?></p>
  <p><strong>Student ID:</strong> <?= htmlspecialchars($userData['student_id']) ?></p>
  <p><strong>Department:</strong> <?= htmlspecialchars($userData['department']) ?></p>
  <p><strong>Semester:</strong> <?= htmlspecialchars($userData['semester']) ?></p>
  <p><strong>CGPA:</strong> <?= htmlspecialchars($userData['cgpa']) ?></p>
</div>

<!-- Dashboard Cards Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 max-w-4xl mx-auto px-4">
  
  <!-- Card 1 -->
  <a href="apply.php" class="group bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4">
      <div class="bg-white text-blue-800 p-3 rounded-full shadow-md">
        📄
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1">Apply for Scholarship</h3>
        <p class="text-sm opacity-90">Submit new scholarship applications easily.</p>
      </div>
    </div>
  </a>

  <!-- Card 2 -->
  <a href="applied_scholarships.php" class="group bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4">
      <div class="bg-white text-purple-800 p-3 rounded-full shadow-md">
        📑
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1">Applied Scholarships</h3>
        <p class="text-sm opacity-90">Review your application history.</p>
      </div>
    </div>
  </a>

  <!-- Card 3 -->
  <!-- <a href="application_status.php" class="group bg-gradient-to-r from-green-600 to-green-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4">
      <div class="bg-white text-green-800 p-3 rounded-full shadow-md">
        📊
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1">Application Status</h3>
        <p class="text-sm opacity-90">Track selection and approval progress.</p>
      </div>
    </div>
  </a> -->

  <!-- Card 4 -->
  <a href="available_scholarships.php" class="group bg-gradient-to-r from-yellow-600 to-yellow-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4">
      <div class="bg-white text-yellow-800 p-3 rounded-full shadow-md">
        🎓
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1">Available Scholarships</h3>
        <p class="text-sm opacity-90">Explore open opportunities you can apply for.</p>
      </div>
    </div>
  </a>

  <!-- Card 5 -->
  <a href="update_profile.php" class="group bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4">
      <div class="bg-white text-indigo-800 p-3 rounded-full shadow-md">
        ⚙️
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1">Update Profile</h3>
        <p class="text-sm opacity-90">Modify your account and academic info.</p>
      </div>
    </div>
  </a>

  <!-- Card 6 -->
  <a href="logout.php" class="group bg-gradient-to-r from-red-600 to-red-800 text-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center space-x-4 justify-center">
      <div class="bg-white text-red-800 p-3 rounded-full shadow-md">
        🔓
      </div>
      <div>
        <h3 class="text-xl font-bold mb-1 items-center">Logout</h3>
      </div>
    </div>
  </a>

</div>



  </div>

</body>
</html>
