<?php

require_once 'Rang.php';

class Konferencija implements JsonSerializable, FieldValidator {

    protected $_idKonferencija = 0;
    protected $_naziv = "";
    protected $_opis = "";
    protected $_rang;

    function __construct() {
    }

    function get_idKonferencija() {
        return $this->_idKonferencija;
    }

    function get_naziv() {
        return $this->_naziv;
    }

    function get_opis() {
        return $this->_opis;
    }

    function get_rang() {
        return $this->_rang;
    }

    function set_idKonferencija($_idKonferencija) {
        $this->_idKonferencija = $_idKonferencija;
    }

    function set_naziv($_naziv) {
        $this->_naziv = $_naziv;
    }

    function set_opis($_opis) {
        $this->_opis = $_opis;
    }

    function set_rang($_rang) {
        $this->_rang = $_rang;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    public function jsonDeserialize($data)
    {
        $this->_idKonferencija = $data->{'_idKonferencija'};
        $this->_naziv= $data->{'_naziv'};
        $this->_opis = $data->{'_opis'};
        $rang = new Rang();
        $rang->jsonDeserialize($data->{'_rang'});
        $this->_rang = $rang;
    }

     public function ValidateFields()
    {
        $this->_idKonferencija = formatInput($this->_idKonferencija);
        $this->_naziv= formatInput($this->_naziv);
        $this->_opis = formatInput($this->_opis);
        if ($this->_rang!=NULL) $this->_rang->ValidateFields();

    }

}

 ?>
