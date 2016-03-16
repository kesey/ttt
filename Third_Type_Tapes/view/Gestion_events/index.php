<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Gestion_events/
 * NAME: index.php
 */

?>
<!------------------------------------------------------------------------------infos gestionEvents---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && in_array($_SESSION['mais qui cela peut-il bien être ?'], $admins, TRUE)){ ?>
    <br/>
    <?php if(isset($_SESSION['info'])){ ?>
        <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
    <?php } else if(isset($_SESSION['infoSave'])){ ?>    
        <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
    <?php } ?>
    <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span></div>
    <br/>
<!------------------------------------------------------------------------------formulaire gestionEvents----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="container" >
        <form class="saveForm" id="saveFormEvt" action="#" method="POST" enctype="multipart/form-data" >
            <?php                       
            if(isset($detailsEvt)) {
                $id = $detailsEvt["id_event"];
                $titre = $detailsEvt["titre_event"];
                $date = $detailsEvt["date_event"];
                $lieu = $detailsEvt["lieu"];
                $description = $detailsEvt["description_event"];
                $image = $detailsEvt["image_event"];
            } else {
                $id = $titre = $date = $lieu = $description = $image = "";
            }
            ?>
            <input type="hidden" name="action" value="save" >
            <input type="hidden" name="id_event" value="<?php echo $id; ?>" >
            <div class="row" >
                <label class="col-md-2" for="idTitre" >Titre:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idTitre" name="titre_event" required value="<?php echo $titre; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idDate" >Date:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idDate" name="date_event" placeholder="jj-mm-aaaa" required value="<?php echo $date; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idLieu" >Adresse&nbsp;lieu&nbsp;(facultatif):&nbsp;</label><div class="col-md-10" ><textarea class="form-control" id="idLieu" name="lieu" ><?php echo $lieu; ?></textarea></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idDescription" >Description:&nbsp;</label><div class="col-md-10" ><textarea class="form-control mceEditor" id="idDescription" name="description_event" ><?php echo $description; ?></textarea></div>
            </div><br/>            
            <div class="imageGesEvt labImg" ><label>Image:&nbsp;</label></div>
            <?php if($image){ ?>
                <div class="imageGesEvt" ><img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/event/<?php echo $image; ?>" title="image_event" alt="image -> <?php echo $date; ?> // <?php echo $titre; ?>" ></div>&nbsp;
                <input type="hidden" id ="idImage_event" name="image_event" value="<?php echo $image; ?>" >
            <?php } ?>
            <div class="imageGesEvt" >
                <div class="row">
                    <div class="col-md-8" >
                        <input type="file" class="parcourir" id ="idNew_image_event" name="new_image_event" >
                    </div>
                    <div class="col-md-4" >
                        <input type="button" class="clear_file" value="clear" >
                    </div>
                </div>
            </div>
            <br/><br/>            
            <div class="row" >
                <div class="col-md-2" ></div><div class="col-md-10" ><input class="btn btn-sm btn-danger" type="submit" value="save" ></div>
            </div>
        </form>    
        <br/>
<!------------------------------------------------------------------------------reset formulaire------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <ul>
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <span class="glyphicon glyphicon-plus trash" aria-hidden="true" ></span><input class="logIn adm" type="submit" value="Ajouter un event" >
                </form>
            </li>
            <br/>
<!------------------------------------------------------------------------------recherche event(s)----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <h4>Recherche:</h4>
                    <input type="hidden" name="action" value="search" >
                    <div class="row" >
                        <div class="col-md-2" >
                            <select class="form-control fieldSel" name="field" >
                                <option value="date_event">par date</option>
                                <option value="titre_event">par titre</option>
                                <option value="description_event">par description</option>
                                <option value="lieu">par lieu</option>
                            </select>
                        </div>
                        <div class="col-md-10" >
                            <input type="search" class="form-control" name="recherche" > 
                            <br/>
                            <input class="btn btn-sm btn-primary" type="submit" value="Rechercher" >
                        </div>
                    </div>
                </form>
            </li>
            <br/>
        <?php if(isset($searchResults) && !empty($searchResults)){ ?>
            <hr>
            <h4>Resultat(s) recherche:</h4>
            <?php foreach ($searchResults as $result){ ?>
                <li>
                    <div class="row" >
                        <form class="col-md-4" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="details" >
                            <input type="hidden" name="id_event" value="<?php echo $result["id_event"]; ?>" >
                            <input class="logIn adm" type="submit" value="<?php echo $result["date_event"]; ?> // <?php echo $result["titre_event"]; ?>" >
                        </form>
                        <form class="col-md-8" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="archive" >
                            <input type="hidden" name="id_event" value="<?php echo $result["id_event"]; ?>" >
                            <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                        </form>
                    </div>
                </li>                               
            <?php } ?>                
                <hr><br/>
        <?php } ?>
<!------------------------------------------------------------------------------liste events----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <?php foreach ($events as $event){ ?>          
            <li>
                <div class="row" >
                    <form class="col-md-4" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="details" >
                        <input type="hidden" name="id_event" value="<?php echo $event["id_event"]; ?>" >
                        <input class="logIn adm" type="submit" value="<?php echo $event["date_event"]; ?> // <?php echo $event["titre_event"]; ?>" >
                    </form>
                    <form class="col-md-8" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="archive" >
                        <input type="hidden" name="id_event" value="<?php echo $event["id_event"]; ?>" >
                        <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                    </form>
                </div>
            </li> 
        <?php } ?>               
        </ul>
    </div>
<!------------------------------------------------------------------------------access denied---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php } else { ?>
        <META HTTP-EQUIV="Refresh" Content="0; URL=<?php echo WEBROOT; ?>cassettes">  
<?php }
