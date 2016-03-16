<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Events/
 * NAME: index.php
 */

?>
<link href="<?php echo WEBROOT; ?>css/events/index.min.css" rel="stylesheet" type="text/css">
<br/><br/>
<?php foreach ($events as $event){ ?>
    <a class="noUnderL" href="<?php echo WEBROOT; ?>events/view/<?php echo $event['id_event']; ?>/<?php echo $event['date_event']; ?>/<?php echo $event['titre_event']; ?>" >
        <div class="showInfosEvent" style="height:210px">
            <img class="flyer" src="<?php echo WEBROOT; ?>images/event/<?php echo $event['image_event_resize']; ?>" title="image_event" alt="<?php echo $event['titre_event']; ?>" >
            <h5><?php echo $event['date_event']; ?> // <?php echo $event['titre_event']; ?></h5>
        </div>
    </a>
<?php } ?>


