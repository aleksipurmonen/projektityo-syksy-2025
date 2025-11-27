<?php
include 'includes/header_admin.php';

//etsitään kaikki käyttäjät tietokannasta
$result = $conn->query("SELECT userid, name, email, role FROM users ORDER BY name ASC");

$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>
