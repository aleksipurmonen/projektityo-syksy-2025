<div class="header">
    <img src="../frontend/assets/images/logo.png" alt="logo" class="logo">
    <?php
    
    //Kirjaudu sisään/ulos painike riippuen siitä, onko käyttäjä kirjautunut vai ei
    session_start();
    if(!isset($_SESSION["userid"])){
        echo '<a href="login.php" class="header-btn">Kirjaudu sisään</a>';
    }else{
        echo '<p style="margin:0px;padding:10px">Kirjautunut '.$_SESSION["name"].' <a href="logout.php" class="header-btn">Kirjaudu ulos</a></p>';
    }
    ?>
</div>