<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Admins/
 * NAME: index.php
 */

?>
<!------------------------------------------------------------------------------infos gestionAdmins------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && $_SESSION['mais qui cela peut-il bien être ?'] === "Fabien"){ ?>     
    <br/>
    <?php if(isset($_SESSION['info'])){ ?>
        <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
    <?php } else if(isset($_SESSION['infoSave'])){ ?>    
        <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
    <?php } ?>
    <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span></div>
    <br/>
<!------------------------------------------------------------------------------formulaire gestionAdmins------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="container" >
        <form class="saveForm" id="saveFormAdm" action="#" method="POST" enctype="multipart/form-data" >
            <?php                       
            if(isset($detailsAdm)) {
                $id = $detailsAdm["id_admin"];
                $nom = $detailsAdm["nom"];
                $identifiant = $detailsAdm["identifiant"];
                $mot_de_passe = $detailsAdm["mot_de_passe"];
            } else {
                $id = $nom = $identifiant = $mot_de_passe = "";
            }
            ?>
            <input type="hidden" name="action" value="save" >
            <input type="hidden" name="id_admin" value="<?php echo $id; ?>" >
            <div class="row" >
                <label class="col-md-2" for="idNom" >Nom:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idNom" name="nom" required value="<?php echo $nom; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idIdent" >Identifiant:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idIdent" name="identifiant" required value="<?php echo $identifiant; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idMdp" >Mot de passe:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idMdp" name="mot_de_passe" required value="<?php echo $mot_de_passe; ?>" ></div>
            </div><br/>           
            <div class="row" >
                <div class="col-md-2" ></div><div class="col-md-10" ><input class="btn btn-sm btn-danger" type="submit" value="save" ></div>
            </div>
        </form>    
        <br/>
<!------------------------------------------------------------------------------reset formulaire--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <ul>
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <span class="glyphicon glyphicon-plus trash" aria-hidden="true" ></span><input class="logIn adm" type="submit" value="Ajouter un administrateur" >
                </form>
            </li>
            <br/>
<!------------------------------------------------------------------------------recherche admin(s)------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <h4>Recherche:</h4>
                    <input type="hidden" name="action" value="search" >
                    <div class="row" >
                        <div class="col-md-2" >
                            <select class="form-control fieldSel" name="field" >
                                <option value="nom">par nom</option>
                                <option value="identifiant">par identifiant</option>
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
                        <form class="col-md-2" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="details" >
                            <input type="hidden" name="id_admin" value="<?php echo $result["id_admin"]; ?>" >
                            <input class="logIn adm" type="submit" value="<?php echo $result["nom"]; ?>" >
                        </form>
                        <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="archive" >
                            <input type="hidden" name="id_admin" value="<?php echo $result["id_admin"]; ?>" >
                            <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                        </form>
                    </div>
                </li>                               
            <?php } ?>                
                <hr><br/>
        <?php } ?>
<!------------------------------------------------------------------------------liste admins------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <?php foreach ($admins as $admin){ ?>          
            <li>
                <div class="row" >
                    <form class="col-md-2" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="details" >
                        <input type="hidden" name="id_admin" value="<?php echo $admin["id_admin"]; ?>" >
                        <input class="logIn adm" type="submit" value="<?php echo $admin["nom"]; ?>" >
                    </form>
                    <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="archive" >
                        <input type="hidden" name="id_admin" value="<?php echo $admin["id_admin"]; ?>" >
                        <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                    </form>
                </div>
            </li> 
        <?php } ?>               
        </ul>
    </div>
<!------------------------------------------------------------------------------access denied------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php } else { ?>
        <META HTTP-EQUIV="Refresh" Content="0; URL=<?php echo WEBROOT; ?>cassettes">  
<?php }



