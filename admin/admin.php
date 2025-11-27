<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../frontend/login.php');
    exit();
}

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
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Käyttäjähallinta</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nimi</th>
                <th>Sähköposti</th>
                <th>Rooli</th>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>