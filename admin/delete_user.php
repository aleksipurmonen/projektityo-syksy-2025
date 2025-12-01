<?php
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../frontend/logout.php");
    exit;
}

$user_id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

if ($user_id && $user_id != $_SESSION['userid']) {
    $stmt = $conn->prepare("DELETE FROM users WHERE userid = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Käyttäjä poistettu onnistuneesti.";
    } else {
        $_SESSION['error_message'] = "Käyttäjän poistaminen epäonnistui.";
    }
    $stmt->close();
} else {
    $_SESSION['error_message'] = "Et voi poistaa omaa käyttäjätiliäsi.";
}

header("Location: admin.php");
exit;
