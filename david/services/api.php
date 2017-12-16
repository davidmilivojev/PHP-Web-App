<?php
 	require_once "Rest.php" ;
        require_once '../lib/DAL/KonferencijaDAL.php';
        require_once '../lib/DAL/KorisnikDAL.php';
        require_once '../lib/DAL/PredavanjeDAL.php';


	class API extends REST
        {

            public function __construct() {
                parent::__construct();
            }

            public function processApi() {
                $func = strtolower(trim(str_replace("/", "", $_REQUEST['x'])));
                if ((int) method_exists($this, $func) > 0)
                    $this->$func();
                else
                    $this->response('false', 404);
            }

            public function json($data) {
                if (is_array($data)) {
                    return json_encode($data);
                }
            }

            private function konferencije() {

                if ($this->get_request_method() != "GET")
                    $this->response('false', 406);

                $konferencijaDAL = new KonferencijaDAL();
                $konferencije = $konferencijaDAL->GetAll();
                $this->response($this->json($konferencije), 200);
            }

            private function konferencijepretraga() {

                if ($this->get_request_method() != "GET")
                    $this->response('false', 406);

                $search = (string) $this->_request['search'];
                $konferencijaDAL = new KonferencijaDAL();
                $konferencije = $konferencijaDAL->PrikaziKonferencijePretraga($search);
                $this->response($this->json($konferencije), 200);
            }

            private function konferencija() {

                if ($this->get_request_method() != "GET") {
                    $this->response('false', 406);
                }

                $idKonferencije = (int) $this->_request['idKonferencije'];
                if ($idKonferencije > 0) {
                    $konferencijaDAL = new KonferencijaDAL();
                    $konferencija = $konferencijaDAL->GetOne($idKonferencije);
                    $result = array();
                    array_push($result, $konferencija);
                    $this->response($this->json($result), 200);
                }
                $this->response('false', 204);
            }

            private function dodajkonferenciju() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $konferencija = new Konferencija();
                $konferencija->set_naziv((string) $this->_request['Naziv']);
                $konferencija->set_opis((string) $this->_request['Opis']);
                $rangDAL = new RangDAL();
                $konferencija->set_rang($rangDAL->GetOne((int) $this->_request['Rang']));

                $konferencijaDAL = new KonferencijaDAL();
                $succ = $konferencijaDAL->AddOne($konferencija);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);

            }

            private function izmenikonferenciju() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $konferencija = new Konferencija();
                $konferencija->set_idKonferencija((int) $this->_request['id']);
                $konferencija->set_naziv((string) $this->_request['Naziv']);
                $konferencija->set_opis((string) $this->_request['Opis']);
                $rangDAL = new RangDAL();
                $konferencija->set_rang($rangDAL->GetOne((int) $this->_request['Rang']));

                $konferencijaDAL = new KonferencijaDAL();
                $succ = $konferencijaDAL->EditOne($konferencija);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);
            }

            private function obrisikonferenciju() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $konferencija = new Konferencija();
                $konferencija->set_idKonferencija((int) $this->_request['id']);
                $konferencijaDAL = new KonferencijaDAL();
                $succ = $konferencijaDAL->DeleteOne($konferencija);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);
            }

            private function rangovi() {
                if ($this->get_request_method() != "GET")
                    $this->response('false', 406);

                $rangDAL = new RangDAL();
                $rangArr = $rangDAL->GetAll();
                $this->response($this->json($rangArr), 200);
            }

            private function rang() {
                if ($this->get_request_method() != "GET") {
                    $this->response('false', 406);
                }
                $idRang = (int) $this->_request['idRang'];
                if ($idRang > 0) {
                    $rangDAL = new RangDAL();
                    $rang = $rangDAL->GetOne($idRang);
                    $result = array();
                    array_push($result, $rang);
                    $this->response($this->json($result), 200);
                }
                $this->response('false', 204);
            }

            // login

            private function kreirajnalog()
            {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $korisnik = new Korisnik();
                $korisnik->set_username((string) $this->_request['username']);
                $korisnik->set_password((string) $this->_request['password']);
                $korisnik->set_email((string) $this->_request['email']);

                $korisnikDAL = new KorisnikDAL();

                $succ = $korisnikDAL->AddOne($korisnik);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);
            }

            private function login()
            {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $username = (string) $this->_request['username'];
                $password = (string) $this->_request['password'];

                $korisnikDAL = new KorisnikDAL();
                $korisnik = $korisnikDAL->PronadjiKorisnika($username, $password);

                $result = array();
                if ($korisnik->get_idKorisnik()>0)
                {
                    array_push($result, $korisnik->get_username());
                    array_push($result, true);
                }
                else array_push($result, false);
                $this->response($this->json($result), 200);

            }

            private function getuserdata()
            {

              if ($this->get_request_method() != "GET") {
                  $this->response('false', 406);
              }


              $username = (string) $this->_request['usr'];

              $korisnikDAL = new KorisnikDAL();

              $userdata = $korisnikDAL->GetOne($username);
              $result = array();
              array_push($result, $userdata);
              $this->response($this->json($result), 200);
            }


            //predavanje
            //dodato 2

            private function predavanja() {

                if ($this->get_request_method() != "GET")
                    $this->response('false', 406);

                $predavanjeDAL = new PredavanjeDAL();
                $predavanje = $predavanjeDAL->GetAll();
                $this->response($this->json($predavanje), 200);
            }

            private function predavanjepretraga() {

                if ($this->get_request_method() != "GET")
                    $this->response('false', 406);

                $search = (string) $this->_request['search'];
                $predavanjeDAL = new PredavanjeDAL();
                $predavanje = $predavanjeDAL->PrikaziPredavanjePretraga($search);
                $this->response($this->json($predavanje), 200);
            }

            private function predavanje() {

                if ($this->get_request_method() != "GET") {
                    $this->response('false', 406);
                }

                $idPredavanje = (int) $this->_request['idPredavanje'];
                if ($idPredavanje > 0) {
                    $predavanjeDAL = new PredavanjeDAL();
                    $predavanje = $predavanjeDAL->GetOne($idPredavanje);
                    $result = array();
                    array_push($result, $predavanje);
                    $this->response($this->json($result), 200);
                }
                $this->response('false', 204);
            }

            private function dodajpredavanje() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $predavanje = new Predavanje();
                $predavanje->set_naziv((string) $this->_request['Naziv']);
                $predavanje->set_predavaci((string) $this->_request['Predavaci']);
                $predavanje->set_pocetak((string) $this->_request['Pocetak']);
                $predavanje->set_kraj((string) $this->_request['Kraj']);

                //dodao 1
                $konfDAL = new KonferencijaDAL();
                $predavanje->set_konferencija($konfDAL->GetOne((int) $this->_request['Konferencija']));

                $predavanjeDAL = new PredavanjeDAL();
                $succ = $predavanjeDAL->AddOne($predavanje);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);

            }

            private function izmenipredavanje() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $predavanje = new Predavanje();

                //dodato 2

                $predavanje->set_idPredavanje((int) $this->_request['id']);
                $predavanje->set_naziv((string) $this->_request['Naziv']);
                $predavanje->set_predavaci((string) $this->_request['Predavaci']);
                $predavanje->set_pocetak((string) $this->_request['Pocetak']);
                $predavanje->set_kraj((string) $this->_request['Kraj']);

                //dodato 3
                $konfDAL = new KonferencijaDAL();
                $predavanje->set_konferencija($konfDAL->GetOne((int) $this->_request['Konferencija']));

                $predavanjeDAL = new PredavanjeDAL();
                $succ = $predavanjeDAL->DeleteOne($predavanje);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);
            }

            private function obrisipredavanje() {
                if ($this->get_request_method() != "POST") {
                    $this->response('false', 406);
                }

                $predavanje = new Predavanje();
                $predavanje->set_idPredavanje((int) $this->_request['id']);
                $predavanjeDAL = new PredavanjeDAL();
                $succ = $predavanjeDAL->DeleteOne($predavanje);
                if (!$succ) $this->response('false', 204);
                else $this->response('true', 200);
            }
        }


	$api = new API;
	$api->processApi();
?>
