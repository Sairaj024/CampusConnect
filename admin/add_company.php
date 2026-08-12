<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$company=trim($_POST['company']);
$role=trim($_POST['role']);
$package=trim($_POST['package']);
$location=trim($_POST['location']);
$eligibility=trim($_POST['eligibility']);
$last_date=$_POST['last_date'];

$stmt=$conn->prepare("
INSERT INTO companies
(company_name,role,package,location,eligibility,last_date)
VALUES(?,?,?,?,?,?)
");

$stmt->bind_param(
"ssssss",
$company,
$role,
$package,
$location,
$eligibility,
$last_date
);

if($stmt->execute()){
$message="Company Added Successfully";
}else{
$message="Something went wrong";
}

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Company</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="box">

<h2>Add Company</h2>

<?php
if($message!=""){
echo "<p class='success'>$message</p>";
}
?>

<form method="POST">

<input type="text" name="company" placeholder="Company Name" required>

<input type="text" name="role" placeholder="Job Role" required>

<input type="text" name="package" placeholder="Package (Eg. 8 LPA)" required>

<input type="text" name="location" placeholder="Location" required>

<input type="text" name="eligibility" placeholder="Eligibility (Eg. 7 CGPA)" required>

<input type="date" name="last_date" required>


<button type="submit">
Add Company
</button>

</form>

<br>

<a href="dashboard.php">
← Back to Dashboard
</a>

</div>

</body>
</html>
