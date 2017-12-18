<?php

$con = mysql_connect("localhost", "root", "");

$kreirajBazu = "CREATE DATABASE IF NOT EXISTS `konferencije_ias` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

$kreirajTabeluRang = "CREATE TABLE IF NOT EXISTS `rang` (
  `idRang` bigint(20) NOT NULL AUTO_INCREMENT,
  `nazivRang` varchar(250) NOT NULL,
  PRIMARY KEY (`idRang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$kreirajTabeluKonferencija = "CREATE TABLE IF NOT EXISTS `konferencija` (
  `idKonferencija` bigint(20) NOT NULL AUTO_INCREMENT,
  `Naziv` text NOT NULL,
  `Opis` text NOT NULL,
  `Rang` bigint(20) NOT NULL,
  PRIMARY KEY (`idKonferencija`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$kreirajTabeluPredavanja = "CREATE TABLE IF NOT EXISTS `predavanje` (
  `idPredavanje` bigint(20) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Predavaci` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Pocetak` datetime NOT NULL,
  `Kraj` datetime NOT NULL,
  `Konferencija` bigint(20) NOT NULL,
  PRIMARY KEY (`idPredavanje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";


$kreirajTabeluKornisnik = "CREATE TABLE IF NOT EXISTS `korisnik` (
  `idKorisnik` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idKorisnik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";


$popuniTabeluRang = "INSERT INTO `rang` (`idRang`, `nazivRang`) VALUES
(1, 'Medjunarodna'),
(2, 'IEEE'),
(3, 'Domaca');";

$popuniTabeluKonferencija = "INSERT INTO `konferencija` (`idKonferencija`, `Naziv`, `Opis`, `Rang`) VALUES
(1, 'UrbanEco', 'Ecology of urban areas..', 1),
(2, 'ITRO', 'Information Technology and Education Developement', 1),
(3, 'IEEE SMC', 'Systems, Man, Cybernetics...', 2);";

$popuniTabeluPredavanja = "INSERT INTO `predavanje` (`idPredavanje`, `Naziv`, `Predavaci`, `Pocetak`, `Kraj`, `Konferencija`) VALUES
(1, 'prvo', 'it predavanje', '2017-12-26 03:04:03', '2017-12-28 03:06:09', 2),
(2, 'drugo', 'it predavanje 2', '2017-11-28 17:06:00', '2017-12-27 00:00:00', 1);";



mysql_query($kreirajBazu);
mysql_select_db('konferencije_ias', $con);
mysql_query($kreirajTabeluRang);
mysql_query($kreirajTabeluKonferencija);
mysql_query($kreirajTabeluKornisnik);
mysql_query($kreirajTabeluPredavanja);
mysql_query($popuniTabeluRang);
mysql_query($popuniTabeluKonferencija);
mysql_query($popuniTabeluPredavanja);

echo "Uspesno kreirano ako nema upozorenja!!";

?>
