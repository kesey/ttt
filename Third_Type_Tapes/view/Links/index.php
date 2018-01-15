<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Links/
 * NAME: index.php
 */

?>
<link href="<?php echo WEBROOT; ?>css/links/index.min.css" rel="stylesheet" type="text/css">
<br/>
<div class="links" >
    <h4>Friends</h4>
    <ul>
        <a class="noUnderL" href="http://www.syrphe.com/" target="_blank" ><li>Syrphe</li></a>
        <a class="noUnderL" href="http://smallbuthardrecordings.limitedrun.com/" target="_blank" ><li>Small but hard</li></a>
        <a class="noUnderL" href="http://cuttingroomrecords.blogspot.co.uk/" target="_blank" ><li>Cutting Rooms records</li></a>
        <a class="noUnderL" href="http://www.bedroomresearch.com/" target="_blank" ><li>Bedroom Research</li></a>
        <a class="noUnderL" href="http://andestapes.tumblr.com/" target="_blank" ><li>Andesground</li></a>
        <a class="noUnderL" href="https://soundcloud.com/voyder" target="_blank" ><li>Voyder</li></a>
        <a class="noUnderL" href="http://musikmekanik.free.fr/index.php?option=com_content&view=article&id=101&Itemid=52" target="_blank" ><li>MMC</li></a>
        <a class="noUnderL" href="http://www.serendip-lab.org/" target="_blank" ><li>Serendip Festival</li></a>
        <a class="noUnderL" href="https://www.facebook.com/CCCPu" target="_blank" ><li>CCCPu</li></a>
    </ul>
</div>
<!------------------------------------------------------------------------------lien vers chaque artiste présent en base de données-------------------------------------------------------------------------------------------->
<div class="links" >
    <h4>Aliens</h4>
    <ul>
        <?php foreach ($artistes as $value){ ?>
            <a class="noUnderL" href="<?php echo $value['lien_artiste']; ?>" target="_blank" ><li><?php echo $value['nom']; ?></li></a>
        <?php } ?>
    </ul>
</div>
