<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['student_id'])){
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);

if ($company_id === false || $company_id === null || $company_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Check if already applied
$stmt = $conn->prepare("SELECT id FROM applications WHERE student_id=? AND company_id=?");
$stmt->bind_param("ii", $student_id, $company_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){

    $stmt = $conn->prepare("
        INSERT INTO applications(student_id, company_id)
        VALUES(?, ?)
    ");

    $stmt->bind_param("ii", $student_id, $company_id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>