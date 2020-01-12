<?php


require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/Folder.php");
require_once(__DIR__."/../model/FolderMapper.php");
require_once(__DIR__."/../model/File.php");
require_once(__DIR__."/../model/FileMapper.php");
require_once(__DIR__."/../controller/BaseController.php");


class FoldersController extends BaseController {


	private $folderMapper;
	private $filesMapper;

	public function __construct() {
		$this->folderMapper = new FolderMapper();
		parent::__construct();

		$this->filesMapper = new FileMapper();
		parent::__construct();
	}

    public function showall() {
		$userId = $this->view->getVariable("userId");
		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}

		if (!isset($_GET["idFather"])){
				//$folders = $this->folderMapper->findAllByUserID($userId);
				$folders = $this->folderMapper->findAllFolderByUserID($userId);
				$this->view->setVariable("folders", $folders);
				//MOSTRAR FICHEROS
				$files = $this->filesMapper->findAllFileByUserID($userId);
				$this->view->setVariable("files", $files);
				$this->view->setVariable("padre", NULL);

		}else {
			
			//Existe la carpeta?
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

			$subfolders = $this->folderMapper->findAllSubFolderByUserID($idCarpeta, $userId);
			$this->view->setVariable("folders", $subfolders);

			$subfiles = $this->filesMapper->findAllSubFilesByUserID($idCarpeta, $userId);
			$this->view->setVariable("files", $subfiles);
			$this->view->setVariable("padre", $idCarpeta);
		}
		$this->view->render("folders", "showall");
	}	

	public function addFolder(){
		
		$folder = new Folder();
		$userId = $this->view->getVariable("userId");
		
		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		
		$folder->setNombre($_POST["name"]);
		$folder->setPropietario($userId);

		if (isset($_GET["idFather"])) {	
			$folder->setPadre((int)$_GET["idFather"]);
			//Existe la carpeta?
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
			$folder->checkIsValidForCreate();
			$this->folderMapper->save($folder);
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

	public function deleteFolder(){
		$folder = new Folder();
		$userId = $this->view->getVariable("userId");

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		
		if(isset($_GET['idFolder'])){

		$idCarpeta = $_GET['idFolder'];
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

		$folder->setIdCarpeta($idCarpeta);
		$folder->setPropietario($userId);
		
		$folder2 = $this->folderMapper->getCarpeta($idCarpeta);
		$padre = $folder2->getPadre();

		$this->folderMapper->delete($folder);

		if ($padre ==NULL) {
			$this->view->redirect("folders","showall");
		}else{
				$idFather = "idFather=".$padre;
				$this->view->redirect("folders","showall",$idFather);
		}
		}else{
			$this->view->setFlashDanger("Folder ID is required");
			$this->view->redirect("folders", "showall");
		}

		
	}

	public function previous(){
		$userId = $this->view->getVariable("userId");
		$idCarpeta = $_GET['idFolder'];
		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger("You must be logged");
			$this->view->redirect("users", "login");
		}
		if(isset($_GET['idFolder'])){

			$idCarpeta = $_GET['idFolder'];
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
			
			$folder = $this->folderMapper->getCarpeta($_GET['idFolder']);
			$idFather = $folder->getPadre();
			if($idFather == NULL){
				$this->view->redirect("folders","showall");
			}else{
				$father ="idFather=".$idFather;
				$this->view->redirect("folders","showall",$father);
			}
			
			
			
		}else{
			$this->view->redirect("folders","showall");
		}
		
	}


	


}




