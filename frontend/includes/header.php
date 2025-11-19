<div class="header">
    <img src="../frontend/assets/images/logo.png" alt="logo" class="logo">
    <?php
    session_start();
    
    if(!isset($_SESSION["userid"])){
        echo '<a href="login.php" class="header-btn">Kirjaudu sisään</a>';
    }else{
        echo '<p>Kirjautunut '.$_SESSION["name"].' <a href="logout.php" class="header-btn">Kirjaudu ulos</a></p>';
    }
    ?>
</div>