<?php
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../frontend/logout.php");
    exit;
}

$user_id = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

if (!$user_id) {
    $_SESSION['error_message'] = "Virheellinen käyttäjä.";
    header("Location: admin.php");
    exit;
}

// Haetaan käyttäjän tiedot
$stmt = $conn->prepare("SELECT userid, name, email, role FROM users WHERE userid = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $_SESSION['error_message'] = "Käyttäjää ei löytynyt.";
    header("Location: admin.php");
    exit;
}

// Jos lomake lähetetään
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = trim($_POST['name']);
    $gmail = trim($_POST['email']);
    $rooli = $_POST['role'];
    $salasana = $_POST['passwordhash'];

    if (!in_array($rooli, ['user', 'admin'])) {
        $_SESSION['error_message'] = "Virheellinen rooli.";
        header("Location: edit_user.php?userid=" . $user_id);
        exit;
    }

    if (!empty($salasana)) {
        $hash = password_hash($salasana, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, passwordhash = ? WHERE userid = ?");
        $stmt->bind_param("ssssi", $nimi, $gmail, $rooli, $hash, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE userid = ?");
        $stmt->bind_param("sssi", $nimi, $gmail, $rooli, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Käyttäjän tiedot päivitetty onnistuneesti.";
    } else {
        $_SESSION['error_message'] = "Tietojen päivitys epäonnistui.";
    }
    $stmt->close();

    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa käyttäjää</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Muokkaa käyttäjää</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nimi</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Sähköposti</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rooli</label>
            <select class="form-select" id="role" name="role">
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Käyttäjä</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="passwordhash" class="form-label">Uusi salasana (jätä tyhjäksi jos ei muuteta)</label>
            <input type="password" class="form-control" id="passwordhash" name="passwordhash">
        </div>
        <button type="submit" class="btn btn-primary">Tallenna muutokset</button>
        <a href="admin.php" class="btn btn-secondary">Peruuta</a>
    </form>
</div>
</body>
</html>
