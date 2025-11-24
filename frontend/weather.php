<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once("includes/htmlhead.php"); //sisältää footer, header, css, bootstrap
    ?>
    <title>Document</title>
</head>
<body>
    <div class="container2">
        <h4>Sään seuranta</h4>
        
        
    </div>
</body>
</html>

<?php
if(!isset($_SESSION["userid"])){
    header("Location: logout.php");
    exit;
}
?>
<body>
    
</body>
</html>
