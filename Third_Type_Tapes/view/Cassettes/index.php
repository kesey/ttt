<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Cassettes/
 * NAME: index.php
 */

?>
<br/><br/>
<?php foreach ($cassettes as $cassette) { ?>
    <a class="noUnderL" href="<?php echo WEBROOT; ?>cassettes/view/<?php echo $cassette['id_cassette']; ?>/<?php echo $cassette['code']; ?>/<?php echo $cassette['nom']; ?>/<?php echo $cassette['titre']; ?>" >
        <div class="showInfos" >
            <img class="pochette" src="<?php echo WEBROOT; ?>images/cassette/<?php echo $cassette['image_pochette_resize']; ?>" title="image_pochette" alt="<?php echo $cassette['titre']; ?>" >
            <h5><?php echo $cassette['code']; ?> // <?php foreach($artistes as $artiste){ if ($artiste['id_cassette'] === $cassette['id_cassette']) { echo $artiste['nom']." "; } } ?> // <?php echo $cassette['titre']; ?></h5>
        </div>
    </a>
<?php } ?>
