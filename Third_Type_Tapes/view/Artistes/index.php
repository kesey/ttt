<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Artistes/
 * NAME: index.php
 */

?>
<br/><br/>
<?php foreach ($artistes as $artiste) { ?>
    <a class="noUnderL" href="<?php echo WEBROOT; ?>artistes/view/<?php echo $artiste['id_artiste']; ?>/<?php echo $artiste['nom']; ?>" >
        <div class="showInfos" >
            <img class="pochette" src="<?php echo WEBROOT; ?>images/artiste/<?php echo $artiste['image_artiste_resize']; ?>" title="artiste" alt="<?php echo $artiste['nom']; ?>" >
            <h5><?php echo $artiste['nom']; ?></h5>
        </div>
    </a>
<?php } ?>


