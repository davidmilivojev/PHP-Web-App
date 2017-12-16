<?php
    require_once '/lib/class/Korisnik.php';
    session_start();
    $targetURL = "http://localhost/david/services/getuserdata/?usr=".$_SESSION["username"];

    $curl = curl_init($targetURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $data = json_decode($response);

    $konferencije = array();
    $konferencija = new Korisnik();
    $konferencija->jsonDeserialize($data[0]);
    array_push($konferencije, $konferencija);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>david</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
      <header>
        <div class="wrapper">
          <nav class="menu">
            <!-- <ul>
              <li>Home</li>
              <li>List</li>
              <li>User</li>
              <li>Login</li>
              <li>Logout</li>
            </ul> -->
            <?php  require_once "parts/mainmenu.php"; ?>
          </nav>
          <div class="search">
            <?php include('side_menu.php'); ?>
          </div>
          <div class="clr"></div>
        </div>
      </header>
    <div class="wrapper">
      <img class="banner" src="images/banner.svg" alt="">
      <div class="content">
        <h1>Profil korisnika</h1>
        <div class="index-items">
          <div class="index-item-header">
          </div>
        <?php
          echo "<h2>Korisnik: ";
          echo $konferencije[0]->get_username();
          echo "</h2>";
          echo "<h2>E-mail: ";
          echo $konferencije[0]->get_email();
          echo "</h2>";
        ?>
        </div>
      </div>
    </div>
    <footer>
      <div class="wrapper">
        <p>Design by: David Milivojev</p>
      </div>
    </footer>
  </body>
</html>
