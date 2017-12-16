<ul>
  <li><a href="index.php">Početna</a></li>
  <li><a href="indexevent.php">Predavanja</a></li>
  <li><a href="list.php">Lista-izmene</a></li>
    <?php
        if(!isset($_SESSION)) session_start();
  			  if (isset($_SESSION["username"]))
  			  {
            echo "<li><a href=\"event.php\">";
            echo "Predavanja-izmene";
            echo "</a></li>";
            echo "<li><a href=\"user.php\">";
            echo $_SESSION["username"];
            echo "</a></li>";
            echo "<li><a href=\"logout.php\">";
            echo "Odjavi se";
            echo "</a></li>";
  			  }
  			  else echo "<li><a href=\"login.php\">Prijavi se</a></li>";
    ?>
</ul>
