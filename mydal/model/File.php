<?php


require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../core/ValidationExceptionAux.php");


class File {


	private $id_fichero;

	private $nombre;

	private $propietario;

	private $padre;

	private $formato;
	
	private $compartido;

	private $uuid;


	public function __construct($id_fichero=NULL, $nombre=NULL, $propietario=NULL,$padre=NULL,$formato=NULL,$compartido=NULL, $uuid=NULL) {
		$this->id_fichero = $id_fichero;
		$this->nombre = $nombre;
		$this->propietario = $propietario;
		$this->padre = $padre;
		$this->formato = $formato;
		$this->compartido = $compartido;
		$this->uuid = $uuid;
	}

	public function getCompartido() {
		return $this->compartido;
	}
	public function setCompartido($compartido) {
		$this->compartido = $compartido;
	}


	public function getIdFichero() {
		return $this->id_fichero;
	}


	public function setIdFichero($idFichero) {
		$this->id_fichero = $idFichero;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function getPropietario() {
		return $this->propietario;
	}

	public function setPropietario($propietario) {
		 $this->propietario = $propietario;
	}


	public function setPadre($padre) {
		$this->padre = $padre;
	}

	public function getPadre() {
		return $this->padre;
	}

	public function getFormato() {
		return $this->formato;
	}

	public function setFormato($formato) {
		$this->formato = $formato;
	}

	public function getUUID(){
		return $this->uuid;
	}

	public function setUUID($uuid){
		$this->uuid = $uuid;
	}

	public function checkIsValidForCreate() {
		
		$errors = array();
		if (strlen(trim($this->nombre)) == 0 ) {
			$errors = "Name is mandatory";
		}

		else if (strlen(trim($this->nombre)) > 255 ) {
			$errors = "Name is too long";
		}

		else if (!is_int($this->propietario)) {
				$errors = "Owner format is incorrect";
		}

		else if ($this->padre != null && $this->padre > 0 ) {
			if (!is_int($this->padre)) {
				$errors = "Owner format is incorrect";
			}
		}
		
		if (sizeof($errors) > 0){
			throw new ValidationExceptionAux($errors, "File is not valid");
		}
	}



}
