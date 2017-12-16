<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/class/Konferencija.php';
require_once '../lib/DAL/RangDAL.php';

class KonferencijaDAL extends DAL implements CommonDatabaseMethods
{
    function __construct() {

        parent::__construct();
    }

    function PrikaziKonferencijePretraga($search)
    {
        $tempKonf = new Konferencija();
        $tempKonf->set_naziv($search);
        $tempKonf->ValidateFields();

    		$sqlQuery="SELECT * FROM KONFERENCIJA WHERE Naziv LIKE :nazivKonferencije";
    		$params = array(":nazivKonferencije"=>"%".$tempKonf->get_naziv()."%");

       $results = $this->IzvrsiUpit($sqlQuery, $params);

       $konfResults = array();

       foreach ($results as $k)
       {
           $konfResult = new Konferencija();
           $konfResult->set_idKonferencija($k->idKonferencija);
           $konfResult->set_naziv($k->Naziv);
           $konfResult->set_opis($k->Opis);
           $rangDAL = new RangDAL();
           $konfResult->set_rang($rangDAL->GetOne($k->Rang));
           $konfResults[] = $konfResult;
       }

       return $konfResults;
    }

    public function AddOne($object) {

        $object->ValidateFields();

		$sqlQuery="INSERT INTO Konferencija(Naziv, Opis, Rang) VALUES(:naziv, :opis, :rang)";
		$params = array(":naziv"=>$object->get_naziv(),
						":opis" =>$object->get_opis(),
						":rang"=>$object->get_rang()->get_idRang());
        return $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function DeleteOne($object)
    {
        $object->ValidateFields();
    		$sqlQuery="DELETE FROM Konferencija WHERE idKonferencija = :idKonferencije";
    		$params = array(":idKonferencije"=>$object->get_idKonferencija());
        return $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function EditOne($object)
    {
        $object->ValidateFields();
    		$sqlQuery="UPDATE Konferencija SET Naziv = :naziv, Opis = :opis, Rang = :rang WHERE idKonferencija = :idKonferencija";
    		$params = array(":naziv"=>$object->get_naziv(),
    						":opis" =>$object->get_opis(),
    						":rang"=>$object->get_rang()->get_idRang(),
    						":idKonferencija"=>$object->get_idKonferencija());
        return $results = $this->IzvrsiUpit($sqlQuery, $params);
    }

    public function GetAll()
    {
  	   $sqlQuery="SELECT * FROM KONFERENCIJA";
  	   $params = array();
       $results = $this->IzvrsiUpit($sqlQuery,$params);

       $konfResults = array();

       foreach ($results as $k)
       {
           $konfResult = new Konferencija();
           $konfResult->set_idKonferencija($k->idKonferencija);
           $konfResult->set_naziv($k->Naziv);
           $konfResult->set_opis($k->Opis);
           $rangDAL = new RangDAL();
           $konfResult->set_rang($rangDAL->GetOne($k->Rang));
           $konfResults[] = $konfResult;
       }

       return $konfResults;
    }

    public function GetOne($object)
    {

       $konfResult = new Konferencija();
       $konfResult->set_idKonferencija($object);

	   $sqlQuery="SELECT * FROM KONFERENCIJA WHERE idKonferencija = :idKonferencija";
	   $params = array(":idKonferencija" =>$konfResult->get_idKonferencija());

       $results = $this->IzvrsiUpit($sqlQuery,$params);
       if (count($results)>0)
       {
           $k = $results[0];

           $konfResult = new Konferencija();
           $konfResult->set_idKonferencija($k->idKonferencija);
           $konfResult->set_naziv($k->Naziv);
           $konfResult->set_opis($k->Opis);
           $rangDAL = new RangDAL();
           $konfResult->set_rang($rangDAL->GetOne($k->Rang));

       }

       return $konfResult;

    }


}

?>
