<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once("includes/htmlhead.php");
    ?>
    <title>Document</title>
    <link rel="stylesheet" href="../frontend/assets/css/main.css">
</head>
<body>
    
</body>
</html>

<?php
if(!isset($_SESSION["userid"])){
    header("Location: logout.php");
    exit;
}
?>