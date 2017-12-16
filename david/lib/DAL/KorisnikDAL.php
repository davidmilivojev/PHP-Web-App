<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/class/Korisnik.php';
require_once '../lib/DAL/CommonDatabaseMethods.php';

class KorisnikDAL extends DAL implements CommonDatabaseMethods
{

    function __construct()
	{
        parent::__construct();
    }


    function PronadjiKorisnika($username, $password)
    {

        $korisnikTMP = new Korisnik();
        $korisnikTMP->set_username($username);
        $korisnikTMP->set_password($password);

        $korisnikTMP->ValidateFields();

       $usernamemod = strtolower($korisnikTMP->get_username());
       $passwordmod = hash('sha256', $korisnikTMP->get_password());

       $sqlQuery = "SELECT * FROM KORISNIK WHERE username = :username AND password = :password";
	     $params = array(":username" => $usernamemod, ":password" =>$passwordmod);

       $results = $this->IzvrsiUpit($sqlQuery, $params);

       $korisnikResult = new Korisnik();

       if (count($results)>0)
       {
           $k = $results[0];
           $korisnikResult->set_idKorisnik($k->idKorisnik);
           $korisnikResult->set_username($k->username);
           $korisnikResult->set_password($k->password);
           $korisnikResult->set_email($k->email);

       }

       return $korisnikResult;
    }

    public function AddOne($object) {

        $object->ValidateFields();

        $object->set_username(strtolower($object->get_username()));
        $object->set_password(hash('sha256', $object->get_password()));

    		$sqlQuery = "INSERT INTO KORISNIK (username, password, email) VALUES (:username, :password, :email)";
    		$params = array(':username' =>  $object->get_username(),
						':password' => $object->get_password(),
						':email' => $object->get_email());

        return $this->IzvrsiUpit($sqlQuery,$params);

    }

    public function DeleteOne($object) {

    }

    public function EditOne($object) {

    }

    public function GetAll() {

  	   $sqlQuery = "SELECT * FROM KORISNIK";
  	   $params = array();

       $results = $this->IzvrsiUpit($sqlQuery,$params);

       $korisnikResults = array();

       foreach ($results as $k)
       {
           $korisnik = new Korisnik();
           $korisnik->set_idKorisnik($k->idKorisnik);
           $korisnik->set_username($k->username);
           $korisnik->set_password($k->password);
           $korisnik->set_email($k->email);
           $korisnikResults[] = $korisnik;
       }

       return $korisnikResults;
    }

    public function GetOne($object) {

       $korisnikTMP = new Korisnik();
       $korisnikTMP->set_username($object);

       $korisnikTMP->ValidateFields();

       $usernamemod = strtolower($korisnikTMP->get_username());
       $passwordmod = hash('sha256', $korisnikTMP->get_password());

       $sqlQuery = "SELECT * FROM KORISNIK WHERE username = :username";
       $params = array(":username" => $usernamemod);

       $results = $this->IzvrsiUpit($sqlQuery, $params);

       $korisnikResult = new Korisnik();

     if (count($results)>0)
     {
         $k = $results[0];
         $korisnikResult->set_username($k->username);
         $korisnikResult->set_email($k->email);

     }

     return $korisnikResult;

    }

}

?>
