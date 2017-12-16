<?php

require_once 'InterfaceFieldValidator.php';
require_once 'inputFormaterCustom.php';

class Korisnik implements JsonSerializable, FieldValidator
{
    protected $_idKorisnik;
    protected $_username;
    protected $_password;
    protected $_email;

    function get_idKorisnik() {
        return $this->_idKorisnik;
    }

    function set_idKorisnik($_idKorisnik) {
        $this->_idKorisnik = $_idKorisnik;
    }

    function get_username() {
        return $this->_username;
    }

    function get_password() {
        return $this->_password;
    }

    function get_email() {
        return $this->_email;
    }

    function set_username($_username) {
        $this->_username = $_username;
    }

    function set_password($_password) {
        $this->_password = $_password;
    }

    function set_email($_email) {
        $this->_email = $_email;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    public function jsonDeserialize($data)
    {
        $this->_idKorisnik = $data->{"_idKorisnik"};
        $this->_username = $data->{'_username'};
        $this->_password= $data->{'_password'};
        $this->_email = $data->{'_email'};
    }


	  public function ValidateFields()
    {
		    $this->_idKorisnik = formatInput($this->_idKorisnik);
        $this->_username = formatInput($this->_username);
        $this->_password= formatInput($this->_password);
        $this->_email = formatInput($this->_email);

    }

}
?>
