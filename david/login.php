<?php

if (!empty($_POST['username']) && !empty($_POST['password']))
{
   $urlPOST = "http://localhost/david/services/login";
   $curl_post_data = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        );
   $curl = curl_init($urlPOST);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
   $result = curl_exec($curl);
   $out = json_decode($result);
   if (count($out)==2)
   {
       if ($out[1]==true)
       {
           // create session
           session_start();
           $_SESSION["username"]=$out[0];
           header('Location: list.php');
       }
       else
       {
           header('Location: index.php');
       }
   }
   else
   {
       // obavestiti korisnika o neuspelom logovanju
       if ($out[0]==false) header('Location: index.php');
   }

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
        <h1>Prijava</h1>
        <div class="index-items">
          <form name="login" method="POST" action="login.php">
            <h2>Korisnik:</h2>
            <input type="text" name="username" required oninvalid="setCustomValidity('Unesite username... ')" onchange="try{setCustomValidity('')}catch(e){}"/>
            <h2>Šifra:</h2>
            <input type="password" name="password" required oninvalid="setCustomValidity('Unesite password... ')" onchange="try{setCustomValidity('')}catch(e){}" />
            <br><input type="submit" value="Login">
			    </form>
        <p class="create-user"><a href="createaccount.php">Ukoliko nemate nalog kreirajte ga ovde</a></p>
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
