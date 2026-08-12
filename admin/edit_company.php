<?php

session_start();
require "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$company_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($company_id === false || $company_id === null || $company_id <= 0) {
    header("Location: manage_companies.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT company_name, role, package, location, eligibility, last_date
    FROM companies
    WHERE id = ?
");

$stmt->bind_param("i", $company_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: manage_companies.php");
    exit();
}

$company = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $company_name = trim($_POST['company']);
    $role = trim($_POST['role']);
    $package = trim($_POST['package']);
    $location = trim($_POST['location']);
    $eligibility = trim($_POST['eligibility']);
    $last_date = $_POST['last_date'];

    if (
        $company_name === "" ||
        $role === "" ||
        $package === "" ||
        $location === "" ||
        $eligibility === "" ||
        $last_date === ""
    ) {
        $message = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare("
            UPDATE companies
            SET company_name = ?,
                role = ?,
                package = ?,
                location = ?,
                eligibility = ?,
                last_date = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            "ssssssi",
            $company_name,
            $role,
            $package,
            $location,
            $eligibility,
            $last_date,
            $company_id
        );

        if ($stmt->execute()) {
            header("Location: manage_companies.php");
            exit();
        }

        $message = "Unable to update company.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Edit Company</title>

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

        <h2>Edit Company</h2>

        <?php if ($message !== "") { ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="POST">

            <input
                type="text"
                name="company"
                placeholder="Company Name"
                value="<?= htmlspecialchars($company['company_name']) ?>"
                required>

            <input
                type="text"
                name="role"
                placeholder="Job Role"
                value="<?= htmlspecialchars($company['role']) ?>"
                required>

            <input
                type="text"
                name="package"
                placeholder="Package"
                value="<?= htmlspecialchars($company['package']) ?>"
                required>

            <input
                type="text"
                name="location"
                placeholder="Location"
                value="<?= htmlspecialchars($company['location']) ?>"
                required>

            <input
                type="text"
                name="eligibility"
                placeholder="Eligibility"
                value="<?= htmlspecialchars($company['eligibility']) ?>"
                required>

            <input
                type="date"
                name="last_date"
                value="<?= htmlspecialchars($company['last_date']) ?>"
                required>

            <button type="submit">
                Update Company
            </button>

        </form>

        <br>

        <a href="manage_companies.php">
            ← Back to Companies
        </a>

    </div>

</div>

</body>

</html>
