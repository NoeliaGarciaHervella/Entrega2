<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/File.php");
require_once(__DIR__."/../model/FileMapper.php");
require_once(__DIR__."/../model/FolderMapper.php");
require_once(__DIR__."/../controller/BaseController.php");


class FilesController extends BaseController {


	private $fileMapper;

	public function __construct() {
		$this->fileMapper = new FileMapper();
		parent::__construct();
		$this->folderMapper = new folderMapper();
		parent::__construct();

		

	}

	public function addFile(){

		$file = new File();
		$userId = $this->view->getVariable("userId");
		$userEmail = $this->view->getVariable("userEmail");

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		$file->setNombre($_FILES["file"]["name"]);
		$file->setPropietario($userId);
		$file->setFormato($_FILES["file"]["type"]);
		$file->setCompartido("NO");
		
		if (isset($_GET["idFather"])) {
			$file->setPadre((int)$_GET["idFather"]);
			$idCarpeta = $_GET['idFather'];
			$existsFolder = $this->folderMapper->existsFolder($idCarpeta);
			if ($existsFolder == false) {
				$this->view->setFlashDanger("Folder doesnt exist!");
				$this->view->redirect("folders", "showall");
			}

			//Es mi carpeta?
			$ownFolder = $this->folderMapper->isMyFolder($idCarpeta, $userId);
			if ($ownFolder == false) {
				$this->view->setFlashDanger("You have not permissions to access");
				$this->view->redirect("folders", "showall");
			}
		
		}
		try{
		
			$file->checkIsValidForCreate();

			$id = $this->fileMapper->save($file);
			$uuid = $this->fileMapper->findUUIDById($id);
			$this->fileMapper->addFile($userEmail,$uuid,$file->getFormato());
			
			if (!isset($_GET["idFather"])) {
				$this->view->redirect("folders","showall");
			}else{
				$idFather = "idFather=".$_GET["idFather"];
				$this->view->redirect("folders","showall",$idFather);
			}
				
		}catch(ValidationExceptionAux $ex) {
			$errors = $ex->getErrors();
			$this->view->setFlashDanger($errors);
				
			if (!isset($_GET["idFather"])) {
				$this->view->redirect("folders","showall");
			}else{
				$idFather = "idFather=".$_GET["idFather"];
				$this->view->redirect("folders","showall",$idFather);
			}
		}
	}


	public function downloadFile(){

		$file = new File();
		$userId = $this->view->getVariable("userId");
		$userEmail = $this->view->getVariable("userEmail");

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		if (isset($_GET["idFile"])) {
			$idFichero = $_GET['idFile'];
			$existsFile = $this->fileMapper->existsFile($idFichero);
			

			if ($existsFile == false) {
				$this->view->setFlashDanger("File doesnt exist!");
				$this->view->redirect("folders", "showall");
			}
			//Es mi fichero?
			$ownFile = $this->fileMapper->isMyFile($idFichero, $userId);
			if ($ownFile == false) {
				$this->view->setFlashDanger("You have not permissions to access");
				$this->view->redirect("folders", "showall");
			}
			$file = $this->fileMapper->getFicheroId($_GET["idFile"]);
			//Conseguir formato
			$tipo = $file->getFormato();
				//conseguir nombre fichero
			$name = $file->getNombre();
			//hacer split
			$partes = preg_split("/\./",$name);
			$size = sizeof($partes);
			$ext = $partes[$size-1];
			//nombre con el que esta guardado
			$fileName = $file->getUUID().".".$ext;
			//hacer ruta
			$ruta = "./Folders/$userEmail/$fileName";
			
		$this->fileMapper->download($tipo,$fileName,$ruta,$name);
		}else{
			$this->view->redirect("folders", "showall");
		}
		
	}

