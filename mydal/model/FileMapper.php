<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/File.php");

class FileMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function findAll() {
		$stmt = $this->db->query("SELECT * FROM files, users WHERE users.username = files.propietario");
		$files_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$files = array();

		foreach ($files_db as $file) {
			$author = new User($file["propietario"]);
			array_push($files, new File($file["id"], $file["nombre"], $file["padre"], $author));
		}

		return $files;
	}

	public function findById($fileid){
		$stmt = $this->db->prepare("SELECT * FROM files WHERE id=?");
		$stmt->execute(array($fileid));
		$file = $stmt->fetch(PDO::FETCH_ASSOC);

		if($file != null) {
			return new File(
			$file["id"],
			$file["nombre"],
			$file["padre"],
			new User($file["propietario"]));
		} else {
			return NULL;
		}
	}

	public function findUUIDById($fileid){
		$stmt = $this->db->prepare("SELECT UUID FROM fichero WHERE id_fichero=?");
		$stmt->execute(array($fileid));
		$file = $stmt->fetch(PDO::FETCH_ASSOC);

		if($file != null) {
			return bin2hex($file["UUID"]);
		} else {
			return NULL;
		}
	}


		public function save(File $file) {
			//$uid=uniqid();
			//var_dump($uid);
			//exit();
			$stmt = $this->db->prepare("SELECT (UNHEX(REPLACE(UUID(), '-', ''))) AS UUID");
			$stmt->execute(null);
			$uuid = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = $this->db->prepare("INSERT INTO fichero values (?,?,?,?,?,?,?)");
			$stmt->execute(array(0,$file->getNombre(), $file->getPropietario(), $file->getPadre(), $file->getFormato(), $file->getCompartido(), $uuid["UUID"]));
			return $this->db->lastInsertId();
		}


		public function delete($file, $ruta) {
			$stmt = $this->db->prepare("DELETE FROM fichero WHERE ID_FICHERO=? AND PROPIETARIO=? ");
			$stmt->execute(array($file->getIdFichero(), $file->getPropietario()));

			
			unlink($ruta);
			
		}

		public function addFile($userEmail, $id){
			
			$tmp_name = $_FILES["file"]["tmp_name"];
			$name = basename($_FILES["file"]["name"]);
			$partes = preg_split("/\./",$name);
			$size = sizeof($partes);
			$ext = $partes[$size-1];
			$ruta = "./Folders/$userEmail/$id.".$ext;
			move_uploaded_file($tmp_name, $ruta);
        
		}
		
		public function findAllFileByUserID($userId){
			$stmt = $this->db->prepare("SELECT * FROM fichero WHERE PADRE IS NULL AND PROPIETARIO =?");
			$stmt->execute(array($userId));
			$files_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$files = array();
	
			foreach ($files_db as $file) {
				array_push($files, new File($file["ID_FICHERO"],$file["NOMBRE"], $file["PROPIETARIO"], $file["PADRE"],"","",bin2hex($file["UUID"])));
			}
			return $files;
		}

		public function findAllSubFilesByUserID($idCarpeta,$userId){
			$stmt = $this->db->prepare("SELECT * FROM fichero WHERE PADRE=? AND PROPIETARIO =?");
			$stmt->execute(array($idCarpeta,$userId));
			$files_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$files = array();
	
			foreach ($files_db as $file) {
				array_push($files, new File($file["ID_FICHERO"],$file["NOMBRE"], $file["PROPIETARIO"], $file["PADRE"]));
			}
			return $files;
		}

		public function findFileById($idFichero, $userId){
			$stmt = $this->db->prepare("SELECT * FROM fichero WHERE ID_FICHERO = ? AND PROPIETARIO =?");
			$stmt->execute(array($idFichero,$userId));
			$file = $stmt->fetch(PDO::FETCH_ASSOC);
	
			if($file != null) {
				return new File(
					$file["ID_FICHERO"],
					$file["NOMBRE"],
					$file["PROPIETARIO"],
					$file["PADRE"]);
			}else{
				return NULL;
			}
		}

		public function download($tipo,$fileName,$ruta,$name){
			if(!empty($fileName) && file_exists($ruta)){
    		// Define headers
    		header("Cache-Control: public");
    		header("Content-Description: File Transfer");
    		header("Content-Disposition: attachment; filename=$name");
   			header("Content-Type: $tipo");
			header("Content-Transfer-Encoding: binary");
    
    		// Read the file
    		readfile($ruta);
    		exit;
			}else{
    		echo 'The file does not exist.';
			}
		}
		public function getFicheroId($fileID){
			$stmt = $this->db->prepare("SELECT * FROM fichero WHERE ID_FICHERO=?");
			$stmt->execute(array($fileID));
			$file = $stmt->fetch(PDO::FETCH_ASSOC);
	
			if($file != null) {
				return new File(
				$fileID,
				$file["NOMBRE"],
				$file["PROPIETARIO"],
				$file["PADRE"],
				$file["FORMATO"],
				$file["COMPARTIR"],
				bin2hex($file["UUID"]));
			} else {
				return NULL;
			}
		}

		
		public function getFichero($fileID){
			$stmt = $this->db->prepare("SELECT * FROM fichero WHERE UUID=?");
			$stmt->execute(array(hex2bin($fileID)));
			$file = $stmt->fetch(PDO::FETCH_ASSOC);
	
			if($file != null) {
				return new File(
				$fileID,
				$file["NOMBRE"],
				$file["PROPIETARIO"],
				$file["PADRE"],
				$file["FORMATO"],
				$file["COMPARTIR"],
				bin2hex($file["UUID"]));
			} else {
				return NULL;
			}
		}

		public function setCompartido($file){
			$stmt = $this->db->prepare("UPDATE fichero set  COMPARTIR=? where ID_FICHERO=?");
			$stmt->execute(array($file->getCompartido(), $file->getIdFichero()));
		}

		public function getPropietario($idPropietario){
			$stmt = $this->db->prepare("SELECT EMAIL FROM usuario where ID_USUARIO=?");
			$stmt->execute(array($idPropietario));
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if($user != null) {
				return $user["EMAIL"];
			} else {
				return NULL;
			}
		}

		public function existsFile($idFile){
			$stmt = $this->db->prepare("SELECT COUNT(*) as files FROM fichero WHERE ID_FICHERO=?");
			$stmt->execute(array($idFile));
			$files_db = $stmt->fetch(PDO::FETCH_ASSOC);
			$file = $files_db["files"];
		
			if($file == 1){
				return true;
			} else{
				return false;
			}
		}

		public function isMyFile($idFile, $userID){
			$stmt = $this->db->prepare("SELECT COUNT(*) as files FROM fichero WHERE ID_FICHERO=? AND PROPIETARIO =?");
			$stmt->execute(array($idFile, $userID));
			$files_db = $stmt->fetch(PDO::FETCH_ASSOC);
			$file = $files_db["files"];
	
			if($file == 1){
				return true;
			} else{
				return false;
			}
		}
	}
