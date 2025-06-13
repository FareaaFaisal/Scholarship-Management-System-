<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "sms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$scholarship_id = 3;

$sql = "SELECT name, eligibility_cgpa FROM scholarships WHERE scholarship_id = $scholarship_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Scholarship not found.");
}

$scholarship = $result->fetch_assoc();
$sch_name = $scholarship['name'];
$min_cgpa = $scholarship['eligibility_cgpa'];

$sql_users = "SELECT email, name, cgpa FROM users WHERE cgpa >= $min_cgpa";
$users_result = $conn->query($sql_users);

if ($users_result->num_rows == 0) {
    echo "No eligible students found for the scholarship '$sch_name'.";
    exit;
}

echo "<h3>Sending emails for scholarship: $sch_name (Minimum CGPA: $min_cgpa)</h3>";

while ($user = $users_result->fetch_assoc()) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sugasbias9@gmail.com'; // your Gmail
        $mail->Password   = 'cqfz fctl vflk dfda';    // use app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('sugasbias9@gmail.com', 'Scholarship Office');
        $mail->addAddress($user['email'], $user['name']);

        $mail->isHTML(true);
        $mail->Subject = "New Scholarship Available: $sch_name";
        $mail->Body    = "Dear {$user['name']},<br><br>Congratulations! You are eligible for the '<strong>$sch_name</strong>' scholarship.<br>Please check your student portal for more information.<br><br>Best regards,<br>University Scholarship Office";

        $mail->send();
        echo "✅ Email sent to {$user['email']} (CGPA: {$user['cgpa']})<br>";
    } catch (Exception $e) {
        echo "❌ Failed to send email to {$user['email']}. Error: {$mail->ErrorInfo}<br>";
    }
}

$conn->close();
?>
