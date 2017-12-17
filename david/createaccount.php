<?php

if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']))
{
   $urlPOST = "http://localhost/david/services/kreirajnalog";
   $curl_post_data = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'email' => $_POST['email'],
        );
   $curl = curl_init($urlPOST);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
   $response = curl_exec($curl);
   if ($response)
   {
       // create session
       session_start();
       $_SESSION["username"]=$_POST['username'];
       header('Location: /david/list.php');
   }
   else header('Location: index.php');
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
    <h1>Kreiraj nalog</h1>
    <div class="wrapper">
      <div class="content">    
        <div class="index-items">
          <form name="kreirajnalog" method="POST" action="createaccount.php">
            <h2>Korisnik:</h2>
            <input type="text" name="username" required oninvalid="setCustomValidity('Unesite username... ')" onchange="try{setCustomValidity('')}catch(e){}" />
            <h2>Šifra:</h2>
            <input type="password" name="password" required oninvalid="setCustomValidity('Unesite password... ')" onchange="try{setCustomValidity('')}catch(e){}" />
            <h2>E-mail:</h2>
            <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required oninvalid="setCustomValidity('Unesite validnu e-mail adresu... ')" onchange="try{setCustomValidity('')}catch(e){}" />
            <br><input type="submit" value="Kreiraj nalog">
          </form>
        </div>
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
