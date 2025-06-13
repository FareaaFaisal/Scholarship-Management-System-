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

$email = $_SESSION['email'];
$error_message = "";
$success_message = "";

// Fetch current user data
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture updated form data
    $new_email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $cgpa = $_POST['cgpa'];

    if ($password !== $confirm_password) {
        $error_message = "❌ Passwords do not match.";
    } else {
        // Update user data
        $sql = "UPDATE users SET email=?, password=?, name=?, student_id=?, department=?, semester=?, cgpa=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $new_email, $password, $name, $student_id, $department, $semester, $cgpa, $email);

        if ($stmt->execute()) {
            // Update session email if it changes
            if ($new_email !== $email) {
                $_SESSION['email'] = $new_email;
            }
            $success_message = "✅ Profile updated successfully!";
        } else {
            $error_message = "❌ Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(135deg, #1e1e1e, #4b4b4b);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      overflow: hidden;
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

    .form-container {
      background: rgba(0, 0, 0, 0.6);
      border-radius: 10px;
      padding: 40px;
      width: 100%;
      max-width: 500px;
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

    input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 2px solid #ddd;
      background: transparent;
      color: #fff;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #5b21b6;
      box-shadow: 0 0 5px #5b21b6;
    }

    button {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: none;
      font-size: 1.2rem;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      background-color: rgb(85, 94, 221);
      box-shadow: 0 0 15px rgb(7, 26, 92), 0 0 30px rgb(67, 40, 129);
    }
  </style>
</head>
<body>
<div class="background-animation"></div>

<div class="form-container m-4">
  <h2 class="hover:text-[#eee276]">Update Profile</h2>

  <?php if (!empty($error_message)): ?>
    <p class="text-red-500 font-semibold text-center"><?= htmlspecialchars($error_message) ?></p>
  <?php elseif (!empty($success_message)): ?>
    <p class="text-green-400 font-semibold text-center"><?= htmlspecialchars($success_message) ?></p>
  <?php endif; ?>

  <form action="" method="POST" class="space-y-4">
    <div>
      <label for="email" class="text-white">Email</label>
      <input type="email" name="email" id="email" value="<?= htmlspecialchars($userData['email']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
    </div>

    <div>
      <label for="password" class="text-white">Password</label>
      <input type="password" name="password" id="password" value="<?= htmlspecialchars($userData['password']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
    </div>

    <div>
      <label for="confirm_password" class="text-white">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password" value="<?= htmlspecialchars($userData['password']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="name" class="text-white">Name</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($userData['name']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
      </div>
      <div>
        <label for="student_id" class="text-white">Student ID</label>
        <input type="text" name="student_id" id="student_id" value="<?= htmlspecialchars($userData['student_id']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
      </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
      <div>
        <label for="department" class="text-white">Department</label>
        <input type="text" name="department" id="department" value="<?= htmlspecialchars($userData['department']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
      </div>
      <div>
        <label for="semester" class="text-white">Semester</label>
        <input type="text" name="semester" id="semester" value="<?= htmlspecialchars($userData['semester']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
      </div>
      <div>
        <label for="cgpa" class="text-white">CGPA</label>
        <input type="number" step="0.01" min="0" max="4.0" name="cgpa" id="cgpa" value="<?= htmlspecialchars($userData['cgpa']) ?>" required class="mt-1 p-1.5 bg-white text-black" />
      </div>
    </div>

    <button type="submit" class="bg-white mt-4 p-1.5 font-semibold">Update Profile</button>
  </form>
</div>
</body>
</html>
