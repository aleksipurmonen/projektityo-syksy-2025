<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once("includes/htmlhead.php"); //sisältää footer, header, css, bootstrap
    ?>
    <title>Document</title>
</head>
<<<<<<< HEAD
<body>
    <div class="container2">
        <h3>Sään seuranta</h3>
        <p>Tervetuloa sään seurantajärjestelmään!</p>
        
        
    </div>
</body>
</html>

=======
>>>>>>> d6b7a1c3cbbda81662f708cc009fef256f549435
<?php
if(!isset($_SESSION["userid"])){
    header("Location: logout.php");
    exit;
}
?>
<body>
    
</body>
</html>
