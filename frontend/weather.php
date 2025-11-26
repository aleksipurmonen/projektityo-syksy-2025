<!DOCTYPE html>
<html lang="en">
<head>
    <?php
$latitude = 62.8924;
$longitude = 27.6770;
$url = "https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=$latitude&lon=$longitude";
$options = [
    "http" =>[
    "header" => "User-Agent: OmaSovellus/1.0 oma.sahkoposti@example.com\r\n"
    ]
    ];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context); //Säädatan haku met.no API:sta
if($response===FALSE)  {
    die("Säädatan haku epäonnistui."); //Virhe ilmoitus jos säädätan haku epäonnistuu
}
$data = json_decode($response, true);
$aikasarja = array_slice($data['properties']['timeseries'], 0, 12);
function getSuomibig($koodi) { //Sääkoodien muunnos suomeksi ja kuvakkeet
    $taulukko = [
        'clearsky_day' => [ 'assets/icons/Aurinko.png'],
        'clearsky_night' => ['assets/icons/Selkeää yö.png'],
        'partlycloudy_day' => ['assets/icons/Puolipilvinen.png'], 
        'partlycloudy_night' => ['assets/icons/pilvinen yö.png'] ,
        'cloudy' => [' assets/icons/pilvinen.png'],
        'rain' => ['assets/icons/sateinen.png'],
        'lightrain' => ['assets/icons/tihkusade.png'],
        'heavyrain' => ['assets/icons/sateinen.png'],
        'snow' => ['assets/icons/lumisade.png'],
        'lightsnow' => ['assets/icons/pakkanen.png'],
        'heavysnow' => ['assets/icons/lumisade.png'],
        'fog' => ['assets/icons/sumu.png'],
        'fair_day' => ['assets/icons/Aurinko.png']
    ];

    if (isset($taulukko[$koodi])) {
        [$kuvalinkki] = $taulukko[$koodi]; // Purkaa taulukon saadakseen kuvalinkin
return $kuvalinkki
    ? ' <img src="' . $kuvalinkki . '" alt="" class="weather-icon2">' // Palauttaa kuvalinkin HTML-kuvana
    : $kuvalinkki;
    }

    return $koodi; 
}
function getSuomismall($koodi) { //Sääkoodien muunnos suomeksi ja kuvakkeet
    $taulukko = [
        'clearsky_day' => [ 'assets/icons/Aurinko.png'],
        'clearsky_night' => ['assets/icons/Selkeää yö.png'],
        'partlycloudy_day' => ['assets/icons/Puolipilvinen.png'], 
        'partlycloudy_night' => ['assets/icons/pilvinen yö.png'] ,
        'cloudy' => [' assets/icons/pilvinen.png'],
        'rain' => ['assets/icons/sateinen.png'],
        'lightrain' => ['assets/icons/tihkusade.png'],
        'heavyrain' => ['assets/icons/sateinen.png'],
        'snow' => ['assets/icons/lumisade.png'],
        'lightsnow' => ['assets/icons/pakkanen.png'],
        'heavysnow' => ['assets/icons/lumisade.png'],
        'fog' => ['assets/icons/sumu.png'],
        'fair_day' => ['assets/icons/Aurinko.png']
    ];

    if (isset($taulukko[$koodi])) {
        [$kuvalinkki] = $taulukko[$koodi]; // Purkaa taulukon saadakseen kuvalinkin
return $kuvalinkki
    ? ' <img src="' . $kuvalinkki . '" alt="" class="weather-icon3">' // Palauttaa kuvalinkin HTML-kuvana
    : $kuvalinkki;
    }

    return $koodi; 
}

    require_once("includes/htmlhead.php"); //sisältää footer, header, css, bootstrap
    ?>
    <title>Document</title>
</head>
<body> 

    
    <div class="container2">
        
    
           <div class="weather-info">
             
           

    
    
        
    <div id="clock" aria-live="polite"></div> 
    <br>
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
             
           
<?php
// Ota vain ensimmäinen aikapiste
$piste = $aikasarja[0];

// Muunna UTC-aika Suomen aikaan
$utcTime = new DateTime($piste['time'], new DateTimeZone('UTC'));
$utcTime->setTimezone(new DateTimeZone('Europe/Helsinki'));
$localTimeStr = $utcTime->format('H:i'); 

$temp = $piste['data']['instant']['details']['air_temperature'];
$saatieto = $piste['data']['next_1_hours']['summary']['symbol_code'] ?? 'N/A';

// Muita sääparametreja
$humidity   = $piste['data']['instant']['details']['relative_humidity'];   // %
$windSpeed  = $piste['data']['instant']['details']['wind_speed'];          // m/s
$windDir    = $piste['data']['instant']['details']['wind_from_direction']; // astetta
$visibility = $piste['data']['instant']['details']['visibility'] ?? null;          // metreinä
?>

<!-- Näytä sääinfo -->
<h1>
    <?php echo getSuomibig($saatieto); ?>
</h1>
<h1>
    <?php echo $temp; ?>°
</h1>



            

        </div>
        <div class="rivitin">
        <div class="weather-info1"><img src="assets/icons/kosteus.png" alt="sade" class="weather-icon"><p><?= $humidity ?>%</p></div>
        <div class="weather-info2"><img src="assets/icons/tuuli.png" alt="sade" class="weather-icon"><p><?= $windSpeed ?>m/s <br> <?= $windDir ?>°</p></div> 
        <div class="weather-info3"><img src="assets/icons/sumu.png" alt="sade" class="weather-icon"><p><?= $visibility !== null ? $visibility . " m" : "Ei tietoa" ?></p></div>


    </div>
    <br>
    <h2>Seuraavat tunnit</h2>
    <div class="container3">
    <div class="scrolling-wrapper">
        <?php
        $maxCards = min(12, count($aikasarja)); // Varmistaa, ettei yritetä näyttää enempää kortteja kuin mitä on saatavilla
        for ($i=0; $i < $maxCards; $i++) {
            $img = getSuomismall($aikasarja[$i]['data']['next_1_hours']['summary']['symbol_code']);
            $temp = $aikasarja[$i]['data']['instant']['details']['air_temperature'];
            
            $time = new DateTime($aikasarja[$i]['time'], new DateTimeZone('UTC'));
            $time->setTimezone(new DateTimeZone('Europe/Helsinki'));
            $time = $time->format('H:i'); 

            echo '<div class="card"><p>'. $time . '<br>' . $img .'<br>'. $temp . '°' .'</p></div>';
        }
        ?>
    </div>
    <!-- </div> -->
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
