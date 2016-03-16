<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Clients/
 * NAME: index.php
 */

?>
<!------------------------------------------------------------------------------infos gestionClients----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && in_array($_SESSION['mais qui cela peut-il bien être ?'], $admins, TRUE)){ ?>
    <br/>
    <?php if(isset($_SESSION['info'])){ ?>
        <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
    <?php } else if(isset($_SESSION['infoSave'])){ ?>    
        <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
    <?php } ?>
    <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span></div>
    <br/>
<!------------------------------------------------------------------------------formulaire gestionClients------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
    <div class="container" >
        <form class="saveForm" id="saveFormClient" action="#" method="POST" enctype="multipart/form-data" >
            <?php                       
            if(isset($detailsClient)) {
                $id = $detailsClient["id_client"];
                $nom = $detailsClient["nom_client"];
                $mail = $detailsClient["mail_client"];
                $adresse = $detailsClient["adresse_client"];
            } else {
                $id = $nom = $mail = $adresse = "";
            }
            ?>
            <input type="hidden" name="action" value="save" >
            <input type="hidden" name="id_client" value="<?php echo $id; ?>" >
            <div class="row" >
                <label class="col-md-2" for="idNom" >Nom:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idNom" name="nom_client" required value="<?php echo $nom; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idMail" >eMail:&nbsp;</label><div class="col-md-10" ><input type="email" class="form-control" id="idMail" name="mail_client" placeholder="identifiant@mail.com" value="<?php echo $mail; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idAdresse" >Adresse:&nbsp;</label><div class="col-md-10" ><textarea class="form-control" id="idAdresse" name="adresse_client" ><?php echo $adresse; ?></textarea></div>
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
                    <span class="glyphicon glyphicon-plus trash" aria-hidden="true" ></span><input class="logIn adm" type="submit" value="Ajouter un client" >
                </form>
            </li>
            <br/>
<!------------------------------------------------------------------------------recherche client(s)------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <h4>Recherche:</h4>
                    <input type="hidden" name="action" value="search" >
                    <div class="row" >
                        <div class="col-md-2" >
                            <select class="form-control fieldSel" name="field" >
                                <option value="nom_client">par nom</option>
                                <option value="mail_client">par mail</option>
                                <option value="adresse_client">par adresse</option>
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
                            <input type="hidden" name="id_client" value="<?php echo $result["id_client"]; ?>" >
                            <input class="logIn adm" type="submit" value="<?php echo $result["nom_client"]; ?>" >
                        </form>
                        <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="archive" >
                            <input type="hidden" name="id_client" value="<?php echo $result["id_client"]; ?>" >
                            <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                        </form>
                    </div>
                </li>                               
            <?php } ?>                
                <hr><br/>
        <?php } ?>
<!------------------------------------------------------------------------------liste clients------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
        <?php foreach ($clients as $client){ ?>          
            <li>
                <div class="row" >
                    <form class="col-md-2" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="details" >
                        <input type="hidden" name="id_client" value="<?php echo $client["id_client"]; ?>" >
                        <input class="logIn adm" type="submit" value="<?php echo $client["nom_client"]; ?>" >
                    </form>
                    <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="archive" >
                        <input type="hidden" name="id_client" value="<?php echo $client["id_client"]; ?>" >
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





