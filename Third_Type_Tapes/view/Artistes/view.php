<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/artistes/
 * NAME: view.php
 */

?>
<br/>
<h4><?php echo $artiste[0]['nom']; ?></h4>
    <img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/artiste/<?php echo $artiste[0]['image_artiste']; ?>" title="artiste" alt="<?php echo $artiste[0]['nom']; ?>" >
    <span class="detail" ><?php echo nl2br($artiste[0]['bio']); ?></span>
<br/><br/>
<!------------------------------------------------------------------------------release(s) produite(s) par l'artiste-------------------------------------------------------------------------------------->
<?php foreach($artiste as $value){ ?>
    <a class="noUnderL" href="<?php echo WEBROOT; ?>cassettes/view/<?php echo $value['id_cassette']; ?>/<?php echo $value['code']; ?>/<?php echo $value['nom']; ?>/<?php echo $value['titre']; ?>" >
        <div class="showInfos" >
            <img class="pochette" src="<?php echo WEBROOT; ?>images/cassette/<?php echo $value['image_pochette']; ?>" title="image_pochette" alt="<?php echo $value['titre']; ?>" >
            <h5><?php echo $value['code']; ?> // <?php echo $value['nom']; ?> // <?php echo $value['titre']; ?></h5>
        </div>
    </a>
<?php } ?>
<br/><br/>
<!------------------------------------------------------------------------------navigation (previous/next)------------------------------------------------------------------------------------------------>
<?php if($artiste[0]['id_artiste'] > $id['min']){ ?>
    <a class="glyphicon glyphicon-menu-left noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>artistes/view/<?php echo $artPrev['id_artiste']; ?>/<?php echo $artPrev['nom']; ?>" >
        <span class="glyphicon-class biggerText">previous</span>
    </a>
    <br/><br/>
<?php } ?>
<?php if($artiste[0]['id_artiste'] < $id['max']){ ?>
    <a class="glyphicon glyphicon-menu-right noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>artistes/view/<?php echo $artNext['id_artiste']; ?>/<?php echo $artNext['nom']; ?>" >
        <span class="glyphicon-class biggerText">next</span>       
    </a>
    <br/><br/>
<?php } ?>
<!------------------------------------------------------------------------------boutons partage----------------------------------------------------------------------------------------------------------->
<?php if(!isset($_SESSION['mais qui cela peut-il bien être ?'])){ ?>
    <div id="socialNetwork"></div>
<?php }



