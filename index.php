<?php
$config = include('config.php');
include_once('controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
        integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css" />

  <title>Pivo's Monopoly</title>
  <style>
    @media print {
      .collapse {
        display: block !important;
        height: auto !important;
      }
      
      .hidden-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-xs navbar-light bg-light">
  <a class="navbar-brand" href="#">Pivo Monopoly</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" data-page="page-location" href="#">Locatie <span
              class="sr-only">
            (current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-page="page-map" href="#">Kaart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-page="page-currency" href="#">Geld</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-page="page-ownership" href="#">Scores</a>
      </li>
<!--      <li class="nav-item">-->
<!--        <a class="nav-link" href="javascript:localStorage.clear();location.reload();">Uitloggen</a>-->
<!--      </li>-->
    </ul>
  </div>
</nav>

<div id="page-location" class="page container">
  
  <div class="monopoly-card d-none">
    <div>
      <div class="m-name" id="m-name">
      
      </div>
      <div>
        <img id="m-image" src="">
      </div>
      <div class="price">
        <p>Aanschafprijs: &euro;&nbsp;<span id="m-price"></span><br/>
        Huurprijs: &euro;&nbsp;<span id="m-rent"></span></p>
        <div class="text-center">
          <button class="ownership buy-button d-none" id="buy-button">Koop
            nu!</button>
          <button class="ownership buy-button d-none" disabled
                  id="buy-button-disabled">Niet
            genoeg geld...</button>
          <p class="d-none ownership" id="buy-unavailable">Eigendom van: <span
                id="owner"></span></p>
        </div>
      </div>
    </div>
  </div>
  
  <div class="compass">
    <img src="img/kompas.png">
    <h3>Ga naar een bestemming...</h3>
    <div>
      <div class="card destination-container">
        <h5>Mogelijke bestemmingen</h5>
        <ol id="destinations"></ol>
      </div>
    </div>
  </div>

</div>

<div id="page-map" class="page d-none" style="height: calc(100% - 56px)">
  <div id="map"></div>
</div>

<div id="page-ownership" class="page container d-none">
  <table class="table table-responsive">
    <thead>
    <tr>
      <th>Team</th>
      <th>Bezittingen</th>
      <th>Geld</th>
      <th>Waarde bezittingen</th>
    </tr>
    </thead>
    <tbody id="score-table">
    
    </tbody>
  </table>
</div>

<div id="page-currency" class="page container d-none">
  <h1 class="balance">&euro;&nbsp;<span id="balance"></span></h1>
</div>






<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/monopoly.js?<?= rand(); ?>" type="application/javascript"></script>
<script src="js/fontawesome-markers.min.js"
        type="application/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWJoXjdl58XEV9DTYU54ykt3ZP0kYPtgY&callback=initMap"
        async defer></script>

<script type="application/javascript">
  locations = [];
  balance = 0;
  
  init();
</script>
</body>
</html>
