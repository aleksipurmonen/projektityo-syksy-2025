    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../frontend/assets/css/main.css">
    <link rel="shortcut icon" href="../frontend/assets/images/logo_vanha.png" type="image/x-icon">
    <?php 
    
    require_once("../frontend/includes/header.php");
    require_once("../frontend/includes/footer.php");
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
     ?>