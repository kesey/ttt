<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/
 * NAME: index.php
 */

$urlTab = explode('/', $_SERVER['REQUEST_URI']);
$replace = array("index.php" => "cassettes",
                       "%20" => " ",
                       "%27" => "'", 
                       "%22" => '"');
$refTitre = strtr(end($urlTab), $replace);
define('TITLE', $refTitre);
define('WEBROOT', str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('MAX_IMG_SIZE', 2097152);
define('MAX_RAR_SIZE', 524288000);
define('MAX_STR_LEN', 40);
define('NBRE_EX', 75);

require(ROOT."core/core.php");
require(ROOT."core/controller.php");

if(isset($_SESSION['info'])){
    unset($_SESSION['info']);
}
if(isset($_SESSION['infoSave'])){
    unset($_SESSION['infoSave']);
}
if(isset($_SESSION['infoLog'])){
    unset($_SESSION['infoLog']);
}

if(isset($_GET['p'])){
    $par = htmlspecialchars($_GET['p']);
} else {
    //controller par défaut
    $par = 'cassettes';
}

$parametres = explode('/', $par);

if(!$parametres[0]){
    //quand on arrive sur la page la première fois
    $parametres[0] = 'cassettes';
}

//vérification de l'existence du controleur
$tabFiles = scandir(ROOT.'controller');
foreach ($tabFiles as $key => $value){
    if($value == '.' || $value == '..'){        
        unset($tabFiles[$key]);
    }
}
$tabControllers = str_replace('.php','',$tabFiles);
if(in_array($parametres[0], $tabControllers)){
    $controller = $parametres[0];
    
    $action = isset($parametres[1]) ? $parametres[1] : 'index';//action par défaut

    require(ROOT.'controller/'.strtolower($controller).'.php');
    $controller = new $controller();
    
    if(!empty($_POST)){
        $actPost = isset($_POST['action']) ? $_POST['action'] : "";
        if(method_exists($controller, $actPost)){            
            $controller->$actPost();
        }
    }

    if(method_exists($controller, $action)){
        array_splice($parametres, 3);   
        unset($parametres[0]);
        unset($parametres[1]);    
        call_user_func_array(array($controller, $action), $parametres);
    } else {
        require(ROOT."view/erreur404.php");
    }
} else {
    require(ROOT."view/erreur404.php");
}
