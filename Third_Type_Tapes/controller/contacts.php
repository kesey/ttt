<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: contacts.php
 */

class Contacts extends Controller{ 
    var $models = array('contact');
    
    public function index(){
        $this->render('index');
    }    
}

