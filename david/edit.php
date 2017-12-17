<?php

if(!isset($_SESSION)) session_start();
if (!isset($_SESSION["username"])) header('Location: index.php');

require_once '/lib/class/Konferencija.php';


if (!empty($_POST['action']))
{

   $urlPOST = "http://localhost/david/services/izmenikonferenciju";
   $curl_post_data = array(
        'id' => $_POST['id'],
        'Naziv' => $_POST['Naziv'],
        'Opis' => $_POST['Opis'],
        'Rang' => $_POST['Rang']
        );
   $curl = curl_init($urlPOST);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
   $response = curl_exec($curl);
   if ($response) header('Location: /david/list.php');

}


// Ukoliko nemamo poslate podatke potrebno je preuzeti podatke o entitetu
if (!empty($_GET['id']))
{
   $id = $_GET['id']; // iz url adrese edit.php?id=XXX
   $urlGet = "http://localhost/david/services/konferencija/?idKonferencije=".$id;
   $curl = curl_init($urlGet);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($curl);
   $data = json_decode($response);

   $konferencija = new Konferencija();
   $konferencija->jsonDeserialize($data[0]);

}
else header('Location: list.php');
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
        <h1>Izmena konferencije: <?php echo $konferencija->get_naziv(); ?></h1>
        <form name="konf" method="post" action="edit.php">
  				<table>
  					<tr>
  						<td>
  						Naziv:
  						</td>
  						<td>
                <input type="text" size="40" name="Naziv" value="<?php echo $konferencija->get_naziv(); ?>" required oninvalid="setCustomValidity('Unesite naziv konferencije... ')" onchange="try{setCustomValidity('')}catch(e){}" />
  						</td>
  					</tr>
  					<tr>
  						<td valign="top">
  						Opis:
  						</td>
  						<td>
                <textarea name="Opis" cols="30" rows="5" required oninvalid="setCustomValidity('Unesite opis konferencije... ')" onchange="try{setCustomValidity('')}catch(e){}"><?php echo $konferencija->get_opis(); ?></textarea>
  						</td>
  					</tr>
  					<tr>
  						<td>
  						Rang:
  						</td>
  						<td>
                <select name="Rang">

                    <?php

                        $curl = curl_init('http://localhost/david/services/rangovi');
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        $data = json_decode($response);
                        $rangovi = array();

                        for ($i=0; $i<=count($data)-1;$i++)
                        {
                            $rang = new Rang();
                            $rang->jsonDeserialize($data[$i]);
                            array_push($rangovi, $rang);
                        }

                        foreach($rangovi as $k):
                       ?>

                    <option value="<?php echo $k->get_idRang(); ?>"
                       <?php if ($k->get_idRang() == $konferencija->get_rang()->get_idRang()) echo " selected"; ?>
                           > <?php echo $k->get_nazivRang(); ?>
                    </option>
                        <?php
                        endforeach;
                    ?>

                </select>
              </td>
  					</tr>
  					<tr>
  						<td colspan="2" align="center">
  						<input type="hidden" name="action" value="edit" >
              <input type="hidden" name="id" id="id" value="<?php echo $konferencija->get_idKonferencija(); ?>" >
  				    <input type="submit" value="Snimi" >
  						</td>
  					</tr>
  				</table>
  			</form>
      </div>
    </div>
    <footer>
      <div class="wrapper">
        <p>Design by: David Milivojev</p>
      </div>
    </footer>
  </body>
</html>
