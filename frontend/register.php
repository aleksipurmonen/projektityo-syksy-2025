<?php
    session_start();
include '../backend/db.php'; // Yhteys tietokantaan
$error = "";

// Käsitellään lomakkeen lähetys
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = trim($_POST['nimi'] ?? '');
    $gmail = trim($_POST['gmail'] ?? '');
    $salasana = $_POST['salasana'] ?? '';

    $virheet = [];

    if (empty($nimi) || empty($gmail) || empty($salasana)) {
        $virheet[] = "Kaikki kentät ovat pakollisia.";
    }

    if (!empty($gmail) && !filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        $virheet[] = "Sähköposti ei ole kelvollinen.";
    }

    if (empty($virheet)) {
        $stmt_check = $conn->prepare("SELECT userid FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $gmail);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $virheet[] = "Sähköposti on jo käytössä. Valitse toinen.";
        }
        $stmt_check->close();
    }

    if (empty($virheet)) {
        $hash = password_hash($salasana, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, passwordhash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nimi, $gmail, $hash);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Rekisteröinti onnistui! Voit nyt kirjautua sisään.";
            header("Location: login.php");
            exit;
        } else {
            $virheet[] = "Rekisteröinti epäonnistui. Yritä uudelleen.";
        }
    }
}

?>
<!doctype html>
<html>
<head>
<title>login</title>
<link rel="stylesheet" href="logintyyli.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../frontend/assets/css/main.css">
</head>
<body>
<div class="container">
<form action="register.php" method="post">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo "✅ " . htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <h3>Rekisteröityminen</h3>
    <br>
    <label>Nimi</label>
    <input type="text" name="nimi" id="nimi" placeholder="Etunimi Sukunimi" required>
    <br>
    <label>Sähköposti</label>
    <input type="email" name="gmail" id="gmail" placeholder="nimi@example.com" required>
    <br>
    <label>Salasana</label>
    <input type="password" name="salasana" id="salasana" placeholder="salasana" required>
<div class="login-container">
    <a href="login.php" class="login-link">Kirjautumaan</a>
</div>
<br>
    <button type="submit">Rekisteröidy</button>
</form>
</div>
</body>
</html>