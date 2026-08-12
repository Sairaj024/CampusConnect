<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['student_id'])){
    header("Location: ../login.php");
    exit();
}

$name=$_SESSION['student_name'];
?>

<!DOCTYPE html>
<html>

<head>

<title>Student Dashboard</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="navbar">

    <div class="logo">
        🎓 CampusConnect
    </div>

    <div class="nav-links">
        <span style="color:white;">
            Welcome,
            <b><?= htmlspecialchars($name) ?></b>
        </span>

        <a href="../logout.php">Logout</a>
    </div>

</div>

<div class="container">

    <div class="card">

        <h2>Student Dashboard</h2>

        <p>
            Manage your campus placements from one place.
            View companies, apply for jobs and track your progress.
        </p>

        <br><br>

        <a href="my_applications.php">
            <button class="btn">
                My Applications
            </button>
        </a>

    </div>

    <div class="card">

        <h2>📢 Latest Announcements</h2>

        <?php
        $announcement_result = $conn->query("
            SELECT title, message, created_at
            FROM announcements
            ORDER BY id DESC
            LIMIT 5
        ");

        if ($announcement_result && $announcement_result->num_rows > 0) {

            while ($announcement = $announcement_result->fetch_assoc()) {
        ?>

            <div style="padding:15px 0; border-bottom:1px solid #eee;">

                <h3>
                    <?= htmlspecialchars($announcement['title']) ?>
                </h3>

                <p>
                    <?= nl2br(htmlspecialchars($announcement['message'])) ?>
                </p>

                <small>
                    <?= htmlspecialchars($announcement['created_at']) ?>
                </small>

            </div>

        <?php
            }

        } else {
        ?>

            <p>No announcements available.</p>

        <?php } ?>

    </div>

    <div class="card">

        <h2>Available Companies</h2>

        <table>

<tr>

    <th>Company</th>

    <th>Role</th>

    <th>Package</th>

    <th>Location</th>

    <th>Eligibility</th>

    <th>Last Date</th>

    <th>Status</th>

</tr>

<?php

$stmt = $conn->prepare("
SELECT
companies.*,
applications.id AS applied
FROM companies
LEFT JOIN applications
ON companies.id = applications.company_id
AND applications.student_id=?
ORDER BY companies.id DESC
");

$stmt->bind_param("i", $_SESSION['student_id']);
$stmt->execute();

$result = $stmt->get_result();

while($company=$result->fetch_assoc()){

?>

<tr>

<td>
<?php echo htmlspecialchars($company['company_name']); ?>
</td>

<td>
<?php echo htmlspecialchars($company['role']); ?>
</td>

<td>
<?php echo htmlspecialchars($company['package']); ?>
</td>

<td>
<?php echo htmlspecialchars($company['location']); ?>
</td>

<td>
<?php echo htmlspecialchars($company['eligibility']); ?>
</td>

<td>
<?php echo htmlspecialchars($company['last_date']); ?>
</td> 

<td>

<?php if($company['applied']){ ?>

<button class="btn" disabled
style="background:green;color:white;padding:8px 16px;border:none;border-radius:5px;">
Applied
</button>

<?php } else { ?>

<form method="POST" action="apply.php">

<input
type="hidden"
name="company_id"
value="<?= $company['id'] ?>">

<button class="btn" type="submit">
Apply
</button>

</form>

<?php } ?>

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