<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: labels.php
 */

class Labels extends Controller{
    var $models = array('label');
    
    public function index(){
        $this->render('index');
    }    
}
