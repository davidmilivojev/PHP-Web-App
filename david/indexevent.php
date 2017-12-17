<?php
require_once '/lib/class/Predavanje.php';

$targetURL;
if (!empty($_GET["search"])) $targetURL = "http://localhost/david/services/predavanjepretraga/?search=".$_GET["search"];
else $targetURL = "http://localhost/david/services/predavanja";

$curl = curl_init($targetURL);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$data = json_decode($response);

$predavanja = array();

for ($i=0; $i<=count($data)-1;$i++)
{
    $predavanje = new Predavanje();
    $predavanje->jsonDeserialize($data[$i]);
    array_push($predavanja, $predavanje);
}

     $konferencija = new Konferencija();

if (!empty($_GET["search"]))
{

     $id = $_GET['search']; // iz url adrese edit.php?id=XXX
     $urlGet = "http://localhost/david/services/konferencija/?idKonferencije=".$id;
     $curl = curl_init($urlGet);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     $response = curl_exec($curl);
     $data = json_decode($response);

     $konferencija = new Konferencija();
     $konferencija->jsonDeserialize($data[0]);
}



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
  <img class="banner" src="images/banner.png" alt="">
  <h1>Lista predavanja</h1>
  <div class="wrapper">
    <div class="content">
        <div class="admin-panel">
          <form name="trazi" method="GET" action="indexevent.php">
            <select class="filtKonf" name="search">
              <option value="default">nesto</option>
               <?php

                   $curl = curl_init('http://localhost/david/services/konferencije');
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                   $response = curl_exec($curl);
                   $data = json_decode($response);
                   $konferencije = array();

                   for ($i=0; $i<=count($data)-1;$i++)
                   {
                       $konf = new Konferencija();
                       $konf->jsonDeserialize($data[$i]);
                       array_push($konferencije, $konf);
                   }

                   foreach($konferencije as $k):
                   ?>
                     <option value="<?php echo $k->get_idKonferencija(); ?>"
                       <?php if (!empty($_GET["search"]))  if ($k->get_idKonferencija() == $_GET["search"]) echo " selected"; ?>>
                         <?php echo $k->get_naziv(); ?> </option>
                       <?php
                   endforeach;
                   ?>
              </select>
              <input type="submit" name="filt" value="Filtriraj">
          </form>
          <a class="all-events" href="indexevent.php">Prikazi sve</a>
          <div class="clr">
          </div>
        </div>
        <div class="index-items">
          <div class="index-item-header">
          </div>
          <h2>Naziv: <?php echo $konferencija->get_naziv(); ?></h2>
          <p>Opis: <?php echo $konferencija->get_opis(); ?></p>
          <p>Rang: <?php if ($konferencija->get_rang()!=NULL) echo $konferencija->get_rang()->get_nazivRang(); ?></p>
        </div>
        	<?php foreach($predavanja as $p): ?>
            <div class="index-items">
              <div class="index-item-header">
              </div>
              <h2>Naziv: <?php echo $p->get_naziv(); ?></h2>
              <p>Predavaci: <?php echo $p->get_predavaci(); ?></p>
              <p>Pocetak: <?php
                $time = strtotime($p->get_pocetak());
                $myFormatForView = date("d.m.Y.", $time)." u ". date("G:i",$time)."h";
                echo $myFormatForView; ?>
              </p>
              <p>Kraj: <?php $time = strtotime($p->get_kraj());
                $myFormatForView = date("d.m.Y.", $time)." u ". date("G:i",$time)."h";
                echo $myFormatForView; ?>
              </p>
              <p>Konferencija: <?php echo $p->get_konferencija()->get_naziv(); ?></p>
              <div class="clr">
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    <div class="footer-top">
    </div>
    <footer>
      <div class="wrapper">
        <p>Design by: David Milivojev</p>
      </div>
    </footer>
  </body>
</html>
