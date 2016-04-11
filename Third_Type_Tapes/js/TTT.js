/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/js/
 * NAME: TTT.js
 */

$(document).ready(function(){
    
/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*------------------------------------------------------------------------------FRONT--------------------------------------------------------------------*/
/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    $("body").queryLoader2({ // preloader pour le chargement des images
        percentage: false,
        barHeight: 0,
        maxTime: 30000 
    });
/*------------------------------------------------------------------------------souligne un élément du menu (chemin de fer)------------------------------*/    
    var loc = window.location.pathname;
    var controller = loc.split('/');
    // en local dossier intermédiaire
    if (controller[1] === "Third_Type_Tapes") {
        if(controller[2] === 'index.php') {
            controller[2] = 'cassettes';
        }
        controller = controller[2];
    } else {
        // sur pastis-hosting pas de dossier intermédiaire
        if(controller[1] === 'index.php') {
            controller[1] = 'cassettes';
        }
        controller = controller[1];
    }
    $("#id_"+controller).attr("class", "menu location");
/*------------------------------------------------------------------------------fait apparaitre la fenêtre de log----------------------------------------*/
    $("#logView").hide();
    
    $("#logIn").click(function(){
        $("#logView").toggle("slow");
    });
    
    $("#closeIcon").click(function(){
        $("#infoLog").hide("slow");
    });
/*------------------------------------------------------------------------------annule/retablit le redimensionnement d'une image-------------------------*/    
    $(".zoom").click(function(){
        var cl = $(this).attr("class"); 
        if(cl === "detailImg zoom"){
            $(this).attr("class", "vAlign zoom");
        } else if(cl === "vAlign zoom") {
            $(this).attr("class", "detailImg zoom");
        }
    });
/*------------------------------------------------------------------------------ancre--------------------------------------------------------------------*/    
    $("#icoAimant").hide();
    $(window).scroll(function(){
        if ($(window).scrollTop() > 200) {
            $("#icoAimant").fadeIn();
        } else {
            $("#icoAimant").fadeOut();
        }        
    });
/*------------------------------------------------------------------------------fonctions----------------------------------------------------------------*/
   /**
    *  boutons partage
    */
    $('#socialNetwork').sharrre({
        share: {
            facebook: true,
            twitter: true,
            googlePlus: true
        },
        template: '<div class="box"><div class="left">Share</div><div class="middle"><a href="#" class="facebook">f</a><a href="#" class="twitter">t</a><a href="#" class="googleplus">g+</a></div><div class="right">page</div></div>',
        url: document.location.href,
        text: document.title,
        urlCurl: '../plugIn/sharrre/sharrre.php',
        enableHover: false,
        enableTracking: false,
        render: function(api, options){
            $(api.element).on('click', '.twitter', function() {
                api.openPopup('twitter');
            });
            $(api.element).on('click', '.facebook', function() {
                api.openPopup('facebook');
            });
            $(api.element).on('click', '.googleplus', function() {
               api.openPopup('googlePlus');
            });
        }
    });
   /**
    *  adapte un élément à la hauteur de l'élément qu'il contient
    */
    function adapt(){
        $(".showInfosEvent").each(function(){
            var hauteur = $(this).find(".flyer").height();
            $(this).attr("style", "height:"+hauteur+"px");
        });
    }
   /**
    *  permet l'execution de plusieurs fonctions au chargement de la page
    *  exécution de la fonction 'fct' lorsque l'event 'event' se produit sur l'objet 'obj'
    *  @param {objet} obj
    *  @param {string} event
    *  @param {function} fct
    */
    function addEvent(obj, event, fct){
        if (obj.attachEvent){ // pour IE
            obj.attachEvent("on" + event, fct); 
        } else {
            obj.addEventListener(event, fct, true);
        }
    }
    addEvent(window , "load", adapt);
/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*------------------------------------------------------------------------------BACK---------------------------------------------------------------------*/
/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    var max_img_size = 2097152;
    var max_rar_size = 524288000;
    var max_str_len = 40;
    var sensChars = [' ','#','&','é','è','ê','ë','í','ì','î','ï','ú','ù','û','ü','ý','ÿ','ç','ñ','Á','À','Â','Ä','Ã','Å','Ó','Ò','Ô','Ö','Õ','É','È','Ê','Ë','Í','Ì','Î','Ï','Ú','Ù','Û','Ü','Ý','Ÿ','Ç','Ñ'];
/*------------------------------------------------------------------------------general------------------------------------------------------------------*/
    $("#jqInfos").hide();
    $("#jqInfoLog").hide();
       
    $(".closeInformations").click(function(){
        $(".informations").hide("slow");
    });
    
    $(".saveForm input:not([type=submit]), .saveForm select, textarea").on("keypress click", function(){
        $(this).css("border", "1px solid #ccc");
    });

    $(".saveForm input[type=file]").on("click", function(){
        $(this).css("border", "0px solid #ccc");
    });
    
    $(".clear_file").click(function(){
        var isIE10 = false;
        var isIE9 = false;
        if (navigator.userAgent.indexOf("MSIE 10") > -1) {
            isIE10 = true;
        }
        if (navigator.userAgent.indexOf("MSIE 9") > -1) {
            isIE9 = true;
        }
        if (isIE9 || isIE10){
            $(this).closest("div").prev().children(".parcourir").innerHTML = '';// pour IE 9 et 10
        } else {
            $(this).closest("div").prev().children(".parcourir").val('');
        }        
    });
/*------------------------------------------------------------------------------wysiwyg------------------------------------------------------------------*/    
   /**
    *  transform les textarea selectionnés en editeur wysiwyg
    */
    function createWys(){
        tinymce.init({
            selector: "textarea.mceEditor",
            width: 533,
            menubar: false,
            plugins: [
                "advlist autolink link lists charmap hr",
                "code fullscreen",
                "textcolor colorpicker"
            ],            
            toolbar_items_size: 'small',
            toolbar1: "fullscreen | bold italic underline strikethrough | hr | charmap | bullist numlist | link unlink | alignleft aligncenter alignright alignjustify outdent indent | code",
            toolbar2: "forecolor backcolor | formatselect fontselect fontsizeselect | removeformat | undo redo",           
            setup : function(ed) {
                ed.on('keypress click', function() {
                    $("#mceu_26").css("border", "1px solid #ccc");
                });
            }
        });
    }
    addEvent(window , "load", createWys);
/*------------------------------------------------------------------------------fonctions de vérifications-----------------------------------------------*/    
   /**
    *  vérifie la validité d'une date
    *  @param {string} date date à vérifier
    *  @returns {Boolean}
    */
    function isDate(date){
        var regEx = new RegExp('[0-3][0-9]\-[0-1][0-9]\-[12][0-9]{3}');
        var match = regEx.test(date);
        var dateArr = date.split('-');
        var newDate = new Date(dateArr[2], parseInt(dateArr[1],10)-1, parseInt(dateArr[0],10));
        if(newDate.getMonth() == parseInt(dateArr[1],10)-1 && match){
            return true;
        } else {
            return false;
        }
    }
   /**
    *  vérifie l'extension dans le nom d'un fichier image
    *  @param {string} fileName nom du fichier à vérifier
    *  @returns {Boolean}
    */
    function verifExtImg(fileName){
        var fileName = fileName.toLowerCase();
        var extensionsOk = 'jpg,jpeg,png';
        var fileArray = fileName.split('.');
	var fileExtension = fileArray[fileArray.length-1]; 
	if(extensionsOk.indexOf(fileExtension) === -1) { 
            return false;
	} else { 
            return true;
	}
    }
    /**
    *  vérifie l'extension dans le nom d'un fichier rar
    *  @param {string} fileName nom du fichier à vérifier
    *  @returns {Boolean}
    */
    function verifExtRar(fileName){
        var fileName = fileName.toLowerCase();
        var extensionsOk = 'rar';
        var fileArray = fileName.split('.');
	var fileExtension = fileArray[fileArray.length-1]; 
	if(extensionsOk.indexOf(fileExtension) === -1) { 
            return false;
	} else { 
            return true;
	}
    }
   /**
    *  vérifie le type mime du fichier image
    *  @param {objet} objectFile object File du fichier à vérifier
    *  @returns {Boolean}
    */
    function isImage(objectFile){
        var validTypes = "image/jpeg,image/pjpeg,image/png";
        var type = objectFile.type;
        if(validTypes.indexOf(type) === -1) { 
            return false;
	} else { 
            return true;
	}       
    }
   /**
    *  vérifie le type mime du fichier rar
    *  @param {objet} objectFile object File du fichier à vérifier
    *  @returns {Boolean}
    */
    function isRar(objectFile){
        var validTypes = "application/x-rar-compressed,application/octet-stream";
        var type = objectFile.type;
        if(validTypes.indexOf(type) === -1) { 
            return false;
	} else { 
            return true;
	}       
    }
   /**
    *  détecte un caractère sensible dans une chaine
    *  @param {string} string chaine à vérifier
    */
    function contSensChars(string){
        var contSensC = false;
        sensChars.forEach(function(entry){
            if(string.indexOf(entry) !== -1){
                contSensC = true;
            }
        });
        return contSensC;
    }
   /**
    *  vérifie si une chaine est une url valide
    *  @param {string} string chaine à vérifier
    */
    function isUrl(string){
        return string.match(/^(ht|f)tps?:\/\/[a-zA-Z0-9-\.]+\.[a-zA-Z]{2,4}\/?([^\s<>\#"\,\{\}|\^\[\]`]+)?$/);
    }
   /**
    *  vérifie si une chaine est une adresse mail valide
    *  @param {string} string chaine à vérifier
    */
    function isMail(string){
        var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
        return regEmail.test(string);
    }
    /**
    *  vérifie si une chaine est un code valide
    *  @param {string} code chaine à vérifier
    */
    function codeOk(code){
        var regEx = new RegExp('^T{3}([0-9]{2,4})$');
        return regEx.test(code);
    }
    /**
    *  vérifie si une chaine est est un format de longueur de K7 valide
    *  @param {string} string chaine à vérifier
    */
    function longueurOk(string){
        var regEx = new RegExp('^C[0-9]{2,3}$');
        return regEx.test(string);
    }
    /**
    *  vérifie si une chaine est est un prix valide
    *  @param {string|int|dec} string chaine à vérifier
    */
    function validPrice(string){
        var regEx = new RegExp('^[0-9]{1,2}\.[0-9]{2}$');
        return regEx.test(string);
    }
    /**
    *  assigne une couleur à toute la ligne en fonction de l'état de l'exemplaire
    *  @param {string|int} value valeur à estimer
    *  @param {objet} objThis balise en question
    */
    function colorTr(value, objThis){
        var val = parseInt(value);
        switch(val){
            case 1:
                objThis.closest("tr").children("td").children("input, select, textarea").css("background", "rgba(255, 255, 117, 0.4)");
                break;
            case 2:
                objThis.closest("tr").children("td").children("input, select, textarea").css("background", "rgba(255, 51, 51, 0.3)");
                break;
            case 3:
                objThis.closest("tr").children("td").children("input, select, textarea").css("background", "rgba(131, 255, 131, 0.4)");
                break;
            case 4:
                objThis.closest("tr").children("td").children("input, select, textarea").css("background", "rgba(255, 153, 51, 0.4)");
                break;
            case 5:
                objThis.closest("tr").children("td").children("input, select, textarea").css("background", "rgba(255, 153, 255, 0.4)");
                break;
        }
    }
/*------------------------------------------------------------------------------verifications des infos du formulaire logIn------------------------------*/      
    $("#logView").submit(function(event){
        var isOk = true;
        if($("#idIdentifiant").val() === ""){
            $("#idIdentifiant").css("border", "3px solid #d9534f");
            $("#jqInfoLog > span").html("Veuillez renseigner le champ Username");
            isOk = false;
        }
        if($("#idMot_de_passe").val() === ""){
            $("#idMot_de_passe").css("border", "3px solid #d9534f");
            $("#jqInfoLog > span").html("Veuillez renseigner le champ Password");        
            isOk = false;
        }
        if(!isOk){
            event.preventDefault();
            $("#jqInfoLog").show("slow");
        }
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire gestionCassettes-------------------*/
    $(".loader").hide();
    
    $("#saveFormCass").submit(function(event){
        var isOk = true;        
        tinymce.triggerSave(true, true);
        var objFileImg = document.getElementById("idNew_image_pochette").files[0];
        var objFileRar = document.getElementById("idNew_download").files[0];
        if($("#idTitre").val() === ""){
            $("#idTitre").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un titre");
            isOk = false;
        }
        if($("#idDateSortie").val() === ""){
            $("#idDateSortie").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une date de sortie");        
            isOk = false;
        } else if(!isDate($("#idDateSortie").val())){
            $("#idDateSortie").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("la date de sortie est invalide");
            isOk = false;
        }
        if($("#idCode").val() === ""){
            $("#idCode").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un code (ref catalogue)");
            isOk = false;
        } else if(!codeOk($("#idCode").val())){
            $("#idCode").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Le code (ref catalogue) est invalide");
            isOk = false;
        }
        if($("#idLongueur").val() === ""){
            $("#idLongueur").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une longueur");
            isOk = false;
        } else if(!longueurOk($("#idLongueur").val())){
            $("#idLongueur").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Le format de la longueur est invalide");
            isOk = false;
        }
        if($("#idPrix").val() !== ""){
            if(!validPrice($("#idPrix").val())){
                $("#idPrix").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Le prix est invalide");
                isOk = false;
            }
        }
        if($("#idSoundcloud").val() !== ""){
            if(!isUrl($("#idSoundcloud").val())){
                $("#idSoundcloud").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Le lien soundcloud est invalide");
                isOk = false;
            }
        }
        if($("#idYoutube").val() !== ""){
            if(!isUrl($("#idYoutube").val())){
                $("#idYoutube").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Le lien youtube est invalide");
                isOk = false;
            }
        }
        if($("#idDescription").val() === ""){
            $("#mceu_26").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une description");
            isOk = false;
        }
        if($("#idNew_image_pochette").val() === ""){ 
            if(!$("#idImage_pochette").length){
                $("#idNew_image_pochette").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Veuillez selectionner une image");
                isOk = false;
            }
        } else if(contSensChars($("#idNew_image_pochette").val())){
            $("#idNew_image_pochette").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image contient au moins un caractère sensible");
            isOk = false;
        } else if($("#idNew_image_pochette").val().length > max_str_len){
            $("#idNew_image_pochette").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image est trop long");
            isOk = false;
        } else if(!verifExtImg($("#idNew_image_pochette").val())){
            $("#idNew_image_pochette").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("les extensions valides pour l'image sont jpg, jpeg, png");
            isOk = false;
        } else if(!isImage(objFileImg)){
            $("#idNew_image_pochette").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le fichier n'est pas une image");
            isOk = false;        
        } else if(objFileImg.size > max_img_size){
            $("#idNew_image_pochette").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("l'image est trop lourde");
            isOk = false;  
        }
        if($("#idNew_download").val() !== ""){
            if(contSensChars($("#idNew_download").val())){
                $("#idNew_download").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("le nom du fichier rar contient au moins un caractère sensible");
                isOk = false;
            } else if($("#idNew_download").val().length > max_str_len){
                $("#idNew_download").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("le nom du fichier rar est trop long");
                isOk = false;
            } else if(!verifExtRar($("#idNew_download").val())){
                $("#idNew_download").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("l'extension valide pour le fichier est rar");
                isOk = false;
            } else if(!isRar(objFileRar)){
                $("#idNew_download").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("le fichier n'est pas un .rar");
                isOk = false;        
            } else if(objFileRar.size > max_rar_size){
                $("#idNew_download").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("le fichier rar est trop lourd");
                isOk = false;  
            }
        }
        $(".loader").show("slow");
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $(".loader").hide("slow");
            $("#jqInfos").show("slow");
        }
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire gestionArtistes--------------------*/              
    $("#saveFormArt").submit(function(event){
        var isOk = true;
        tinymce.triggerSave(true, true);
        var objFile = document.getElementById("idNew_image_artiste").files[0];
        if($("#idNom").val() === ""){
            $("#idNom").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un nom");
            isOk = false;
        }
        if($("#idLien").val() === ""){
            $("#idLien").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un lien");        
            isOk = false;
        } else if(!isUrl($("#idLien").val())){
            $("#idLien").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("L'adresse du lien est invalide");
            isOk = false;
        }
        if($("#idBio").val() === ""){
            $("#mceu_26").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une bio");
            isOk = false;
        }
        if($("#idNew_image_artiste").val() === ""){ 
            if(!$("#idImage_artiste").length){
                $("#idNew_image_artiste").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Veuillez selectionner une image");
                isOk = false;
            }
        } else if(contSensChars($("#idNew_image_artiste").val())){
            $("#idNew_image_artiste").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image contient au moins un caractère sensible");
            isOk = false;
        } else if($("#idNew_image_artiste").val().length > max_str_len){
            $("#idNew_image_artiste").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image est trop long");
            isOk = false;
        } else if(!verifExtImg($("#idNew_image_artiste").val())){
            $("#idNew_image_artiste").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("les extensions valides pour l'image sont jpg, jpeg, png");
            isOk = false;
        } else if(!isImage(objFile)){
            $("#idNew_image_artiste").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le fichier n'est pas une image");
            isOk = false;        
        } else if(objFile.size > max_img_size){
            $("#idNew_image_artiste").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le fichier est trop lourd");
            isOk = false;  
        }
        if($("#idProd").val() == 0){
            $("#idProd").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner la/les production(s) de cet artiste");
            isOk = false;
        }
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $("#jqInfos").show("slow");
        }        
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire gestionEvents----------------------*/              
    $("#saveFormEvt").submit(function(event){
        var isOk = true;
        tinymce.triggerSave(true, true);
        var objFile = document.getElementById("idNew_image_event").files[0];
        if($("#idTitre").val() === ""){
            $("#idTitre").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un titre");
            isOk = false;
        }
        if($("#idDate").val() === ""){
            $("#idDate").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une date");        
            isOk = false;
        } else if(!isDate($("#idDate").val())){
            $("#idDate").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("la date est invalide");
            isOk = false;
        }
        if($("#idDescription").val() === ""){
            $("#mceu_26").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner une description");
            isOk = false;
        }
        if($("#idNew_image_event").val() === ""){ 
            if(!$("#idImage_event").length){
                $("#idNew_image_event").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("Veuillez selectionner une image");
                isOk = false;
            }
        } else if(contSensChars($("#idNew_image_event").val())){
            $("#idNew_image_event").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image contient au moins un caractère sensible");
            isOk = false;
        } else if($("#idNew_image_event").val().length > max_str_len){
            $("#idNew_image_event").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le nom de l'image est trop long");
            isOk = false;
        } else if(!verifExtImg($("#idNew_image_event").val())){
            $("#idNew_image_event").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("les extensions valides pour l'image sont jpg, jpeg, png");
            isOk = false;
        } else if(!isImage(objFile)){
            $("#idNew_image_event").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le fichier n'est pas une image");
            isOk = false;        
        } else if(objFile.size > max_img_size){
            $("#idNew_image_event").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("le fichier est trop lourd");
            isOk = false;  
        }
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $("#jqInfos").show("slow");
        }        
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire clients----------------------------*/
    $("#saveFormClient").submit(function(event){
        var isOk = true;
        if($("#idNom").val() === ""){
            $("#idNom").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un nom");
            isOk = false;
        }
        if($("#idMail").val() !== ""){
            if(!isMail($("#idMail").val())){
                $("#idMail").css("border", "3px solid #d9534f");
                $("#jqInfos > span").html("L'adresse mail n'est pas valide");
                isOk = false;
            }
        }
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $("#jqInfos").show("slow");
        } 
    });
/*------------------------------------------------------------------------------exemplaires--------------------------------------------------------------*/
    $(".etatExpl").each(function(){
        var value = parseInt($(this).val());
        colorTr(value, $(this));
    });
    
    $(".etatExpl").change(function(){
        var value = parseInt($(this).val());
        colorTr(value, $(this));
    });
    
    $(".tabExpl tbody tr").focusin(function(){
        $(this).css("border", "2px solid #337ab7");
    });
        
    $(".tabExpl tbody tr").focusout(function(){
        $(this).css("border", "1px solid whitesmoke");
    });
    
    $("#printButt").click(function(){
        window.print();
        $(this).css({border: "none", width: "48px", height: '30px'});        
    });
    
    copyBuffer = new Array();
    $("#copyButt").click(function(){       
        $("input[name=copy]:checked").closest("tr")
                                     .find("input:not(.num), select, textarea")
                                     .each(function(){
                                        var name = $(this).attr("name").split("-"); 
                                        copyBuffer[name[0]] = $(this).val();
                                     });
        $("input[name=copy]:checked").attr('checked', false);
        $("input[name=copy]").attr({type: 'checkbox',
                                    name: 'paste'});                                                                      
    });

    $("#pasteButt").click(function(){
        $("input[name=paste]:checked").closest("tr")
                                      .find("input:not(.num), select, textarea")
                                      .each(function(){
                                        var name = $(this).attr("name").split("-");
                                        $(this).val(copyBuffer[name[0]]);
                                        if($(this).attr("class") === "form-control fieldSel etatExpl"){
                                            colorTr($(this).val(), $(this));
                                        }
                                      });
        $("input[name=paste]:checked").attr('checked', false);
        $("input[name=paste]").attr({type: 'radio',
                                     name: 'copy'});
    });
    
    $(".boutonFixed").hide();
    $(window).scroll(function(){
        var valShow = (parseInt($(".infosGestion").css("height")) + parseInt($(".research").css("height")) + parseInt($("header").css("height")) + (parseInt($(".menuGeneral").css("height")) * 2)) - 300;
        if ($(window).scrollTop() > valShow){
            $(".boutonFixed").fadeIn();
        } else {
            $(".boutonFixed").fadeOut();
        }        
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire exemplaires------------------------*/
    $("#saveFormEx").submit(function(event){
        var isOk = true;
        $(".exPrix").each(function(){
            var numExPrix = $(this).closest("tr").find(".num").val();
            if($(this).val() !== ""){
                if(!validPrice($(this).val())){
                    $(this).css("border", "3px solid #d9534f");
                    $("#jqInfos > span").html("Le prix de l'exemplaire numéro " + numExPrix + " est invalide");        
                    isOk = false;
                }
            }
        });
        $(".exMontantFdp").each(function(){
            var numExMontFdp = $(this).closest("tr").find(".num").val();
            if($(this).val() !== ""){
                if(!validPrice($(this).val())){
                    $(this).css("border", "3px solid #d9534f");
                    $("#jqInfos > span").html("Le montant des frais de port de l'exemplaire numéro " + numExMontFdp + " est invalide");        
                    isOk = false;
                }
            }
        });
        $(".exDate").each(function(){
            if($(this).val() !== ""){
                if(!isDate($(this).val())){
                    var numExDate = $(this).closest("tr").find(".num").val();
                    $(this).css("border", "3px solid #d9534f");
                    $("#jqInfos > span").html("La date de l'exemplaire numéro " + numExDate + " est invalide");        
                    isOk = false;
                }
            }
        });
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $("#jqInfos").show("slow");
        }
    });
/*------------------------------------------------------------------------------verifications des infos du formulaire admins-----------------------------*/      
    $("#saveFormAdm").submit(function(event){
        var isOk = true;        
        if($("#idNom").val() === ""){
            $("#idNom").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un nom");
            isOk = false;
        }
        if($("#idIdent").val() === ""){
            $("#idIdent").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un identifiant");        
            isOk = false;
        }
        if($("#idMdp").val() === ""){  
            $("#idMdp").css("border", "3px solid #d9534f");
            $("#jqInfos > span").html("Veuillez renseigner un mot de passe");
            isOk = false;
        }
        if(!isOk){
            event.preventDefault();
            $("html, body").animate({scrollTop:0}, "slow");
            $("#jqInfos").show("slow");
        }        
    });
});


