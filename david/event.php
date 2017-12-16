<?php
require_once '/lib/class/Predavanje.php';

if(!isset($_SESSION)) session_start();
if (!isset($_SESSION["username"])) header('Location: index.php');

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
      <img class="banner" src="images/banner.png" alt="">
      <div class="content">
        <h1>Lista predavanja</h1>
        <div class="admin-panel">
          <form name="trazi" method="GET" action="event.php">
            <select class="filtKonf" name="search">
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
                     <option value="<?php echo $k->get_idKonferencija(); ?>">  <?php echo $k->get_naziv(); ?> </option>
                   <?php
                   endforeach;
                   ?>
              </select>
              <input type="submit" name="filt" value="Filtriraj">
          </form>
          <a class="all-events" name="tez" href="event.php">Prikazi sve</a>
          <div class="clr">
          </div>
        </div>
          <h4 class="create-konf"><a href="createevent.php">Kreiranje predavanja</a></h4>
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
              <form alt="edit"name="edit<?php echo $p->get_idPredavanje(); ?>" method="GET" action="editevent.php">
                <input type="hidden" name="id" value="<?php echo $p->get_idPredavanje(); ?>"/>
                <input type="Button" value="Izmeni" onclick="document.edit<?php echo $p->get_idPredavanje(); ?>.submit()"/>
              </form>
              <form alt="delete" name="delete<?php echo $p->get_idPredavanje(); ?>" method="POST" action="deleteevent.php">
                <input type="hidden" name="id" id="id" value="<?php echo $p->get_idPredavanje(); ?>"/>
                <input type="Button" value="Obriši" onclick="document.delete<?php echo $p->get_idPredavanje(); ?>.submit()"/>
              </form>
              <div class="clr">
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    <footer>
      <div class="wrapper">
        <p>Design by: David Milivojev</p>
      </div>
    </footer>
  </body>
</html>
