<div class="header">
    <img src="../frontend/assets/images/logo_vanha.png" alt="logo" class="logo">
    <?php
    
    //Kirjaudu sisään/ulos painike riippuen siitä, onko käyttäjä kirjautunut vai ei
    session_start();
    if(!isset($_SESSION["userid"])){
        echo '<a href="login.php" class="header-btn">Kirjaudu sisään</a>';
    }else{
        echo '<div style="display: flex; justify-content: space-between;"><p style="margin:0px;padding:10px" class="header-username">Kirjautunut '.$_SESSION["name"].'</p><a href="logout.php" class="header-btn">Kirjaudu ulos</a></div>';
    }
    ?>
</div>