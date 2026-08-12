<?php

session_start();
require "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);

if ($company_id === false || $company_id === null || $company_id <= 0) {
    header("Location: manage_companies.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM companies WHERE id = ?");
$stmt->bind_param("i", $company_id);

$stmt->execute();

$stmt->close();

header("Location: manage_companies.php");
exit();

?>
