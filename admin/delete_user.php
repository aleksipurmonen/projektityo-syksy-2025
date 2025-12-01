<?php
require_once '../backend/db.php';
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        
        // Varmistetaan, ettei admin voi poistaa itseään
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
?>