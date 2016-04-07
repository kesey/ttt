<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Exemplaires/
 * NAME: index.php
 */

?>
<link href="<?php echo WEBROOT; ?>css/exemplaires/index.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo WEBROOT; ?>css/exemplaires/print.min.css" type="text/css" media="print">
<script type="text/javascript">
    $(document).ready(function(){
        $("section").attr("class", "");
    });
</script>
<?php if(isset($_SESSION['mais qui cela peut-il bien être ?']) && in_array($_SESSION['mais qui cela peut-il bien être ?'], $admins, TRUE)){ ?>
    <!------------------------------------------------------------------------------infos gestionCassettes------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <article class="centrer contenir research" >
        <br/>
        <?php if(isset($_SESSION['info'])){ ?>
            <div class="alert alert-danger informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['info']; unset($_SESSION['info']); if(isset($_SESSION['infoSave'])){ unset($_SESSION['infoSave']); } ?></div>
        <?php } else if(isset($_SESSION['infoSave'])){ ?>    
            <div class="alert alert-info informations" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><?php echo $_SESSION['infoSave']; unset($_SESSION['infoSave']); if(isset($_SESSION['info'])){ unset($_SESSION['info']); } ?></div>
        <?php } ?>
        <div class="alert alert-danger informations" id="jqInfos" role="alert" ><img class="closeInfo closeInformations" src="<?php echo WEBROOT; ?>images/supprimer.png" title="fermeture" alt="crossIcon" ><span></span><br/></div>         
    <!------------------------------------------------------------------------------recherche cassette(s)-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="container" >     
            <ul>    
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
                    </div>
                </li> 
            <?php } ?>               
            </ul>
        </div>
    </article>
