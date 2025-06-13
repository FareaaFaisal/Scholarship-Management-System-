<?php
session_start();
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

// Fetch scholarships for dropdown
$scholarships_result = $conn->query("SELECT scholarship_id, name FROM scholarships");

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize inputs
    $full_name      = $conn->real_escape_string($_POST['full_name']);
    $email          = $conn->real_escape_string($_POST['email']);
    $phone          = $conn->real_escape_string($_POST['phone']);
    $cnic           = $conn->real_escape_string($_POST['cnic']);
    $city           = $conn->real_escape_string($_POST['city']);
    $district       = $conn->real_escape_string($_POST['district']);
    $country        = $conn->real_escape_string($_POST['country']);
    $department     = $conn->real_escape_string($_POST['department']);
    $degree_program = $conn->real_escape_string($_POST['degree_program']);
    $year_of_study  = (int)$_POST['year_of_study'];
    $cgpa           = (float)$_POST['cgpa'];
    $income         = (int)$_POST['income'];
    $selection_type = $conn->real_escape_string($_POST['selection_type']);
    $scholarship_id = (int)$_POST['scholarship_id'];

    // insert
    $sql = "INSERT INTO applications (
                full_name, email, phone, cnic, city, district, country,
                department, degree_program, year_of_study, cgpa, income,
                selection_type, scholarship_id, submission_date
            ) VALUES (
                '$full_name', '$email', '$phone', '$cnic', '$city', '$district', '$country',
                '$department', '$degree_program', $year_of_study, $cgpa, $income,
                '$selection_type', $scholarship_id, NOW()
            )";

    if ($conn->query($sql) === TRUE) {
        $message = "Applied successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Apply for Scholarship</title>
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
      top:0; left:0; right:0; bottom:0;
      background: url('https://www.transparenttextures.com/patterns/diamond-pattern.png');
      background-size:100px 100px;
      animation: moveBackground 10s linear infinite;
      z-index:-1;
    }
    @keyframes moveBackground {
      0% { background-position:0 0; }
      100% { background-position:100px 100px; }
    }
    .form-container {
      background: rgba(0,0,0,0.6);
      border-radius:10px;
      padding:40px;
      width:100%;
      max-width:750px;
      box-shadow:0 0 20px rgba(0,0,0,0.4);
      backdrop-filter: blur(10px);
    }
    h2 {
      font-size:2rem;
      color:#fff;
      text-align:center;
      margin-bottom:30px;
      font-weight:600;
      letter-spacing:1px;
    }
    input, select {
      width:100%;
      padding:20px;
      border-radius:8px;
      border:2px solid #ddd;
      margin-bottom:16px;
      background:transparent;
      color:#fff;
      font-size:1rem;
    }
    input:focus, select:focus {
      outline:none;
      border-color:#5b21b6;
      box-shadow:0 0 5px #5b21b6;
    }
    button {
      width:100%;
      padding:12px;
      border-radius:8px;
      border:none;
      font-size:1.2rem;
      font-weight:bold;
      cursor:pointer;
      background-color:white;
      transition:all 0.3s ease;
    }
    button:hover {
      background-color:rgb(85,94,221);
      box-shadow:0 0 15px rgb(7,26,92),0 0 30px rgb(67,40,129);
      color:white;
    }
    .message {
      text-align: center;
      margin-bottom: 20px;
      color: #a3eb7b; /* light green */
      font-weight: bold;
    }
    .message.error {
      color: #f87171; /* light red */
    }
  </style>
</head>
<body>
  <div class="background-animation"></div>
  <div class="form-container m-4">
    <?php if($message): ?>
      <div class="message <?php echo strpos($message,'Error:')===0?'error':''; ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

     <h2 class="text-3xl font-semibold text-white text-center mb-6 border-b-2 border-purple-600 pb-2 tracking-wide capitalize">
   Application Form
    </h2>
    <form method="POST" action="">
      <label class="text-sm font-medium text-gray-300">Full Name</label>
      <input type="text" name="full_name" required class="bg-white hover:text-black" />

      <label class="text-sm font-medium text-gray-300">Email</label>
      <input type="email" name="email" required class="bg-white hover:text-black" />

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-medium text-gray-300">Phone Number</label>
          <input type="text" name="phone" required class="bg-white hover:text-black" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-300">CNIC</label>
          <input type="text" name="cnic" required class="bg-white hover:text-black" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-medium text-gray-300">City</label>
          <input type="text" name="city" required class="bg-white hover:text-black" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-300">District</label>
          <input type="text" name="district" required class="bg-white hover:text-black" />
        </div>
      </div>

      <label class="text-sm font-medium text-gray-300">Country</label>
      <input type="text" name="country" required class="bg-white hover:text-black" />

      <label class="text-sm font-medium text-gray-300">Department</label>
      <input type="text" name="department" required class="bg-white hover:text-black" />

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-medium text-gray-300">Degree Program</label>
          <input type="text" name="degree_program" required class="bg-white hover:text-black" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-300">Year of Study</label>
          <input type="number" name="year_of_study" required class="bg-white hover:text-black" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-medium text-gray-300">Current CGPA</label>
          <input type="number" step="0.1" min="0" max="4" name="cgpa" required class="bg-white hover:text-black" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-300">Family Income (PKR)</label>
          <input type="number" name="income" required class="bg-white hover:text-black" />
        </div>
      </div>

      <label class="text-sm font-medium text-gray-300">Type of Selection</label>
      <select name="selection_type" required class="bg-white text-black">
        <option value="">-- Select Type --</option>
        <option value="Need-Based">Need-Based</option>
        <option value="Merit-Based">Merit-Based</option>
        <option value="Special Quota">Special Quota</option>
      </select>

      <label class="text-sm font-medium text-gray-300">Select Scholarship</label>
      <select name="scholarship_id" required class="bg-white text-black">
        <option value="">-- Select Scholarship --</option>
        <?php while ($row = $scholarships_result->fetch_assoc()): ?>
          <option value="<?= $row['scholarship_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
      </select>

      <button type="submit" class="mt-4 bg-white p-1.5">Submit Application</button>
    </form>
  </div>
</body>
</html>
