<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/core/
 * NAME: core.php
 */

session_start();
try{
    $db = new PDO("mysql:host=localhost;dbname=thirdtypetapes", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db->exec('SET sql_mode=""');
}
catch(Exception $e){
    die('Error : '.$e->getMessage());
}

require_once("core/model.php");

