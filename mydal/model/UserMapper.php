<?php


require_once(__DIR__."/../core/PDOConnection.php");

class UserMapper {

	
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	
	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?)");
		
		$stmt->execute(array(0,$user->getUsername(), $user->getPasswd(), $user->getEmail()));
		$directorio = './folders/'. $user->getEmail();
		mkdir($directorio,0777,true);
		/*public function save(user) {
			$stmt = $this->db->prepare("INSERT INTO USUARIO(USERNAME, PASSWORD, EMAIL) values (?,?,?)");
			$stmt->execute(array($user->getUsername(), $user->getPasswd(), $user->getEmail()));
			return $this->db->lastInsertId(); ESTO ES NECESARIO HACERLO
		} */
	}

	
	public function usernameExists($email) {
		$stmt = $this->db->prepare("SELECT count(USERNAME) FROM usuario where EMAIL=?");
		$stmt->execute(array($email));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	public function isValidUser($email, $passwd) {
		$stmt = $this->db->prepare("SELECT count(USERNAME) FROM usuario where EMAIL=? and PASSWD=?");
		$stmt->execute(array($email, $passwd));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	public function findByEmailName($email) {
		$stmt = $this->db->prepare("SELECT USERNAME FROM usuario where EMAIL=?");
		$stmt->execute(array($email));
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if($user != null) {
			return new User(
			$user["USERNAME"]
			);
		} else {
			return NULL;
		}
	}

	public function findByEmailID($email) {
		$stmt = $this->db->prepare("SELECT ID_USUARIO FROM usuario where EMAIL=?");
		$stmt->execute(array($email));
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if($user != null) {
			return $user["ID_USUARIO"];
		} else {
			return NULL;
		}
	}


}
