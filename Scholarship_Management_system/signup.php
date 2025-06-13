<?php
// Connection settings
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

// Initialize error message variable
$error_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $cgpa = $_POST['cgpa'];

    // Simple validation for password match
    if ($password !== $confirm_password) {
        $error_message = "❌ Passwords do not match.";
    } else {
        // Check if the email already exists in the database
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        // If the email already exists, show a warning message
        if ($result->num_rows > 0) {
            $error_message = "❌ This email is already in use. Please use a different email.";
        } else {
            // Insert the user into the database
            $sql = "INSERT INTO users (email, password, name, student_id, department, semester, cgpa) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssd", $email ,$password, $name, $student_id, $department, $semester, $cgpa); // No password hashing for now

            if ($stmt->execute()) {
                // Redirect to login page after successful signup
                header("Location: login.php");
                exit;
            } else {
                $error_message = "❌ Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up Page</title>
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
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
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
      max-width: 400px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
    }

    h2 {
      font-size: 2.5rem;
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 2px solid #ddd;
      margin-bottom: 20px;
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
      letter-spacing: 1px;
    }

    button:hover {
      background-color: rgb(85, 94, 221);
      box-shadow: 0 0 15px rgb(7, 26, 92), 0 0 30px rgb(67, 40, 129);
    }

    .signup-link {
      text-align: center;
      margin-top: 20px;
    }

    .signup-link a {
      color:rgb(85, 94, 221);
      font-size: 1rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .signup-link a:hover {
      color:rgb(238, 226, 118);
    }
  </style>
</head>
<body>

  <div class="background-animation"></div>

  <div class="form-container m-4">
    <h2 class="hover:text-[#eee276] font-semibold">Sign Up</h2>

    <?php if (isset($error_message) && !empty($error_message)): ?>
      <p class="text-red-600 text-center font-semibold mb-4"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="space-y-4">

  <!-- Email -->
  <div>
    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
    <input type="email" name="email" id="email" required class="mt-1 p-1.5 bg-white hover:text-black" />
  </div>

  <!-- Password -->
  <div>
    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
    <input type="password" name="password" id="password" required class="mt-1 p-1.5 bg-white hover:text-black" />
  </div>

  <!-- Confirm Password -->
  <div>
    <label for="confirm_password" class="block text-sm font-medium text-gray-300">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" required class="mt-1 p-1.5 bg-white hover:text-black" />
  </div>

  <!-- Name and Student ID side by side -->
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Student Name</label>
      <input type="text" name="name" id="name" required class="mt-1 p-1.5 bg-white hover:text-black" />
    </div>
    <div>
      <label for="student_id" class="block text-sm font-medium text-gray-300">Student ID</label>
      <input type="text" name="student_id" id="student_id" required class="mt-1 p-1.5 bg-white hover:text-black" />
    </div>
  </div>

  <!-- Department, Semester, CGPA side by side -->
  <div class="grid grid-cols-3 gap-4">
    <div>
      <label for="department" class="block text-sm font-medium text-gray-300">Department</label>
      <input type="text" name="department" id="department" required class="mt-1 p-1.5 bg-white hover:text-black" />
    </div>
    <div>
      <label for="semester" class="block text-sm font-medium text-gray-300">Semester</label>
      <input type="text" name="semester" id="semester" required class="mt-1 p-1.5 bg-white hover:text-black" />
    </div>
    <div>
      <label for="cgpa" class="block text-sm font-medium text-gray-300">CGPA</label>
      <input type="number" min="0" max="4.00" step="0.1" name="cgpa" id="cgpa" required class="mt-1 p-1.5 bg-white hover:text-black" />
    </div>
  </div>

  <!-- Submit Button -->
  <button type="submit" class="bg-white font-semibold p-1.5">Sign Up</button>
</form>


    <div class="signup-link">
      <a href="login.php">Already have an account? Log in here</a>
    </div>
  </div>

</body>
</html>
