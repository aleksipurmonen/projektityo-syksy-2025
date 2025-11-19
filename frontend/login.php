<?php
    session_start();
include '../backend/db.php'; // Yhteys tietokantaan
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'] ?? '';
    $salasana = $_POST['salasana'] ?? '';

    // Valmistellaan kysely
    $stmt = $conn->prepare("SELECT userid, name, email, passwordhash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $gmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Määritellään muuttujat ennen bind_result-kutsua
$kayttajaID = null;
$nimi = null;
$gmail_db = null;
$hash = null;
$rooli = null;

$stmt->bind_result($kayttajaID, $nimi, $gmail_db, $hash, $rooli);
        $stmt->fetch();

        if (password_verify($salasana, $hash)) {
            // Luodaan uusi sessiotunniste turvallisuussyistä (estää session fixation)
            // ja poistetaan vanha sessiotiedosto.
            session_regenerate_id(true);
            
            // Tallennetaan käyttäjän tiedot sessioon
            $_SESSION['userid'] = $kayttajaID;
            $_SESSION['name'] = $nimi;
            $_SESSION['email'] = $gmail_db;
            $_SESSION['role'] = $rooli; // Tallennetaan rooli sessioon

            // Ohjataan käyttäjä roolin perusteella oikealle sivulle
            if ($rooli === 'admin') {
                header("Location: ../admin/admin.php");
            } else {
                header("Location: weather.php");
            }
            exit;
        } else {
            $error = "❌ Väärä salasana.";  //Jos salasana väärin annetaan virhe.
        }
    } else {
        $error = "❌ Käyttäjätunnusta ei löytynyt."; //Sama juttu jos käyttäjätunnus ei löydy tietokannasta.
    }
    $stmt->close();
}

?>
<!doctype html>
<html>
<head>
<title>Kirjaudu sisään</title>
<link rel="stylesheet" href="logintyyli.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../frontend/assets/css/main.css">
   <?php 
    require_once("../frontend/includes/footer.php");
     ?>
</head>
<body>
<div class="container">
<form action="login.php" method="post">
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success"><?php echo "✅ " . htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
<?php endif; ?>
    <a href="index.php">← Takaisin etusivulle</a>
    <h2>Kirjaudu sisään</h2>
    <br>
    <label>Sähköposti</label>
    <input type="email" name="gmail" id="gmail" placeholder="nimi@example.com" required>
    <br>
    <label>Salasana</label>
    <input type="password" name="salasana" id="salasana" placeholder="salasana" required>
<div class="login-extra">
    <label class="remember-me">
        <input type="checkbox" id="remember_me" name="remember_me">
        Muista minut
    </label>

    <a href="register.php" class="register-link">Rekisteröidy</a>
</div>

<button type="submit">Kirjaudu</button>
</form>
</div>
</body>
</html>