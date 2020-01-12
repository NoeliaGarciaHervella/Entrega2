<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

	<div class="container">

		<div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto mr-auto mt-5 mb-5">
			<form class="shadow-lg p-3 bg-white rounded" method="POST" action="./index.php?controller=users&action=register">

				<div class="row">
					<div class="col-12 mr-auto ml-auto mb-4 mt-4">
						<h3 class="h3SingUp"><?= i18n("Create your account")?></h3>
						<div class="spanFolderIcon col-7  mx-auto">
							<i class="fa fa-folder-open folderIcon"></i>
						</div>
					</div>
				</div>


				<div class="row">
					<!-- Introducir nombre -->
					<div class="form-group col-12 mr-auto ml-auto mb-4 ">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="spanIcon input-group-text">
									<i class="material-icons">person</i>
								</span>
							</div>
							<input class="form-control inputIcon" type="text" name="name" placeholder="<?= i18n("Name")?>">
							<?php if(isset($errors["username"])) { ?> 
									<div class="alert alert-danger" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<?=i18n($errors["username"])?>
									</div>
								<?php } 
							unset($errors["username"]); ?>
						</div>
					</div>
				</div>


				<div class="row">
					<!-- Introducir correo -->
					<div class="form-group col-12 mr-auto ml-auto mb-4 ">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class=" spanIcon input-group-text">
									<i class="material-icons">email</i>
								</span>
							</div>
							<input class="form-control inputIcon" type="email" name="email" placeholder="<?= i18n("Email")?>">
							<?php if(isset($errors["email"])) { ?> 
								<div class="alert alert-danger" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<?=i18n($errors["email"])?>
								</div>
                                <?php } ?>
						</div>
					</div>
				</div>


				<div class="row">
					<!-- Introducir contraseña -->
					<div class="form-group col-12 mr-auto ml-auto mb-4 ">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="spanIcon input-group-text">
									<i class="material-icons">lock</i>
								</span>
							</div>
							<input class="form-control  inputIcon" type="password" name="passwd" placeholder="<?= i18n("Password")?>">
							<?php if(isset($errors["passwd"])) { ?> 
									<div class="alert alert-danger" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<?=i18n($errors["passwd"])?>
									</div>
                                <?php } ?>
						</div>
						<small class="form-text text-muted"><?= i18n("Min 6 characters")?></small>
					</div>
				</div>


				<div class="row">
					<!-- BOTONES -->
					<div class="form-group col-11 ml-auto mr-auto">
						<div class="container-login100-form-btn mb-5">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn ">
								<?= i18n("Next")?>
								</button>
							</div>
						</div>
						<small class="form-text text-muted redirectSingIn"><?= i18n("Do you already have an account?")?><a href="./index.php?controller=users&action=login"
								class="text-muted"><?= i18n("Sign in")?></a></small>
					</div>
				</div>
			</form>
		</div>
	</div>
