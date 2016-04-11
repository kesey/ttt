<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Events/
 * NAME: view.php
 */

?>
<link href="<?php echo WEBROOT; ?>css/events/index.min.css" rel="stylesheet" type="text/css">
<br/>
<h4><?php echo $event['date_event_fr']; ?> // <?php echo $event['titre_event']; ?></h4>
    <img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/event/<?php echo $event['image_event']; ?>" title="image_event" alt="<?php echo $event['titre_event']; ?>" >
    <span class="detail" ><?php echo $event['description_event']; ?></span>
<br/><br/>
<!------------------------------------------------------------------------------API google maps--------------------------------------------------------------------------------------------------------------------------------------------------->    
<?php if($event['lieu']){ ?>
    <iframe width="280" height="220" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $event['lieu']; ?>&key=AIzaSyAZMwB9l5YQnbhyXvJbFx4fzKXnxf2HqYM" ></iframe>
    <br/><br/>
<?php } ?>
<!------------------------------------------------------------------------------navigation (previous/next)---------------------------------------------------------------------------------------------------------------------------------------->
<?php if($event['date_event'] > $date['min']){ ?>
    <a class="glyphicon glyphicon-menu-left noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>events/view/<?php echo $eventPrev['id_event']; ?>/<?php echo $eventPrev['date_event_fr']; ?>/<?php echo $eventPrev['titre_event']; ?>" >
        <span class="glyphicon-class biggerText">previous</span>
    </a>
    <br/><br/>
<?php } ?>
<?php if($event['date_event'] < $date['max']){ ?>
    <a class="glyphicon glyphicon-menu-right noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>events/view/<?php echo $eventNext['id_event']; ?>/<?php echo $eventNext['date_event_fr']; ?>/<?php echo $eventNext['titre_event']; ?>" >
        <span class="glyphicon-class biggerText">next</span>       
    </a>
    <br/><br/>
<?php } ?>
<!------------------------------------------------------------------------------boutons partage--------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(!isset($_SESSION['mais qui cela peut-il bien être ?'])){ ?>
    <div id="socialNetwork"></div>
<?php }

