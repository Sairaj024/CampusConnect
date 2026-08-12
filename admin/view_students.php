<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("
SELECT *
FROM students
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Registered Students</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="header">

<h2>CampusConnect Admin</h2>

<div>

Welcome,
<b><?= htmlspecialchars($_SESSION['admin_name']) ?></b>

</div>

</div>

<div class="container">

<h2>Registered Students</h2>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Year</th>

</tr>

<?php while($student=$result->fetch_assoc()){ ?>

<tr>

<td><?= $student['id'] ?></td>

<td><?= htmlspecialchars($student['full_name']) ?></td>

<td><?= htmlspecialchars($student['email']) ?></td>

<td><?= htmlspecialchars($student['department']) ?></td>

<td><?= htmlspecialchars($student['year']) ?></td>

</tr>

<?php } ?>

</table>

<a class="back" href="dashboard.php">
← Back to Dashboard
</a>

</div>

</body>

</html>