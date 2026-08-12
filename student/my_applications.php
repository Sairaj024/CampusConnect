<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['student_id'])){
    header("Location: ../login.php");
    exit();
}

$name=$_SESSION['student_name'];

$sql="
SELECT
companies.company_name,
companies.role,
companies.package,
companies.location,
applications.applied_at
FROM applications
JOIN companies
ON applications.company_id=companies.id
WHERE applications.student_id=?
ORDER BY applications.applied_at DESC
";

$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$_SESSION['student_id']);
$stmt->execute();

$result=$stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<title>My Applications</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">
🎓 CampusConnect
</div>

<div class="nav-links">

<span>
Welcome,
<b><?= htmlspecialchars($name) ?></b>
</span>

<a href="../logout.php">
Logout
</a>

</div>

</div>

<div class="container">

<div class="card">

<h2>My Applications</h2>

<p>
These are all the companies you have applied to.
</p>

</div>

<div class="card">

<table>

<tr>

<th>Company</th>

<th>Role</th>

<th>Package</th>

<th>Location</th>

<th>Applied On</th>

<th>Status</th>

</tr>

<?php

while($row=$result->fetch_assoc()){

?>

<tr>

<td><?= htmlspecialchars($row['company_name']) ?></td>

<td><?= htmlspecialchars($row['role']) ?></td>

<td><?= htmlspecialchars($row['package']) ?></td>

<td><?= htmlspecialchars($row['location']) ?></td>

<td><?= htmlspecialchars($row['applied_at']) ?></td>

<td>

<span
style="
background:#16a34a;
color:white;
padding:6px 14px;
border-radius:20px;
font-size:14px;
">
Applied
</span>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</body>

</html>