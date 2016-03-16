<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/view/Cassettes/
 * NAME: view.php
 */

?>
<br/>
<h4><?php echo $cassettes[0]['code']; ?> // <?php foreach($cassettes as $value){ echo $value['nom']." "; } ?> // <?php echo $cassettes[0]['titre']; ?></h4>
    <img class="detailImg zoom" src="<?php echo WEBROOT; ?>images/cassette/<?php echo $cassettes[0]['image_pochette']; ?>" title="image_pochette" alt="<?php echo $cassettes[0]['titre']; ?>" >
    <span class="detail" ><?php echo nl2br($cassettes[0]['description']); ?></span>
<br/><br/>
<?php if(!$cassettes[0]['sold_out']){ ?>
<!------------------------------------------------------------------------------bouton paiement paypal----------------------------------------------------------------------------------------------------------------------------------------------------------->
    <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" >
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="W5BGTPVHQ5A7S">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="ajout panier">
        <input type="hidden" name="item_number" value="<?php echo $cassettes[0]['code']; ?> // <?php foreach($cassettes as $value){ echo $value['nom']." "; } ?> // <?php echo $cassettes[0]['titre']; ?>">
        <input type="hidden" name="button_subtype" value="products">
        <input type="hidden" name="currency_code" value="EUR">
        <input type="hidden" name="add" value="1">
        <input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_LG.gif:NonHostedGuest">
        <table>
            <tr>
                <td>
                    <input type="hidden" name="on0" value="Price">Select your price
                </td>
            </tr>
            <tr>
                <td>
                    <select name="os0">
                        <option value="France/Belgique">France/Belgique 6,50&euro;</option>
                        <option value="Europe">Europe 9,50&euro;</option>
                        <option value="World">World 10,50&euro;</option>
                    </select>    
                </td>
            </tr>                        
        </table><br/>
        <input type="hidden" name="currency_code" value="EUR">
        <input type="hidden" name="option_select0" value="France/Belgique">
        <input type="hidden" name="option_amount0" value="6.50">
        <input type="hidden" name="option_select1" value="Europe">
        <input type="hidden" name="option_amount1" value="9.50">
        <input type="hidden" name="option_select2" value="World">
        <input type="hidden" name="option_amount2" value="10.50">
        <input type="hidden" name="option_index" value="0">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/fr_XC/i/scr/pixel.gif" width="1" height="1">
    </form>
    <br/>
<!------------------------------------------------------------------------------détails frais d'envoi------------------------------------------------------------------------------------------------------------------------------------------------------------>
    <p class="detail" >
        <strong>*Shipping :</strong>
        <br/>
        <?php foreach ($shipInfos as $shipInfo) { ?>
        <?php echo $shipInfo['nom_destination']; ?> : <?php echo $shipInfo['montant_frais_de_port']; ?>&euro;
        <br/>
        <?php } ?>
    </p>
    <p class="detail" >
        <em>For shipping discount,<br/> 
            please send your order by mail : thirdtypetapes@gmail.com
        </em>
    </p>
<?php } else { ?>
<!------------------------------------------------------------------------------release en rupture de stock------------------------------------------------------------------------------------------------------------------------------------------------------>
    <p class="detail" >
        <strong>SOLD OUT!!!</strong>
        <br/>
        But you can help your devoted aliens by clicking on the donation button :            
    </p>
<?php } ?>
<br/><br/>
<!------------------------------------------------------------------------------bouton de telechargement--------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if($cassettes[0]['download'] && $cassettes[0]['sold_out']){ ?>
    <form action="#" method="POST" enctype="multipart/form-data" class="download" > 
        <span aria-hidden="true" class="glyphicon glyphicon-download-alt biggerIcon"></span>
        <input type="submit" value="free download" class="downloadBtn biggerText" >
        <input type="hidden" name="nomFichier" value="<?php echo $cassettes[0]['download']; ?>" >
        <input type="hidden" name="action" value="download" >
    </form>
    <br/>
<?php } ?>
<!------------------------------------------------------------------------------bouton donation paypal----------------------------------------------------------------------------------------------------------------------------------------------------------->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">    
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/fr_XC/i/scr/pixel.gif" width="1" height="1">
</form>
<br/>
<!------------------------------------------------------------------------------lien soundcloud------------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php if($cassettes[0]['lien_soundcloud']){ ?>
    <iframe width="100%" height="166" scrolling="no" frameborder="no" src="<?php echo $cassettes[0]['lien_soundcloud']; ?>"></iframe>
    <br/><br/>
<?php } ?>
<!------------------------------------------------------------------------------lien youtube (si il existe)------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php if($cassettes[0]['lien_youtube']){ ?>
    <iframe width="100%" height="315" src="<?php echo $cassettes[0]['lien_youtube']; ?>" frameborder="1" allowfullscreen></iframe>
<?php } ?>
<br/><br/>
<!------------------------------------------------------------------------------artiste(s) ayant produit(s) cette release---------------------------------------------------------------------------------------------------------------------------------------->
<?php foreach($cassettes as $value){ ?>
    <a class="noUnderL" href="<?php echo WEBROOT; ?>artistes/view/<?php echo $value['id_artiste']; ?>/<?php echo $value['nom']; ?>" >
        <div class="showInfos" >
            <img class="pochette" src="<?php echo WEBROOT; ?>images/artiste/<?php echo $value['image_artiste']; ?>" title="image_artiste" alt="<?php echo $value['nom']; ?>" >
            <h5><?php echo $value['nom']; ?></h5>
        </div>
    </a>
<?php } ?>
<br/><br/>
<!------------------------------------------------------------------------------navigation (previous/next)------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if($cassettes[0]['id_cassette'] > $id['min']){ ?>
    <a class="glyphicon glyphicon-menu-left noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>cassettes/view/<?php echo $cassPrev['id_cassette']; ?>/<?php echo $cassPrev['code']; ?>/<?php echo $cassPrev['nom']; ?>/<?php echo $cassPrev['titre']; ?>" >
        <span class="glyphicon-class biggerText">previous</span>
    </a>
    <br/><br/>
<?php } ?>
<?php if($cassettes[0]['id_cassette'] < $id['max']){ ?>
    <a class="glyphicon glyphicon-menu-right noUnderL biggerText" aria-hidden="true" href="<?php echo WEBROOT; ?>cassettes/view/<?php echo $cassNext['id_cassette']; ?>/<?php echo $cassNext['code']; ?>/<?php echo $cassNext['nom']; ?>/<?php echo $cassNext['titre']; ?>" >
        <span class="glyphicon-class biggerText">next</span>       
    </a>
    <br/><br/>
<?php } ?>
<!------------------------------------------------------------------------------boutons partage------------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php if(!isset($_SESSION['mais qui cela peut-il bien être ?'])){ ?>
    <div id="socialNetwork"></div>
<?php }
