<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: links.php
 */

class Links extends Controller{   
    var $models = array('artiste');
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $d['artistes'] = $this->$model->findAll();
        $this->set($d);
        $this->render('index');
    }    
}

