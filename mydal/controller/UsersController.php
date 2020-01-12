<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class UsersController extends BaseController {

	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();


		$this->view->setLayout("welcome");
	}

	
	public function login() {
		if (isset($_POST["email"])){ // reaching via HTTP Post...
			//process login form
			if ($this->userMapper->isValidUser($_POST["email"], $_POST["passwd"])) {

				$user = $this->userMapper->findByEmailName($_POST["email"]);
				$id = $this->userMapper->findByEmailID($_POST["email"]);
				$_SESSION["currentuser"]= $user->getUsername();
				$_SESSION["userid"]= $id;
				
				//$_SESSION["useremail"]= $id;

				$_SESSION["useremail"]=$_POST["email"];

				// send user to the restricted area (HTTP 302 code)

				$this->view->redirect("folders", "showall");

			}else{

				$this->view->setFlashDanger("Username or password is incorrect");
			}
		}

		// render the view (/view/users/login.php)
		$this->view->render("users", "login");
	}


	public function register() {

		$user = new User();

		if (isset($_POST["email"])){ // reaching via HTTP Post...

			// populate the User object with data form the form
			$user->setUsername($_POST["name"]);
			$user->setEmail($_POST["email"]);
			$user->setPassword($_POST["passwd"]);

			try{
				$user->checkIsValidForRegister(); // if it fails, ValidationException

				// check if user exists in the database
				if (!$this->userMapper->usernameExists($_POST["email"])){

					// save the User object into the database
					$this->userMapper->save($user);

					$this->view->setFlash("Username successfully added. Please login now");

					// perform the redirection. More or less:
					// header("Location: index.php?controller=users&action=login")
					// die();
					$this->view->redirect("users","login");
				} else {
					$errors = array();
					$errors["email"] = "Email already exists ";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the User object visible to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/users/register.php)
		$this->view->render("users", "register");

	}


	public function logout() {
		session_destroy();

		// perform a redirection. More or less:
		// header("Location: index.php?controller=users&action=login")
		// die();
		$this->view->redirect("users", "login");

	}

}
