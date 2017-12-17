<?php

if(!isset($_SESSION)) session_start();
if (!isset($_SESSION["username"])) header('Location: index.php');


require_once '/lib/class/Konferencija.php';

$curl = curl_init('http://localhost/david/services/konferencije');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$data = json_decode($response);
$konferencije = array();

for ($i=0; $i<=count($data)-1;$i++)
{
    $konferencija = new Konferencija();
    $konferencija->jsonDeserialize($data[$i]);
    array_push($konferencije, $konferencija);
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
        <h1>Administracija konferencija</h1>
        <h4 class="create-konf"><a href="create.php">Kreiranje konferencije</a></h4>
        <?php foreach($konferencije as $k): ?>
          <div class="access-items">
            <h2 class="access-title">
              Naziv: <?php echo $k->get_naziv(); ?>
            </h2>
            <form alt="edit"name="edit<?php echo $k->get_idKonferencija(); ?>" method="GET" action="edit.php">
              <input type="hidden" name="id" value="<?php echo $k->get_idKonferencija(); ?>"/>
              <input type="Button" value="Izmeni" onclick="document.edit<?php echo $k->get_idKonferencija(); ?>.submit()"/>
            </form>
            <form alt="delete" name="delete<?php echo $k->get_idKonferencija(); ?>" method="POST" action="delete.php">
              <input type="hidden" name="id" id="id" value="<?php echo $k->get_idKonferencija(); ?>"/>
              <input type="Button" value="Obriši" onclick="document.delete<?php echo $k->get_idKonferencija(); ?>.submit()"/>
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
