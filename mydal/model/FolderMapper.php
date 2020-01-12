<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Folder.php");


class FolderMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function findAllFolderByUserID($userId){
		$stmt = $this->db->prepare("SELECT * FROM carpeta WHERE PADRE IS NULL AND PROPIETARIO =?");
		$stmt->execute(array($userId));
		$folders_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$folders = array();

		foreach ($folders_db as $folder) {
			array_push($folders, new Folder($folder["ID_CARPETA"],$folder["NOMBRE"], $folder["PROPIETARIO"], $folder["PADRE"]));
		}
		return $folders;
	}



	public function findAllSubFolderByUserID($idCarpeta,$userId){
		$stmt = $this->db->prepare("SELECT * FROM carpeta WHERE PADRE=? AND PROPIETARIO =?");
		$stmt->execute(array($idCarpeta,$userId));
		$folders_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$folders = array();

		foreach ($folders_db as $folder) {
			array_push($folders, new Folder($folder["ID_CARPETA"],$folder["NOMBRE"], $folder["PROPIETARIO"], $folder["PADRE"]));
		}
		return $folders;
	}


	public function checkPropietario($userID){
		$stmt = $this->db->prepare("SELECT DISTINCT PROPIETARIO FROM carpeta WHERE PROPIETARIO=?");
		$stmt->execute(array($userID));
		$folders_db = $stmt->fetch(PDO::FETCH_ASSOC);
		$propietario_db = $folders_db["PROPIETARIO"];
	
		return $propietario_db;
	}



	public function existsFolder($idCarpeta){
		$stmt = $this->db->prepare("SELECT COUNT(*) as folders FROM carpeta WHERE ID_CARPETA=?");
		$stmt->execute(array($idCarpeta));
		$folders_db = $stmt->fetch(PDO::FETCH_ASSOC);
		$folder = $folders_db["folders"];
	
		if($folder == 1){
			return true;
		} else{
			return false;
		}
	}


	public function isMyFolder($idCarpeta, $userID){
		$stmt = $this->db->prepare("SELECT COUNT(*) as folders FROM carpeta WHERE ID_CARPETA=? AND PROPIETARIO =?");
		$stmt->execute(array($idCarpeta, $userID));
		$folders_db = $stmt->fetch(PDO::FETCH_ASSOC);
		$folder = $folders_db["folders"];

		if($folder == 1){
			return true;
		} else{
			return false;
		}
	}

	public function getCarpeta($folderID){
		$stmt = $this->db->prepare("SELECT * FROM carpeta WHERE ID_CARPETA=?");
		$stmt->execute(array($folderID));
		$folder = $stmt->fetch(PDO::FETCH_ASSOC);

		if($folder != null) {
			return new Folder(
			$folderID,
			$folder["NOMBRE"],
			$folder["PROPIETARIO"],
			$folder["PADRE"]);
		} else {
			return NULL;
		}
	}

		public function save($folder) {//pongo solo $folder o pongo tambien Folder
			$stmt = $this->db->prepare("INSERT INTO carpeta values (?,?,?,?)");
			$stmt->execute(array(0,$folder->getNombre(), $folder->getPropietario(), $folder->getPadre()));
			
			/*public function save($folder) {
			$stmt = $this->db->prepare("INSERT INTO CARPETA(NOMBRE, PROPIETARIO, PADRE) values (?,?,?)");
			$stmt->execute(array($folder->getNombre(), $folder->getPropietario(), $folder->getPadre()));
			return $this->db->lastInsertId(); ESTO ES NECESARIO HACERLO
		} */
			
		}

		public function delete($folder) {
			$stmt = $this->db->prepare("DELETE FROM carpeta WHERE ID_CARPETA=? AND PROPIETARIO=? ");
			$stmt->execute(array($folder->getIdCarpeta(), $folder->getPropietario()));
			
			
		}

	}