	public function deleteFile(){
		$file = new File();
		$userId = $this->view->getVariable("userId");

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		if (isset($_GET["idFile"])) {
			$idFichero = $_GET['idFile'];
			$existsFile = $this->fileMapper->existsFile($idFichero);
			if ($existsFile == false) {
				$this->view->setFlashDanger("File doesnt exist!");
				$this->view->redirect("folders", "showall");
			}
			//Es mi fichero?
			$ownFile = $this->fileMapper->isMyFile($idFichero, $userId);
			if ($ownFile == false) {
				$this->view->setFlashDanger("You have not permissions to access");
				$this->view->redirect("folders", "showall");
			}
			$file->setIdFichero($_GET["idFile"]);
		$file->setPropietario($userId);
		
		$file2 = $this->fileMapper->getFicheroId($_GET["idFile"]);
		$padre = $file2->getPadre();

			//conseguir nombre fichero
			$name = $file2->getNombre();
			//hacer split
			$partes = preg_split("/\./",$name);
			$size = sizeof($partes);
			$ext = $partes[$size-1];
			//nombre con el que esta guardado
			$fileName = $_GET["idFile"].".".$ext;
			//nombre del propietario
			$idOwner = $file2->getPropietario();
			$nameOwner = $this->fileMapper->getPropietario($idOwner);
			//hacer ruta
			$ruta = "./Folders/$nameOwner/$fileName";

		$this->fileMapper->delete($file,$ruta);

		if ($padre ==NULL) {
			$this->view->redirect("folders","showall");
		}else{
				$idFather = "idFather=".$padre;
				$this->view->redirect("folders","showall",$idFather);
		}
		}else{
			$this->view->redirect("folders", "showall");
		}

	}

	public function checkShareFile(){
		$userId = $this->view->getVariable("userId");
		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}

		if (isset($_GET["idFile"])) {
			$idFichero = $_GET['idFile'];
			$existsFile = $this->fileMapper->existsFile($idFichero);
			if ($existsFile == false) {
				$this->view->setFlashDanger("File doesnt exist!");
				$this->view->redirect("folders", "showall");
			}
			//Es mi fichero?
			$ownFile = $this->fileMapper->isMyFile($idFichero, $userId);
			if ($ownFile == false) {
				$this->view->setFlashDanger("You have not permissions to access");
				$this->view->redirect("folders", "showall");
			}
			$file = $this->fileMapper->getFicheroId($_GET["idFile"]);
		if($file->getCompartido() == "NO"){
			$file->setCompartido("SI");
			$this->fileMapper->setCompartido($file);
		}

		$padre = $file->getPadre();

		if ($padre ==NULL) {
			$this->view->redirect("folders","showall");
		}else{
				$idFather = "idFather=".$padre;
				$this->view->redirect("folders","showall",$idFather);
		}
		}else{
			$this->view->redirect("folders", "showall");
		}

		

		

	}

	public function shareFile(){
		
		
		if (isset($_GET["idFile"])){
		
		$file = $this->fileMapper->getFichero($_GET["idFile"]);
		
		
		if($file != NULL){
			if($file->getCompartido() == "SI"){

				$tipo = $file->getFormato();

				//conseguir nombre fichero
				$name = $file->getNombre();
				//hacer split
				$partes = preg_split("/\./",$name);
				$size = sizeof($partes);
				$ext = $partes[$size-1];
				//nombre con el que esta guardado
				$fileName = $file->getUUID().".".$ext;
				//nombre del propietario
				$idOwner = $file->getPropietario();
				$nameOwner = $this->fileMapper->getPropietario($idOwner);
				//hacer ruta
				$ruta = "./Folders/$nameOwner/$fileName";
				
				$this->fileMapper->download($tipo,$fileName,$ruta,$name);

			}else{
				$this->view->setFlashDanger("File doesnt share!");
				$this->view->redirect("folders", "showall");
			}
		}else{
			$this->view->setFlashDanger("File doesnt exist!");
			$this->view->redirect("folders", "showall");

		}}
		else{
			$this->view->redirect("folders", "showall");
		}
		

	}



}

