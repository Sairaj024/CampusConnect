<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$sql = "
SELECT
students.full_name,
students.email,
companies.company_name,
companies.role,
applications.applied_at
FROM applications
INNER JOIN students
ON applications.student_id = students.id
INNER JOIN companies
ON applications.company_id = companies.id
ORDER BY applications.applied_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Applications</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="header">

<h2>CampusConnect Admin</h2>

<div>

Welcome,
<?= $_SESSION['admin_name']; ?>

</div>

</div>

<div class="container">

<h2>Student Applications</h2>

<table>

<tr>

<th>Student</th>
<th>Email</th>
<th>Company</th>
<th>Role</th>
<th>Applied On</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?= htmlspecialchars($row['full_name']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td><?= htmlspecialchars($row['company_name']) ?></td>

<td><?= htmlspecialchars($row['role']) ?></td>

<td><?= htmlspecialchars($row['applied_at']) ?></td>

</tr>

<?php } ?>

</table>

<a class="back" href="dashboard.php">
← Back to Dashboard
</a>

</div>

</body>
</html>