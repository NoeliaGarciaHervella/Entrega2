<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
?>


    <div class="container login">
        <div class=" col-sm-12  col-md-6 col-lg-5 col-xl-4 ml-auto mr-auto mt-5 mb-5">
            <form class=" shadow-lg p-3 bg-white rounded" method="POST" action="./index.php?controller=users&action=login">
                <div class="row">
                    <div class="col-12 mr-auto ml-auto mb-4 mt-4">
                        <h3 class="h3SingUp"><?= i18n("Welcome")?></h3>
                        <div class="spanFolderIcon col-7  mx-auto">
                            <i class="fa fa-folder-open folderIcon"></i>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Introducir correo -->
                    <div class="form-group col-12 mr-auto ml-auto mb-5 ">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class=" spanIcon input-group-text">
                                    <i class="material-icons">email</i>
                                </span>
                            </div>
                            <input class="form-control inputIcon" type="email" name="email" placeholder="<?= i18n("Email")?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Introducir contraseña -->
                    <div class="form-group col-12 mr-auto ml-auto mb-5 ">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="spanIcon input-group-text">
                                    <i class="material-icons">lock</i>
                                </span>
                            </div>
                            <input class=" form-control  inputIcon" type="password" name="passwd"
                                placeholder="<?= i18n("Password")?>">
                        </div>
                        <small class="form-text text-muted"><?= i18n("Min 6 characters")?></small>
                    </div>
                </div>
                <div class="col">

            <?php $message = $view->popFlash(); ?>
            <?php $errors = $view->popFlashDanger();?>
            <?php if (!empty($message)){ ?>
                    <div class="alert alert-success text-center" style="width:100%; height:7%;" id="success-alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?=i18n($message)?>
                    </div>
            <?php } else if (!empty($errors)){ ?>
                    <div class="alert alert-danger text-center" style="width:100%; height:7%;" id="success-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?=i18n($errors)?>
                    </div>
            <?php } ?>
                <div class="row">
                    <!-- BOTONES -->
                    <div class="form-group col-11 ml-auto mr-auto">
                        <div class="container-login100-form-btn mb-5">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn ">
                                <?= i18n("Sign in")?>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted redirectSingIn"><?= i18n("You dont have an account?")?><a href="./index.php?controller=users&action=register"
                                class="text-muted"><?= i18n("Create account")?></a></small>
                        
                        <div class="navbar-nav mr-auto ">
                            <div class="nav-item dropdown">
                                <a class="nav-link col-1 mx-auto" href="#" id="smallerscreenmenuIdioma" aria-haspopup="true" aria-expanded="false"
                                data-toggle="dropdown">
                                        <span class="menu-collapsed mr-2"><i class="fa fa-globe"></i></span>
                                        
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="smallerscreenmenuIdioma">
                                    <a class="dropdown-item" href="index.php?controller=language&amp;action=change&amp;lang=en"><?= i18n("English")?></a>
                                    <a class="dropdown-item" href="index.php?controller=language&amp;action=change&amp;lang=es"><?= i18n("Spanish")?></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>


