<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM companies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Companies</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">
🎓 CampusConnect Admin
</div>

<div class="nav-links">

<span style="color:white;">
Welcome,
<b><?= htmlspecialchars($_SESSION['admin_name']) ?></b>
</span>

<a href="../logout.php">Logout</a>

</div>

</div>

<div class="container">

<div class="card">

<h2>Manage Companies</h2>

<p>
Edit or delete company recruitment drives.
</p>

</div>

<div class="card">

<table>

<tr>

<th>ID</th>
<th>Company</th>
<th>Role</th>
<th>Package</th>
<th>Location</th>
<th>Eligibility</th>
<th>Last Date</th>
<th>Action</th>

</tr>

<?php while($company = $result->fetch_assoc()){ ?>

<tr>

<td><?= $company['id'] ?></td>

<td><?= htmlspecialchars($company['company_name']) ?></td>

<td><?= htmlspecialchars($company['role']) ?></td>

<td><?= htmlspecialchars($company['package']) ?></td>

<td><?= htmlspecialchars($company['location']) ?></td>

<td><?= htmlspecialchars($company['eligibility']) ?></td>

<td><?= htmlspecialchars($company['last_date']) ?></td>

<td>

<a href="edit_company.php?id=<?= $company['id'] ?>">
<button class="btn">
Edit
</button>
</a>

<form
method="POST"
action="delete_company.php"
style="display:inline;"
onsubmit="return confirm('Delete this company? This will also remove related applications.');">

<input
type="hidden"
name="company_id"
value="<?= $company['id'] ?>">

<button
type="submit"
class="btn"
style="background:#dc2626;">
Delete
</button>

</form>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>