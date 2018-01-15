<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Gestion_cassettes/
 * NAME: index.php
 */

?>
<link href="<?php echo WEBROOT; ?>css/gestionCassettes/index.min.css" rel="stylesheet" type="text/css">
<!------------------------------------------------------------------------------infos gestionCassettes------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && in_array($_SESSION['mais qui cela peut-il bien être ?'], $admins, TRUE)){ ?>
    <br/>
    <?php if(isset($_SESSION['info'])){ ?>
        <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
    <?php } else if(isset($_SESSION['infoSave'])){ ?>    
        <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
    <?php } ?>
    <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span></div>
    <br/>
<!------------------------------------------------------------------------------formulaire gestionCassettes-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <div class="container" >
        <form class="saveForm" id="saveFormCass" action="#" method="POST" enctype="multipart/form-data" >
            <?php                       
            if(isset($detailsCass)) {
                $id = $detailsCass["id_cassette"];
                $titre = $detailsCass["titre"];
                $dateSortie = $detailsCass["date_sortie"];
                $code = $detailsCass["code"];
                $longueur = $detailsCass["longueur"];
                $prix = $detailsCass["prix"];
                $lienBandcamp = $detailsCass["lien_bandcamp"];
                $lienSoundcloud = $detailsCass["lien_soundcloud"];
                $lienYoutube = $detailsCass["lien_youtube"];
                $description = $detailsCass["description"];
                $download = $detailsCass["download"];
                $image = $detailsCass["image_pochette"];
                $nbreDownload = $detailsCass["nombre_de_download"];
            } else {
                $id = $titre = $dateSortie = $code = $longueur = $prix = $lienBandcamp = $lienSoundcloud = $lienYoutube = $description = $download = $image = "";
                $nbreDownload = 0;
            }
            ?>
            <input type="hidden" name="action" value="save" >
            <input type="hidden" name="id_cassette" value="<?php echo $id; ?>" >
            <div class="row" >
                <label class="col-md-2" for="idTitre" >Titre:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idTitre" name="titre" required value="<?php echo $titre; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idDateSortie" >Date de sortie:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idDateSortie" name="date_sortie" placeholder="jj-mm-aaaa" required value="<?php echo $dateSortie; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idCode" >Code&nbsp;(ref catalogue):&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idCode" name="code" placeholder="TTT01" required value="<?php echo $code; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idLongueur" >Longueur:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idLongueur" name="longueur" placeholder="C60" required value="<?php echo $longueur; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idPrix" >Prix:&nbsp;</label><div class="col-md-10" ><input type="text" class="form-control" id="idPrix" name="prix" placeholder="5.00" value="<?php echo $prix; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idBandcamp" >Lien bandcamp:&nbsp;</label><div class="col-md-10" ><input type="url" class="form-control" id="idBandcamp" name="lien_bandcamp" placeholder="http(s)://xxx" value="<?php echo $lienBandcamp; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idSoundcloud" >Lien soundcloud:&nbsp;</label><div class="col-md-10" ><input type="url" class="form-control" id="idSoundcloud" name="lien_soundcloud" placeholder="http(s)://xxx" value="<?php echo $lienSoundcloud; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idYoutube" >Lien youtube:&nbsp;</label><div class="col-md-10" ><input type="url" class="form-control" id="idYoutube" name="lien_youtube" placeholder="http(s)://xxx" value="<?php echo $lienYoutube; ?>" ></div>
            </div><br/>
            <div class="row" >
                <label class="col-md-2" for="idDescription" >Description:&nbsp;</label><div class="col-md-10" ><textarea class="form-control mceEditor" id="idDescription" name="description" ><?php echo $description; ?></textarea></div>
            </div><br/>
            <div class="imageGesEvt labImg" ><label>File&nbsp;(.rar):&nbsp;</label></div>
            <?php if($download){ ?>
                <div class="imageGesEvt downloadFile" ><?php echo $download; ?></div>&nbsp;
                <input type="hidden" id ="idDownload" name="download" value="<?php echo $download; ?>" >
            <?php } ?>
            <div class="imageGesEvt" >
                <div class="row">
                    <div class="col-md-8" >
                        <input type="file" class="parcourir" id ="idNew_download" name="new_download" >
                    </div>
                    <div class="col-md-4" >
                        <input type="button" class="clear_file" value="clear" >
                    </div>
                </div><br/>             
            </div>
            <br/><br/>
            <div class="imageGesEvt labImg" ><label>Image:&nbsp;</label></div>
            <?php if($image){ ?>
                <div class="imageGesEvt" ><img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/cassette/<?php echo $image; ?>" title="image_cassette" alt="image -> <?php echo $titre; ?> // <?php echo $code; ?>" ></div>&nbsp;
                <input type="hidden" id ="idImage_pochette" name="image_pochette" value="<?php echo $image; ?>" >
            <?php } ?>
            <div class="imageGesEvt" >
                <div class="row">
                    <div class="col-md-8" >
                        <input type="file" class="parcourir" id ="idNew_image_pochette" name="new_image_pochette" >
                    </div>
                    <div class="col-md-4" >
                        <input type="button" class="clear_file" value="clear" >
                    </div>
                </div>
            </div>
            <br/><br/>            
            <div class="row" >
                <div class="col-md-2" ></div>
                <div class="col-md-10" >
                    <input type="submit" class="btn btn-sm btn-danger" value="save" >&nbsp;
                    <img class="loader" src="<?php echo WEBROOT; ?>images/discret.gif" title="load" alt="loader" >
                </div>
            </div>
        </form>    
        <br/>
<!------------------------------------------------------------------------------affichage nombre de download------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div>Cette cassette a été téléchargée <?php echo $nbreDownload; ?> fois.</div>
        <br/>
<!------------------------------------------------------------------------------reset formulaire------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <ul>
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <span class="glyphicon glyphicon-plus trash" aria-hidden="true" ></span><input class="logIn adm" type="submit" value="Ajouter une cassette" >
                </form>
            </li>
            <br/>
<!------------------------------------------------------------------------------recherche cassette(s)-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <li>
                <form action="#" method="POST" enctype="multipart/form-data" >
                    <h4>Recherche:</h4>
                    <input type="hidden" name="action" value="search" >
                    <div class="row" >
                        <div class="col-md-2" >
                            <select class="form-control fieldSel" name="field" >                                
                                <option value="titre">par titre</option>
                                <option value="date_sortie">par date de sortie</option>
                                <option value="code">par code</option>
                                <option value="longueur">par longueur</option>
                                <option value="prix">par prix</option>
                                <option value="description">par description</option>
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
                            <input type="hidden" name="id_cassette" value="<?php echo $result["id_cassette"]; ?>" >
                            <input class="logIn adm" type="submit" value="<?php echo $result["code"]; ?> // <?php echo $result["titre"]; ?>" >
                        </form>
                        <form class="col-md-8" action="#" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="archive" >
                            <input type="hidden" name="id_cassette" value="<?php echo $result["id_cassette"]; ?>" >
                            <input class="logIn adm" type="submit" value="supprimer" >&nbsp;<span class="glyphicon glyphicon-trash trash" aria-hidden="true" ></span>
                        </form>
                    </div>
                </li>                               
            <?php } ?>                
                <hr><br/>
        <?php } ?>
<!------------------------------------------------------------------------------liste cassettes-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <?php foreach ($cassettes as $cassette){ ?>          
            <li>
                <div class="row" >
                    <form class="col-md-4" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="details" >
                        <input type="hidden" name="id_cassette" value="<?php echo $cassette["id_cassette"]; ?>" >
                        <input class="logIn adm" type="submit" value="<?php echo $cassette["code"]; ?> // <?php echo $cassette["titre"]; ?>" >
                    </form>
                    <form class="col-md-8" action="#" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="action" value="archive" >
                        <input type="hidden" name="id_cassette" value="<?php echo $cassette["id_cassette"]; ?>" >
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
    


