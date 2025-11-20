<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once("includes/htmlhead.php"); //sisältää footer, header, css, bootstrap
    ?>
    <title>Document</title>
</head>
<?php
if(!isset($_SESSION["userid"])){
    header("Location: logout.php");
    exit;
}
?>
<body>
    
</body>
</html>
