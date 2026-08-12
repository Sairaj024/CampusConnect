<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$name = $_SESSION['admin_name'];

$students = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$companies = $conn->query("SELECT COUNT(*) AS total FROM companies")->fetch_assoc()['total'];
$applications = $conn->query("SELECT COUNT(*) AS total FROM applications")->fetch_assoc()['total'];

$announcements = $conn->query(
    "SELECT COUNT(*) AS total FROM announcements"
)->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Admin Dashboard</title>

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
            <b><?= htmlspecialchars($name) ?></b>
        </span>

        <a href="../logout.php">
            Logout
        </a>

    </div>

</div>

<div class="container">

<div class="card">

<h2>Admin Dashboard</h2>

<p>
Manage students, companies and placement activities from one place.
</p>

</div>

<div class="stats">

<div class="stat-card">

<h1><?= $students ?></h1>

<p>Total Students</p>

</div>

<div class="stat-card">

<h1><?= $companies ?></h1>

<p>Total Companies</p>

</div>

<div class="stat-card">

<h1><?= $applications ?></h1>

<p>Total Applications</p>

</div>

<div class="stat-card">

<h1><?= $announcements ?></h1>

<p>Announcements</p>

</div>

</div>

<div class="card">

<h2>Quick Actions</h2>

<br>

<a href="add_company.php">
<button class="btn">
➕ Add Company
</button>
</a>

<a href="manage_companies.php">
<button class="btn">
🏢 Manage Companies
</button>
</a>

<a href="view_students.php">
<button class="btn">
👨‍🎓 View Students
</button>
</a>

<a href="view_applications.php">
<button class="btn">
📄 View Applications
</button>
</a>

<a href="announcements.php">
<button class="btn">
📢 Announcements
</button>
</a>

</div>

</div>

</body>

</html>