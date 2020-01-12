<?php

require_once(__DIR__."/../core/ValidationException.php");


class User {

	
	private $username;

	private $email;

	private $passwd;

	public function __construct($username=NULL, $passwd=NULL, $email=NULL) {
		$this->username = $username;
		$this->passwd = $passwd;
		$this->email = $email;
	}


	public function getUsername() {
		return $this->username;
	}


	public function setUsername($username) {
		$this->username = $username;
	}


	public function getEmail() {
		return $this->email;
	}


	public function setEmail($email) {
		$this->email = $email;
	}


	public function getPasswd() {
		return $this->passwd;
	}

	public function setPassword($passwd) {
		$this->passwd = $passwd;
	}

	public function checkIsValidForRegister() {
		$errors = array();
		if (strlen($this->username) < 3) {
			$errors["username"] = "They must be at least 3 letters";
		}
		else if (strlen($this->username) > 256) {
			$errors["username"] = "Name is too long";
		}
		else if (strlen($this->passwd) < 6) {
			$errors["passwd"] = "They must be at least 6 letters";
		}
		else if (strlen($this->passwd) > 256) {
			$errors["passwd"] = "Password is too long";
		}
		else if (strlen($this->email) > 256) {
			$errors["email"] = "Email is too long";
		}
		else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errors["email"] = "Invalid email format";
		  }
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "User is not valid");
		}
	}
}
