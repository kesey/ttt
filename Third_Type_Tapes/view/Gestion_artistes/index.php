<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Gestion_artistes/
 * NAME: index.php
 */

?>
<!------------------------------------------------------------------------------infos gestionArtistes---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && in_array($_SESSION['mais qui cela peut-il bien être ?'], $admins, TRUE)){ ?>
    <br/>
    <?php if(isset($_SESSION['info'])){ ?>
        <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" title="fermeture" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
    <?php } else if(isset($_SESSION['infoSave'])){ ?>    
        <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
    <?php } ?>
    <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span></div>
    <br/>
<!------------------------------------------------------------------------------formulaire gestionArtistes----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="container" >
        <form class="saveForm" id="saveFormArt" action="#" method="POST" enctype="multipart/form-data" >
            <?php                       
            if(isset($detailsArt)) {
                $id = $detailsArt["id_artiste"];
                $nom = $detailsArt["nom"];
                $lien = $detailsArt["lien_artiste"];
                $bio = $detailsArt["bio"];
                $image = $detailsArt["image_artiste"];
                if(empty($detailsArt['prodArt'])){
                    $prodArtiste = array();
                } else {
                    foreach ($detailsArt['prodArt'] as $value) {
                        $prodArtiste[] = $value['id_cassette'];
                    }
                }
            } else {
                $id = $nom = $lien = $bio = $image = "";
                $prodArtiste = array();
            }
            ?>
            <input type="hidden" name="action" value="save" >
            <input type="hidden" name="id_artiste" value="<?php echo $id; ?>" >
            <div class="row" >
                <label class="col-md-2" for="idNom" >Nom:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idNom" name="nom" required value="<?php echo $nom; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idLien" >Lien:&nbsp;</label><div class="col-md-10" ><input type="url" class="form-control" id="idLien" name="lien_artiste" placeholder="http(s)://xxx" required value="<?php echo $lien; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idBio" >Bio:&nbsp;</label><div class="col-md-10" ><textarea class="form-control mceEditor" id="idBio" name="bio" ><?php echo $bio; ?></textarea></div>
            </div><br/>            
            <div class="imageGesEvt labImg" ><label>Image:&nbsp;</label></div>
            <?php if($image){ ?>
                <div class="imageGesEvt" ><img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/artiste/<?php echo $image ?>" title="image_artiste" alt="image -> <?php echo $nom; ?>" ></div>&nbsp;
                <input type="hidden" id ="idImage_artiste" name="image_artiste" value="<?php echo $image; ?>" >
            <?php } ?>
            <div class="imageGesEvt" >
                <div class="row">
                    <div class="col-md-8" >
                        <input type="file" class="parcourir" id ="idNew_image_artiste" name="new_image_artiste" >
                    </div>
                    <div class="col-md-4" >
                        <input type="button" class="clear_file" value="clear" >
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="row" >
                <label class="col-md-2" for="idProd" >Production(s):&nbsp;</label>
                <div class="col-md-10" >
                    <select class="form-control" id="idProd" name="productions[]" multiple >                                            
                            <?php if(!$prodArtiste){ ?>
                                <option value="0" selected >---</option>
                            <?php } 
                            if(isset($allProd)){ 
                                foreach ($allProd as $prod){ ?>
                                    <option value="<?php echo $prod['id_cassette']; ?>" <?php if(in_array($prod['id_cassette'], $prodArtiste)){ echo 'selected'; } ?> >
                                        <?php echo $prod['titre']; ?>
                                    </option>
                            <?php } 
                            } ?>                       
                    </select>    
                </div>
            </div><br/>            
            <div class="row" >
                <div class="col-md-2" ></div><div class="col-md-10" ><input class="btn btn-sm btn-danger" type="submit" value="save" ></div>
            </div>
        </form>    
        <br/>
<!------------------------------------------------------------------------------reset formulaire------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <ul>
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <span class="glyphicon glyphicon-plus trash" aria-hidden="true" ></span><input class="logIn adm" type="submit" value="Ajouter un artiste" >
                </form>
            </li>
            <br/>
<!------------------------------------------------------------------------------recherche artiste(s)----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <h4>Recherche:</h4>
                    <input type="hidden" name="action" value="search" >
                    <div class="row" >
                        <div class="col-md-2" >
                            <select class="form-control fieldSel" name="field" >
                                <option value="nom">par nom</option>
                                <option value="bio">par bio</option>
                            </select>
                        </div>
                        <div class="col-md-10" >
                            <input type="search" class="form-control" id ="idRecherche" name="recherche" > 
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
                            <input type="hidden" name="id_artiste" value="<?php echo $result["id_artiste"]; ?>" >
                            <input class="logIn adm" type="submit" value="<?php echo $result["nom"]; ?>" >
                        </form>
                        <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="archive" >
                            <input type="hidden" name="id_artiste" value="<?php echo $result["id_artiste"]; ?>" >
                            <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                        </form>
                    </div>
                </li>                               
            <?php } ?>                
                <hr><br/>
        <?php } ?>
<!------------------------------------------------------------------------------liste artistes----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <?php foreach ($artistes as $artiste){ ?>          
            <li>
                <div class="row" >
                    <form class="col-md-2" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="details" >
                        <input type="hidden" name="id_artiste" value="<?php echo $artiste["id_artiste"]; ?>" >
                        <input class="logIn adm" type="submit" value="<?php echo $artiste["nom"]; ?>" >
                    </form>
                    <form class="col-md-10" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="archive" >
                        <input type="hidden" name="id_artiste" value="<?php echo $artiste["id_artiste"]; ?>" >
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
