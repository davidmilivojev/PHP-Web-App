<?php


if(!isset($_SESSION)) session_start();
if (!isset($_SESSION["username"])) header('Location: index.php');

require_once '/lib/class/Predavanje.php';

if (!empty($_POST['action']))
{

   $urlPOST = "http://localhost/david/services/izmenipredavanje";



   $curl_post_data = array(
           'Naziv' => $_POST['Naziv'],
           'Predavaci' => $_POST['Predavaci'],
           'Pocetak' => $_POST['Pocetak']." ".$_POST['PocetakVreme'].":00",
           'Kraj' => $_POST['Kraj']." ".$_POST['KrajVreme'].":00",
           'Konferencija' => $_POST['Konferencija']
        );
   $curl = curl_init($urlPOST);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
   $response = curl_exec($curl);
   if ($response) header('Location: /david/event.php');

}

if (!empty($_GET['id']))
{
   $id = $_GET['id']; // iz url adrese edit.php?id=XXX
   $urlGet = "http://localhost/david/services/predavanje/?idPredavanje=".$id;
   $curl = curl_init($urlGet);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($curl);
   $data = json_decode($response);

   $predavanje = new Predavanje();
   $predavanje->jsonDeserialize($data[0]);

}
else header('Location: event.php');
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
        <h1>Izmena predavanja: <?php echo $predavanje->get_naziv(); ?> </h1>
        <form name="konf" method="post" action="editevent.php">
        <table>
          <tr>
            <td>Naziv:</td>
            <td><input type="text" size="40" name="Naziv" value="<?php echo $predavanje->get_naziv(); ?>" required oninvalid="setCustomValidity('Unesite naziv konferencije... ')" onchange="try{setCustomValidity('')}catch(e){}" /></td>
          </tr>
          <tr>
            <td valign="top">Predavaci:</td>
            <td><textarea name="Predavaci" cols="30" rows="5" required oninvalid="setCustomValidity('Unesite opis konferencije... ')" onchange="try{setCustomValidity('')}catch(e){}"><?php echo $predavanje->get_predavaci(); ?></textarea></td>
          </tr>
          <tr>
            <td>Pocetak:</td>
            <td>
              <input type="date" name="Pocetak" value="<?php
                $time = strtotime($predavanje->get_pocetak());
                $myFormatForView = date("d.m.Y.", $time);
                echo $myFormatForView; ?> ">
              <input type="time" name="PocetakVreme" value="<?php
                $time = strtotime($predavanje->get_pocetak());
                $myFormatForView = date("G:i",$time);
                echo $myFormatForView; ?> " >
            </td>
          </tr>
          <tr>
            <td>Kraj:</td>
            <td>
              <input type="date" name="Kraj" value="<?php echo $predavanje->get_kraj(); ?> ">
              <input type="time" name="KrajVreme">
            </td>
          </tr>
          <tr>
            <td>Konferencija:</td>
            <td>
             <select name="Konferencija">
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
                        <?php if ($k->get_idKonferencija() == $predavanje->get_konferencija()->get_idKonferencija()) echo " selected"; ?>>
                          <?php echo $k->get_naziv(); ?> </option>
                        <?php
                    endforeach;
                    ?>
               </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="hidden" name="action" value="edit" >
              <input type="hidden" name="id" id="id" value="<?php echo $predavanje->get_idPredavanje(); ?>" >
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
