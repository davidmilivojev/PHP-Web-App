<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/class/Predavanje.php';

//dodato 8
//dodao 1
require_once '../lib/DAL/KonferencijaDAL.php';

class PredavanjeDAL extends DAL implements CommonDatabaseMethods
{
  function __construct() {

      parent::__construct();
  }

  function PrikaziPredavanjePretraga($search)
  {


      $sqlQuery="SELECT * FROM PREDAVANJE WHERE Konferencija = :Konferencija ORDER BY Pocetak asc";
      $params = array(":Konferencija"=>$search);

     $results = $this->IzvrsiUpit($sqlQuery, $params);

     $predResults = array();

     foreach ($results as $p)
     {
         $predResult = new Predavanje();
         $predResult->set_idPredavanje($p->idPredavanje);
         $predResult->set_naziv($p->Naziv);
         $predResult->set_predavaci($p->Predavaci);
         $predResult->set_pocetak($p->Pocetak);
         $predResult->set_kraj($p->Kraj);

         //dodao 2
         $konfDAL = new KonferencijaDAL();
         $predResult->set_konferencija($konfDAL->GetOne($p->Konferencija));
         $predResults[] = $predResult;
         // $konfDAL = new KonferencijaDAL();
         // $predResult->set_konferencija($konfDAL->GetOne($p->idKonferencije));
         // $predResults[] = $predResult;
     }

     return $predResults;
  }

  public function AddOne($object) {

      $object->ValidateFields();

      //dodao 3
      $sqlQuery="INSERT INTO Predavanje(Naziv, Predavaci, Pocetak, Kraj, Konferencija) VALUES(:naziv, :predavaci, :pocetak, :kraj, :konferencija)";
      $params = array(":naziv"=>$object->get_naziv(),
          ":predavaci" =>$object->get_predavaci(),
          ":pocetak" =>$object->get_pocetak(),
          ":kraj" =>$object->get_kraj(),
          //dodao 4
          ":konferencija"=>$object->get_konferencija()->get_idKonferencija());
          // ":idKonferencije"=>$object->get_konferencija()->get_idKonferencije());
      return $this->IzvrsiUpit($sqlQuery, $params);
  }

  public function DeleteOne($object)
  {
      $object->ValidateFields();
      $sqlQuery="DELETE FROM Predavanje WHERE idPredavanje = :idPredavanje";
      $params = array(":idPredavanje"=>$object->get_idPredavanje());
      return $this->IzvrsiUpit($sqlQuery, $params);
  }

  public function EditOne($object)
  {
      //$object->ValidateFields();
      //dodao 5
      $sqlQuery="UPDATE Predavanje SET Naziv = :naziv, Predavaci = :predavaci, Pocetak = :pocetak,  Kraj = :kraj, Konferencija = :konferencija WHERE idPredavanje = :idPredavanje";
      $params = array(":naziv"=>$object->get_naziv(),
              ":predavaci" =>$object->get_predavaci(),
              ":pocetak" =>$object->get_pocetak(),
              ":kraj" =>$object->get_kraj(),
              //dodao 6
              ":konferencija"=>$object->get_konferencija()->get_idKonferencija(),
              // ":rang"=>$object->get_rang()->get_idRang(),
              ":idPredavanje"=>$object->get_idPredavanje());
      return $results = $this->IzvrsiUpit($sqlQuery, $params);
  }

  public function GetAll()
  {
     $sqlQuery="SELECT * FROM PREDAVANJE";
     $params = array();
     $results = $this->IzvrsiUpit($sqlQuery,$params);

     $predResults = array();

     foreach ($results as $p)
     {
         $predResult = new Predavanje();
         $predResult->set_idPredavanje($p->idPredavanje);
         $predResult->set_naziv($p->Naziv);
         $predResult->set_predavaci($p->Predavaci);
         $predResult->set_pocetak($p->Pocetak);
         $predResult->set_kraj($p->Kraj);

         //dodao 7
         $konfDAL = new KonferencijaDAL();
         $predResult->set_konferencija($konfDAL->GetOne($p->Konferencija));
         $predResults[] = $predResult;
     }

     return $predResults;
  }

  public function GetOne($object)
  {

     $predfResult = new Predavanje();
     $predfResult->set_idPredavanje($object);

   $sqlQuery="SELECT * FROM PREDAVANJE WHERE idPredavanje = :idPredavanje";
   $params = array(":idPredavanje" =>$predfResult->get_idPredavanje());

     $results = $this->IzvrsiUpit($sqlQuery,$params);
     if (count($results)>0)
     {
         $p = $results[0];

         $predfResult = new Predavanje();
         $predfResult->set_idPredavanje($p->idPredavanje);
         $predfResult->set_naziv($p->Naziv);
         $predfResult->set_predavaci($p->Predavaci);
         $predfResult->set_pocetak($p->Pocetak);
         $predfResult->set_kraj($p->Kraj);

         //dodao 8
         $konfDAL = new KonferencijaDAL();
         $predfResult->set_konferencija($konfDAL->GetOne($p->Konferencija));

     }

     return $predfResult;

  }


}

?>
