<?php


require_once 'InterfaceFieldValidator.php';
require_once 'inputFormaterCustom.php';

class Rang implements JsonSerializable, FieldValidator
{
    protected $_idRang = 0;
    protected $_nazivRang = "";

    function get_idRang() {
        return $this->_idRang;
    }

    function get_nazivRang() {
        return $this->_nazivRang;
    }

    function set_idRang($_idRang) {
        $this->_idRang = $_idRang;
    }

    function set_nazivRang($_nazivRang) {
        $this->_nazivRang = $_nazivRang;
    }

    function __construct() {

    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    public function jsonDeserialize($data)
    {
        $this->_idRang = $data->{'_idRang'};
        $this->_nazivRang = $data->{'_nazivRang'};
    }

    public function ValidateFields()
    {
	      $this->_idRang = formatInput($this->_idRang);
        $this->_nazivRang = formatInput($this->_nazivRang);

    }

}

 ?>
