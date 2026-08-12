<?php
session_start();
require 'config/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $student = $result->fetch_assoc();

        if (password_verify($password, $student['password'])) {

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];

            header("Location: student/dashboard.php");
            exit();

        } else {
            $error = "Invalid Password";
        }

    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Login</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="box">

<h2>Student Login</h2>

<?php
if($error!=""){
echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">
Login
</button>

</form>

<br>

<center>

<a href="register.php">
Create New Account
</a>

</center>

</div>

</body>

</html>