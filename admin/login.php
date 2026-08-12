<?php
session_start();
require "../config/database.php";

$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username=trim($_POST['username']);
$password=$_POST['password'];

$stmt=$conn->prepare("SELECT * FROM admins WHERE username=?");
$stmt->bind_param("s",$username);
$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows==1){

$admin=$result->fetch_assoc();

if(password_verify($password,$admin['password'])){

$_SESSION['admin_id']=$admin['id'];
$_SESSION['admin_name']=$admin['username'];

header("Location: dashboard.php");
exit();

}else{

$error="Wrong Password";

}

}else{

$error="Admin not found";

}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="box">

<h2>Admin Login</h2>

<?php
if($error!=""){
echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Admin Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button>

Login

</button>

</form>

</div>

</body>

</html>