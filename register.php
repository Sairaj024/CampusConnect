<?php
require 'config/database.php';

$message = "";

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $department = $_POST['department'];
    $year = $_POST['year'];

    $check = $conn->prepare("SELECT id FROM students WHERE email=?");
    $check->bind_param("s",$email);
    $check->execute();
    $check->store_result();

    if($check->num_rows>0){

        $message="Email already exists.";

    }else{

        $stmt=$conn->prepare("INSERT INTO students(full_name,email,password,department,year)
        VALUES(?,?,?,?,?)");

        $stmt->bind_param("sssss",$name,$email,$password,$department,$year);

        if($stmt->execute()){

            header("Location: login.php");
            exit;

        }else{

            $message="Registration Failed.";

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Student Registration</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="box">

<h2>Student Registration</h2>

<div class="msg"><?php echo $message; ?></div>

<form method="POST">

<input
type="text"
name="name"
placeholder="Full Name"
required>

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

<select name="department">

<option>CSE</option>
<option>IT</option>
<option>AIML</option>
<option>ENTC</option>
<option>Mechanical</option>

</select>

<select name="year">

<option>First Year</option>
<option>Second Year</option>
<option>Third Year</option>
<option>Final Year</option>

</select>

<button name="register">

Register

</button>

</form>

<br>

<center>

<a href="login.php">

Already have an account?

</a>

</center>

</div>

</body>

</html>