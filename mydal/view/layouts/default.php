<?php


$view = ViewManager::getInstance(); 
$currentuser = $view->getVariable("currentusername");
$padre = $view->getVariable("padre");
                
if($padre == NULL){
    $ruta ="./index.php?controller=folders&action=previous";
}else{
    $ruta ="./index.php?controller=folders&action=previous&idFolder=".$padre;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <title>MyDal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--IMPORTAMOS BOOTSTRUP-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/mydal/resources/css/style.css" type="text/css">
    <script type="text/javascript" src="/mydal/resources/js/scripts.js"></script>

    <!-- Link para los iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Link para las fuentes -->
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <script src="index.php?controller=language&action=i18njs"></script>

</head>

<body onclick="quitar();" >
    <!--oncontextmenu="return false"-->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">

        <!--Logotipo -->
        <a class=" logotipo ml-4 navbar-brand" href="./index.php?controller=folders&action=showall">
            <span class="menu-collapsed"><i class="fa fa-folder-open"></i></span>
            <span class="menu-collapsed">Mydal</span>
        </a>


        <!--Boton que se hace visible al redimensionar-->
        <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse"
            data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--Menú del boton que aparece al redimensionarse -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <!-- MENU DEL USUARIO -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenuLogin" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="menu-collapsed mr-2"><i class="fa fa-user"></i></span>
                        <span class="menu-collapsed"><?= $currentuser ?></span>
                    </a>

                    <!-- SUBMENU DEL USUARIO -->
                    <div class="dropdown-menu" aria-labelledby="smallerscreenmenuLogin">
                        <a class="dropdown-item"
                            href="./index.php?controller=users&action=logout"><?= i18n("Sign out")?></a>
                    </div>
                </li>


                <!-- MENU DEL IDIOMA -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenuIdioma" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="menu-collapsed mr-2"><i class="fa fa-globe"></i></span>
                        <span class="menu-collapsed"><?= i18n("Language")?></span>
                    </a>

                    <!-- SUBMENU DEL IDIOMA -->
                    <div class="dropdown-menu" aria-labelledby="smallerscreenmenuIdioma">
                        <a class="dropdown-item"
                            href="index.php?controller=language&amp;action=change&amp;lang=en"><?= i18n("English")?></a>
                        <a class="dropdown-item"
                            href="index.php?controller=language&amp;action=change&amp;lang=es"><?= i18n("Spanish")?></a>
                    </div>
                </li>


                <!-- OPCION DE CREAR CARPETA -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalCreateFolder">
                        <span class="menu-collapsed mr-2"><i class="fa fa-folder"></i></span>
                        <span class="menu-collapsed"><?= i18n("Create folder")?></span>
                    </a>
                </li>


                <!-- OPCION DE CREAR Fichero -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalUploadFile">
                        <span class="menu-collapsed mr-2"><i class="fa fa-file"></i></span>
                        <span class="menu-collapsed"><?= i18n("Upload file")?></span>
                    </a>
                </li>

                <!-- OPCION DE CREAR Atrás -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link" href="<?=$ruta?>">
                        <span class="menu-collapsed mr-2"><i class="fa fa-angle-double-left"></i></span>
                        <span class="menu-collapsed"><?= i18n("Previous folder")?></span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- BOTON LOGIN MARGEN SUPERIOR DERECHO-->
        <ul class=" d-none d-md-block navbar-nav ml-5 mt-2 mt-lg-0 ">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="smallerscreenmenuLogin" aria-haspopup="true" aria-expanded="false"
                    data-toggle="dropdown">
                    <span class="menu-collapsed mr-2"><i class="fa fa-user"></i></span>
                    <span class="menu-collapsed"><?= $currentuser ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="smallerscreenmenuLogin">
                    <a class="dropdown-item" href="./index.php?controller=users&action=logout"><?= i18n("Sign out")?></a>
                </div>
            </li>
        </ul>
    </nav>


    <!-- MENUDE LA IZQUIERDA -->
    <div class="row" id="body-row">
        <div id="sidebar-container" class="sidebar-expanded d-none d-md-block ">
            <ul class="list-group">

                <!-- MENU DEL IDIOMA -->
                <a href="#submenuIdioma" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-globe fa-fw mr-3"></span>
                        <span class="menu-collapsed"><?= i18n("Language")?></span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>

                <!-- SUBMENU DEL IDIOMA -->
                <div id='submenuIdioma' class="collapse sidebar-submenu">
                    <a href="index.php?controller=language&amp;action=change&amp;lang=en"
                        class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><?= i18n("English")?></span>
                    </a>
                    <a href="index.php?controller=language&amp;action=change&amp;lang=es"
                        class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><?= i18n("Spanish")?></span>
                    </a>
                </div>

                <!-- OPCION DE CARPETA -->
                <a href="#" class="bg-dark list-group-item list-group-item-action" data-toggle="modal"
                    data-target="#modalCreateFolder">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-folder fa-fw mr-3"></span>
                        <span class="menu-collapsed"><?= i18n("Create folder")?></span>
                    </div>
                </a>

                <!-- MENU DE FICHERO -->
                <a href="" class="bg-dark list-group-item list-group-item-action" data-toggle="modal"
                    data-target="#modalUploadFile">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-file fa-fw mr-3"></span>
                        <span class="menu-collapsed"><?= i18n("Upload file")?></span>
                    </div>
                </a>



                <!-- MENU DE atras -->
                <a href="<?=$ruta?>" class="bg-dark list-group-item list-group-item-action" >
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-angle-double-left fa-fw mr-3"></span>
                        <span class="menu-collapsed"><?= i18n("Previous folder")?></span>
                    </div>
                </a>




                

            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->


        <!-- Button trigger modal -->
        <div class="col">

            <?php $message = $view->popFlash(); ?>
            <?php $errors = $view->popFlashDanger(); ?>
            <?php if (!empty($message)){ ?>
            <div class="alert alert-success text-center" style="width:100%; height:7%;" id="success-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?=i18n($message)?>
            </div>
            <?php }else if(!empty($errors)){ ?>
            <div class="alert alert-danger text-center" style="width:100%; height:7%;" id="success-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?=i18n($errors)?>
            </div>
            <?php } ?>

            <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
        </div>

    </div><!-- body-row END -->


    <!-- MODAL CREAR CARPETA-->
    <div class=" modal fade" id="modalCreateFolder" tabindex="-1" role="dialog" aria-labelledby="createFolderTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="col-9 px-0 mx-auto modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFolderTitle"><?= i18n("Create a folder")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- SI NO HAY ID DEL PADRE SE CREA EN LA CARPETA PRINCIPAL-->
                <?php if (!isset($_GET["idFather"])){?>

                <form method="POST" action="index.php?controller=folders&action=addFolder">

                <!-- SI HAY ID DEL PADRE SE CREA DENTRO DE ESTE -->
                <?php }else{ 
                $idFather ="index.php?controller=folders&action=addFolder&idFather=".$_GET["idFather"]; ?>
                <form method="POST" action="<?= $idFather ?>">
                <?php } ?>
                    <div class="mx-auto cuerpoModal cuerpoModal modal-body">
                        <p><?= i18n("Insert folders name")?></p>
                        <div class="col-10 mx-auto"><input class="inputModal" name="name" type="text" class="col-12" placeholder="<?= i18n("Name")?>" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= i18n("Close")?></button>
                        <button type="submit" class="btn btn-primary"><?= i18n("Create folder")?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- MODAL SUBIR FICEHRO -->
    <div class=" modal fade" id="modalUploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="col-9 px-0 mx-auto modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileTitle"><?= i18n("Upload a file")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <!-- SI NO HAY ID DEL PADRE SE CREA EN LA CARPETA PRINCIPAL-->
                <?php if (!isset($_GET["idFather"])){?>

                <form method="POST" action="index.php?controller=files&action=addFile" enctype="multipart/form-data">

                <!-- SI HAY ID DEL PADRE SE CREA DENTRO DE ESTE -->
                <?php }else{ 
                $idFather ="index.php?controller=files&action=addFile&idFather=".$_GET["idFather"]; ?>
                <form method="POST" action="<?= $idFather ?>" enctype="multipart/form-data">
                <?php } ?>
                
                    <div class="mx-auto cuerpoModal modal-body ">
                        <p><?= i18n("Select file")?></p>
                        <div class="col-10 mx-auto"><input  name="file" type="file" class="col-12" placeholder="" required></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= i18n("Close")?></button>
                        <button type="submit" class="btn btn-primary"><?= i18n("Upload file")?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $(".alert-success").alert('close');
            }, 4000);
            setTimeout(function () {
                $(".alert-danger").alert('close');
            }, 4000);
        });
    </script>

</body>

</html>