<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/class/Rang.php';
require_once '../lib/DAL/CommonDatabaseMethods.php';


class RangDAL extends DAL implements CommonDatabaseMethods
{
    function __construct() {

        parent::__construct();
    }

    public function AddOne($object)
    {
        $object->ValidateFields();

  	    $sqlQuery = "INSERT INTO RANG (nazivRang) VALUES (:nazivRang)";
  	    $params = array(":nazivRang"=>$object->get_nazivRang());
  	    return $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function EditOne($object)
    {
        $object->ValidateFields();

		    $sqlQuery = "UPDATE RANG SET nazivRang = :nazivRang WHERE idRang = :idRang";
	      $params = array(":nazivRang"=>$object->get_nazivRang(), ":idRang"=>$object->get_idRang());

        return $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function DeleteOne($object)
    {
        $object->ValidateFields();

		    $sqlQuery = "DELETE FROM RANG WHERE idRang = :idRang";
	      $params = array(":idRang"=>$object->get_idRang());

        return $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function GetAll()
    {
  	   $sqlQuery = "SELECT * FROM RANG";
  	   $params = array();

       $results = $this->IzvrsiUpit($sqlQuery, $params);
       $rangResults = array();

       foreach ($results as $k)
       {
           $rang = new Rang();
           $rang->set_idRang($k->idRang);
           $rang->set_nazivRang($k->nazivRang);
           $rangResults[] = $rang;
       }

       return $rangResults;

    }

    public function GetOne($object) {

       $rangResult = new Rang();
       $rangResult->set_idRang($object);
       $rangResult->ValidateFields();

  	   $sqlQuery = "SELECT * FROM RANG WHERE idRang = :idRang";
  	   $params = array(":idRang"=>$rangResult->get_idRang());

       $results = $this->IzvrsiUpit($sqlQuery, $params);

       if (count($results)>0)
       {
           $k = $results[0];
           $rangResult->set_idRang($k->idRang);
           $rangResult->set_nazivRang($k->nazivRang);

       }

       return $rangResult;
    }


}

?>
