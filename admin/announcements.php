<?php

session_start();
require "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title'] ?? '');
    $announcement = trim($_POST['message'] ?? '');

    if ($title === "" || $announcement === "") {

        $message = "Please fill in all fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO announcements (title, message) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $title, $announcement);

        if ($stmt->execute()) {
            header("Location: announcements.php");
            exit();
        }

        $message = "Unable to create announcement.";

        $stmt->close();
    }
}

$result = $conn->query(
    "SELECT id, title, message, created_at
     FROM announcements
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Announcements</title>

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

        <h2>Announcements</h2>

        <p>Create and manage placement announcements.</p>

        <?php if ($message !== "") { ?>

            <p class="error">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php } ?>

        <form method="POST">

            <input
                type="text"
                name="title"
                placeholder="Announcement Title"
                required>

            <textarea
                name="message"
                placeholder="Announcement Message"
                rows="5"
                required></textarea>

            <button type="submit" class="btn">
                Create Announcement
            </button>

        </form>

    </div>

    <div class="card">

        <h2>Existing Announcements</h2>

        <table>

            <tr>

                <th>Title</th>
                <th>Message</th>
                <th>Created</th>
                <th>Action</th>

            </tr>

            <?php while ($announcement = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($announcement['title']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($announcement['message']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($announcement['created_at']) ?>
                    </td>

                    <td>

                        <form
                            method="POST"
                            action="delete_announcement.php"
                            style="display:inline;"
                            onsubmit="return confirm('Delete this announcement?');">

                            <input
                                type="hidden"
                                name="announcement_id"
                                value="<?= $announcement['id'] ?>">

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
