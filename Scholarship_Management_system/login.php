<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the DB for user credentials
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit;
    } else {
        // Redirect back to the login page with an error message
        $error_message = "❌ Incorrect login credentials. Please try again.";
    }
}
?>

<!-- Login Form (Displaying the Error Message) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(135deg, #1e1e1e, #4b4b4b);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      padding: 0;
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
      background: white;
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
      background-color: white;
    }

    button:hover {
      background-color: rgb(85, 94, 221);
      box-shadow: 0 0 15px rgb(7, 26, 92), 0 0 30px rgb(67, 40, 129);
      color: white;
    }

    .signup-link {
      text-align: center;
      margin-top: 20px;
    }

    .signup-link a {
      color: rgb(85, 94, 221);
      font-size: 1rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .signup-link a:hover {
      color: rgb(238, 226, 118);
    }
  </style>
</head>
<body>

  <!-- <div class="background-animation"></div> -->

  <div class="form-container">
    <h2 class="hover:text-[#eee276] font-semibold">Login</h2>

    <?php if (!empty($error_message)): ?>
      <div class="text-red-500 text-center font-semibold mb-4"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          class="mt-1 p-1.5 hover:bg-white hover:text-black"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          required
          class="mt-1 p-1.5 hover:bg-white hover:text-black"
        />
      </div>

      <button type="submit" class="font-semibold p-1.5 bg-white">Login</button>
    </form>

    <div class="signup-link">
       <a href="signup.php">Don&apos;t have an account? Sign up here</a>
    </div>
  </div>

</body>
</html>

