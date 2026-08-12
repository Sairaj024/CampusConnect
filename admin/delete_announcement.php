<?php

session_start();
require "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$announcement_id = filter_input(
    INPUT_POST,
    'announcement_id',
    FILTER_VALIDATE_INT
);

if (
    $announcement_id === false ||
    $announcement_id === null ||
    $announcement_id <= 0
) {
    header("Location: announcements.php");
    exit();
}

$stmt = $conn->prepare(
    "DELETE FROM announcements WHERE id = ?"
);

$stmt->bind_param("i", $announcement_id);

$stmt->execute();

$stmt->close();

header("Location: announcements.php");
exit();

?>
