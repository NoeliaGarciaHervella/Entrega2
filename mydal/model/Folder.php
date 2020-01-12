<?php

require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../core/ValidationExceptionAux.php");


class Folder {


	private $id_carpeta;

	private $nombre;

	private $propietario;

	private $padre;


	public function __construct($id_carpeta=NULL, $nombre=NULL, $propietario=NULL,$padre=NULL) {
		$this->id_carpeta = $id_carpeta;
		$this->nombre = $nombre;
		$this->propietario = $propietario;
		$this->padre = $padre;
	}


	public function getIdCarpeta() {
		return $this->id_carpeta;
	}
	public function setIdCarpeta($id_carpeta) {
		$this->id_carpeta = $id_carpeta;
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
			throw new ValidationExceptionAux($errors, "Folder is not valid");
		}
	}


}
