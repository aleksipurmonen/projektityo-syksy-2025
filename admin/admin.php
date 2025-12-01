<?php

require_once '../backend/db.php';
//etsitään kaikki käyttäjät tietokannasta
$result = $conn->query("SELECT userid, name, email, role FROM users ORDER BY name ASC");

$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Käyttäjähallinta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/assets/css/main.css">
    <link rel="shortcut icon" href="../frontend/assets/images/logo_vanha.png" type="image/x-icon">
    <?php 
    require_once("../frontend/includes/footer.php");
     ?>

     <?php 
require_once("../frontend/includes/htmlhead.php");
     ?>
</head>
<body>
<div class="admin-container">
    <h2 >Käyttäjähallinta</h2>
    <table class="table">
        <head class="">
            <tr>
                <th>Nimi</th>
                <th>Sähköposti</th>
                <th>Rooli</th>
                <th>Toiminnot</th>
            </tr>
        </head>
        <body>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['name']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td>
                    <span class="badge <?= $user['role'] === 'admin' ? 'bg-success' : 'bg-secondary'; ?>">
                        <?= htmlspecialchars($user['role']); ?>
                    </span>
                </td>
                <td>
                    <a href="edit_user.php?userid=<?= $user['userid']; ?>" class="btn btn-sm btn-warning">Muokkaa</a>
                    <a href="delete_user.php?userid=<?= $user['userid']; ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Oletko varma, että haluat poistaa tämän käyttäjän?');">Poista</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php
if(!isset($_SESSION["userid"])){
    header("Location: ../frontend/logout.php");
    exit;
}
?>
        </body>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>