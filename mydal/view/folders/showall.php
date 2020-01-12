<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "ShowAll");
$errors = $view->getVariable("errors");
$currentuser = $view->getVariable("currentusername");
$folders = $view->getVariable("folders");
$files = $view->getVariable("files");


?>



<!-- MAIN -->

<?php if(count($folders) == 0 && count($files) == 0){ ?>
    <div class="alert alert-warning text-center" style="width:100%; height:7%;" id="success-warning" role="alert">

        <?=i18n("There are not folders and files")?>
    </div>
<?php } ?>
<div class="row">
    <?php foreach($folders as $folder):
                    $idCarpeta = "opcionescarpeta".$folder->getIdCarpeta(); ?>

    <div class="col-4 col-sm-3 col-md-3 col-lg-2 col-xl-2 mt-3">
        <div id="<?= $folder->getIdCarpeta()?>" class="card carpeta" onmousedown="mostrarCarpeta(event,<?= $folder->getIdCarpeta()?>);">
            <img src="./resources/img/folder.jpg" class="fold card-img-top" alt="<?= $folder->getNombre()?>">
            <div class="pl-0 pr-0 pt-0 pb-0 card-body titulo">
                <p class="card-title"><?= $folder->getNombre() ?></p>
            </div>
        </div>
        <nav id="<?= $idCarpeta ?>" class="opcionescarpeta">
            <div class="menu_simple">
                <ul>
                    <li><a href="#" class="clickEliminarCarpeta" data-toggle="modal" data-target="#modalDeleteFolder"><?= i18n("Delete")?></a></li>
                     
                </ul>
            </div>
        </nav>
    </div>
    <?php endforeach; ?>

    
    <?php if(count($files) > 0){ 
            foreach($files as $file): 
            $idFichero = "opcionesfichero".$file->getIdFichero(); 
            $descarga = "index.php?controller=files&action=download&idFile=".$file->getIdFichero()?>
            <div class="col-4 col-sm-3 col-md-3 col-lg-2 col-xl-2 mt-3">
                <div id="<?= $file->getIdFichero()?>" class="card" onmousedown="mostrarFichero(event,<?= $file->getIdFichero()?>);">
                    <img src="./resources/img/file.png" class="fold card-img-top" alt="<?= $file->getNombre()?>">
                    <div class="pl-0 pr-0 pt-0 pb-0 card-body titulo">
                        <p class="card-title"><?= substr( $file->getNombre(), 0,10); ?>...</p>
                    </div>
                </div>
                <nav id="<?= $idFichero ?>" class="opcionesfichero">
                    <div class="menu_simple">
                        <ul>
                            <li><a href="#" id="<?= $file->getUUID()?>" class="clickCompartirFichero" data-toggle="modal" data-target="#modalShareFile"><?= i18n("Share")?></a></li>
                            <li><a href="<?="index.php?controller=files&action=downloadFile&idFile=".$file->getIdFichero() ?>" ><?= i18n("Download")?></a></li>
                            <li><a href="#" class="clickEliminarFichero" data-toggle="modal" data-target="#modalDeleteFile"><?= i18n("Delete")?></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        <?php endforeach; 
    } else{ ?> 
        <!-- <span id="noFolders" class="hide">No existe ningún elemento</span> -->
    <?php }?>


</div>


 <!-- MODAL ELIMINAR CARPETA-->
 <div class=" modal fade" id="modalDeleteFolder" tabindex="-1" role="dialog" aria-labelledby="titleModalDelete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="col-9 px-0 mx-auto modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete"><?= i18n("Delete folder")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  
                <div>
                    <div class="mx-auto px-0 cuerpoModal modal-body ">
                        <p><?= i18n("Do you want to remove this folder?")?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal"><?= i18n("Close")?></button>
                        <button type="submit" class="eliminarCarpeta btn btn-danger"><?= i18n("Delete folder")?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    


    <!-- MODAL ELIMINAR FICHERO -->
    <div class=" modal fade" id="modalDeleteFile" tabindex="-1" role="dialog" aria-labelledby="deleteFileTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="col-9 px-0 mx-auto modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFileTitle"><?= i18n("Delete file")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <div class="mx-auto cuerpoModal modal-body ">
                        <p><?= i18n("Do you want to remove this file?")?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= i18n("Close")?></button>
                        <button type="submit" class="eliminarFichero btn btn-danger"><?= i18n("Delete file")?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL COMPARTIR FICEHRO -->
    <div class=" modal fade" id="modalShareFile" tabindex="-1" role="dialog" aria-labelledby="shareFileTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="col-12 px-0 mx-auto modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareFileTitle"><?= i18n("Share file")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <div id="rutaCompartirFichero" class="mx-auto cuerpoModal modal-body ">
                        <p id="enlace"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= i18n("Close")?></button>
                        <button type="button" class="compartirFichero btn btn-primary" data-dismiss="modal"><?= i18n("Share file")?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>






 


