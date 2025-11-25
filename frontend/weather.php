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
        
    <div id="clock" aria-live="polite"></div> 
<script>
  function updateClock() {
    const now = new Date();

    // Muotoilu suomen kielellä ja Suomen aikavyöhykkeellä
    const dateStr = new Intl.DateTimeFormat('fi-FI', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      timeZone: 'Europe/Helsinki'
    }).format(now);

    const timeStr = new Intl.DateTimeFormat('fi-FI', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      timeZone: 'Europe/Helsinki',
      hour12: false
    }).format(now);

    const clockEl = document.getElementById('clock');
    clockEl.textContent = `${capitalize(dateStr)} • ${timeStr}`;
  }

  // funkito joka muutta alkukirjaimen isoksi
  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  updateClock();                // ensimmäinen päivitys heti kun sivu avataan
  setInterval(updateClock, 1000); // Päivitetään sekunnin välein
</script>
           <div class="weather">
             
           <h4>Nykyinen sää:</h4>
            <p></p>
            <p></p>
            <p></p>
            

        </div>
        <div class="rivitin">
        <div class="weather-info1">Icon</div>
        <div class="weather-info2">Icon</div> 
        <div class="weather-info3">Icon</div>


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