<!------------------------------------------------------------------------------affichage infos gestion------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
    <?php if(isset($exemplaires)){ ?>
        <article>
            <div class="infosGestion" >
                <span class="infoDate" ><?php echo $dateTime; ?></span><br/>
                <h4>Infos gestion // <?php echo $infosCassette['code']; ?> // <?php echo $infosCassette['titre']; ?>:</h4>
                <br/>
                <ul class="affInfos" >                    
                    <li>Il reste <?php echo $stock['enStock']; ?> exemplaire(s).</li>
                    <li><?php echo $vendus; ?> exemplaire(s) a/ont été vendu(s).</li>
                    <li><?php echo $depot['enDepot']; ?> exemplaire(s) est/sont en dépôt.</li>
                    <li><?php echo $don['donnes']; ?> exemplaire(s) a/ont été donné(s).</li>
                    <li><?php echo $noStock['horsStock']; ?> exemplaire(s) est/sont hors stock.</li>
                </ul>
                <ul class="affInfos colInfos" >
                    <?php foreach($ventes as $who => $value){ ?>
                        <li><?php echo $who; ?> a vendu pour: <?php if(!empty($value['somme'])){ echo $value['somme']; } else { echo '0.00'; } ?>&nbsp;&euro;</li>
                    <?php } ?>
                </ul>
                <ul class="affInfos colInfos" >
                    <?php foreach($compta as $who => $value){ ?>
                        <li><?php echo $who; ?> doit <?php if(!empty($value['doit']['somme'])){ echo $value['doit']['somme']; } else { echo '0.00'; } ?>&nbsp;&euro;&nbsp;à TTT</li>
                    <?php } ?>
                </ul>
                <ul class="affInfos colInfos" >
                    <?php foreach($compta as $who => $value){ ?>
                        <li>frais de port dus à <?php echo $who; ?>: <?php if(!empty($value['recupere']['somme'])){ echo $value['recupere']['somme']; } else { echo '0.00'; } ?>&nbsp;&euro;</li>
                    <?php } ?>
                </ul>
                <ul class="affInfos colInfos" >
                    <li>Cette cassette a été téléchargée <?php echo $infosCassette['nombre_de_download']; ?> fois.</li>
                    <li>Total des ventes: <?php if(!empty($total['somme'])){ echo $total['somme']; } else { echo '0.00'; } ?>&nbsp;&euro;</li>
                    <li>Gains réels (total des ventes - montant fdp total): <?php echo $gainReel; ?>&nbsp;&euro;</li>
                </ul>
            </div>
            <br/><br/>
<!------------------------------------------------------------------------------formulaire ordre affichage--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->    
            <form id="orderFormAsc" action="#" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="id_cassette" value="<?php echo $infosCassette['id_cassette']; ?>" >
                <input type="hidden" name="action" value="order" >
                <input type="hidden" name="order" value="ASC" >
            </form>
            <form id="orderFormDesc" action="#" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="id_cassette" value="<?php echo $infosCassette['id_cassette']; ?>" >
                <input type="hidden" name="action" value="order" >
                <input type="hidden" name="order" value="DESC" >
            </form>
<!------------------------------------------------------------------------------formulaire gestionExemplaires------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>    
            <form class="saveForm" id="saveFormEx" action="#" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="action" value="save" >
                <input type="hidden" name="id_cassette" value="<?php echo $infosCassette['id_cassette']; ?>" >
                <table class="tabExpl" >
                    <caption align="top" ><h4><?php echo $infosCassette['code']; ?> // <?php echo $infosCassette['titre']; ?></h4></caption>
                    <thead>
                        <tr>
                            <th class="noBorder" ></th>
                            <th>                                    
                                numéro:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="numero_exemplaire" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="numero_exemplaire" ></button>
                                </div>
                            </th>
                            <th>
                                état:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="id_etat" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="id_etat" ></button>
                                </div>
                            </th>
                            <th>
                                localisation:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="localite_exemplaire" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="localite_exemplaire" ></button>
                                </div>
                            </th>
                            <th>
                                vendeur:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="id_vendeur" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="id_vendeur" ></button>
                                </div>
                            </th>
                            <th>
                                prix de vente:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="prix_vente_euros" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="prix_vente_euros" ></button>
                                </div>
                            </th>
                            <th>
                                vente remboursée:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="vente_remboursee" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="vente_remboursee" ></button>
                                </div>
                            </th>
                            <th>
                                client:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="id_client" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="id_client" ></button>
                                </div>
                            </th>
                            <th>
                                date de la transaction:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="date_vente" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="date_vente" ></button>
                                </div>
                            </th>
                            <th>
                                montant fdp:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="montant_frais_de_port" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="montant_frais_de_port" ></button>
                                </div>
                            </th>
                            <th>
                                fdp remboursés:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="frais_de_port_rembourses" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="frais_de_port_rembourses" ></button>
                                </div>
                            </th>
                            <th>
                                commentaires:
                                <div>
                                    <button class="glyphicon glyphicon-sort-by-attributes trie" name="field" form="orderFormAsc" aria-hidden="true" value="commentaire" ></button>
                                    <button class="glyphicon glyphicon-sort-by-attributes-alt trie" name="field" form="orderFormDesc" aria-hidden="true" value="commentaire" ></button>
                                </div>
                            </th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <?php foreach($exemplaires as $key => $exemplaire){ ?>
                            <tr>
                                <td class="copySel" >
                                    <input type="radio" class="num" name="copy" value="<?php echo $exemplaire['numero_exemplaire']; ?>" >
                                </td>
                                <td class="numEx" >
                                    <input type="hidden" class="num" name="id_exemplaire-<?php echo $exemplaire['id_exemplaire']; ?>" value="<?php echo $exemplaire['id_exemplaire']; ?>" >
                                    <input type="hidden" class="num" name="numero_exemplaire-<?php echo $exemplaire['id_exemplaire']; ?>" value="<?php echo $exemplaire['numero_exemplaire']; ?>" >
                                    <?php echo $exemplaire['numero_exemplaire']; ?>
                                </td>
                                <td>
                                    <select class="form-control fieldSel etatExpl" name="id_etat-<?php echo $exemplaire['id_exemplaire']; ?>" >                                
                                        <?php foreach($etats as $etat){ ?>
                                            <option value="<?php echo $etat['id_etat_exemplaire']; ?>" <?php if($exemplaire['id_etat'] === $etat['id_etat_exemplaire']){ echo "selected"; } ?> ><?php echo $etat['description_etat']; ?></option>         
                                        <?php } ?>                                        
                                    </select>
                                </td>
                                <td>
                                    <textarea class="form-control localise" name="localite_exemplaire-<?php echo $exemplaire['id_exemplaire']; ?>" ><?php echo $exemplaire['localite_exemplaire']; ?></textarea>
                                </td>
                                <td>
                                    <select class="form-control fieldSel" name="id_vendeur-<?php echo $exemplaire['id_exemplaire']; ?>" >
                                        <option value="0" >---</option>
                                        <?php foreach($vendeurs as $vendeur){ ?>
                                            <option value="<?php echo $vendeur['id_admin']; ?>" <?php if($exemplaire['id_vendeur'] === $vendeur['id_admin']){ echo "selected"; } ?> ><?php echo $vendeur['nom']; ?></option>         
                                        <?php } ?>                                        
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control exPrix" name="prix_vente_euros-<?php echo $exemplaire['id_exemplaire']; ?>" placeholder="0.00" value="<?php echo $exemplaire['prix_vente_euros']; ?>" >
                                </td>
                                <td>
                                    <select class="form-control fieldSel" name="vente_remboursee-<?php echo $exemplaire['id_exemplaire']; ?>" >                                        
                                        <option value="0" <?php if(!$exemplaire['vente_remboursee']){ echo "selected"; } ?> >non</option>
                                        <option value="1" <?php if($exemplaire['vente_remboursee']){ echo "selected"; } ?> >oui</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control fieldSel client" name="id_client-<?php echo $exemplaire['id_exemplaire']; ?>" >
                                        <option value="32" >---</option>
                                        <?php foreach($clients as $client){ ?>
                                            <option value="<?php echo $client['id_client']; ?>" <?php if($exemplaire['id_client'] === $client['id_client']){ echo "selected"; } ?> ><?php echo $client['nom_client']; ?></option>         
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control exDate" name="date_vente-<?php echo $exemplaire['id_exemplaire']; ?>" placeholder="jj-mm-aaaa" value="<?php echo $exemplaire['date_vente']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="form-control exMontantFdp" name="montant_frais_de_port-<?php echo $exemplaire['id_exemplaire']; ?>" placeholder="0.00" value="<?php echo $exemplaire['montant_frais_de_port']; ?>" >
                                </td>
                                <td>
                                    <select class="form-control fieldSel" name="frais_de_port_rembourses-<?php echo $exemplaire['id_exemplaire']; ?>" >                                        
                                        <option value="0" <?php if(!$exemplaire['frais_de_port_rembourses']){ echo "selected"; } ?> >non</option>
                                        <option value="1" <?php if($exemplaire['frais_de_port_rembourses']){ echo "selected"; } ?> >oui</option>
                                    </select>
                                </td>
                                <td>
                                    <textarea class="form-control com" name="commentaire-<?php echo $exemplaire['id_exemplaire']; ?>" ><?php echo $exemplaire['commentaire']; ?></textarea>
                                </td>
                            </tr>                            
                        <?php } ?>
                    </tbody>                    
                </table>
                <br/>
                <div class="boutonFixed" >
                    <input type="submit" class="btn btn-sm btn-danger" value="save" >&nbsp;                                        
                    <input type="button" class="btn btn-sm btn-success" id="printButt" value="print" >&nbsp;
                    <input type="button" class="btn btn-sm btn-primary" id="copyButt" value="copy" >&nbsp;
                    <input type="button" class="btn btn-sm btn-warning" id="pasteButt" value="paste" >&nbsp;
                    <img class="loader" src="<?php echo WEBROOT; ?>images/discret.gif" title="load" alt="loader" >
                </div>
            </form>             
        </article>
        <br/><br/>
    <?php } ?>
<!------------------------------------------------------------------------------access denied---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php } else { ?>
        <META HTTP-EQUIV="Refresh" Content="0; URL=<?php echo WEBROOT; ?>cassettes">  
<?php }
    




