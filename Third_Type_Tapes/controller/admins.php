<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: admins.php
 */

class Admins extends Controller{
    
    var $models = array('admin');
    
    // effectue une recherche dans un champ 
    public function search(){
        $model = $this->models[0];
        $field = $this->data['field'];
        $what = $this->data['recherche'];
        if(!empty($what)){
            $d['searchResults'] = $this->$model->search(array('field' => $field,
                                                               'what'  => $what));
            $this->set($d);           
        }
    }
    
    // récupère les infos d'un élément
    public function details(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_admin'])){
            $this->$model->id = $this->data['id_admin'];
            $this->$model->read();
            $d['detailsAdm']['id_admin'] = $this->$model->id_admin;
            $d['detailsAdm']['nom'] = $this->$model->nom;
            $d['detailsAdm']['identifiant'] = $this->$model->identifiant;
            $d['detailsAdm']['mot_de_passe'] = $this->$model->mot_de_passe;
            $this->set($d);
        }
    }
    
    // archive l'élément séléctionné
    public function archive(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_admin'])){
            $this->$model->archive($this->data['id_admin']);
        }
    }
    
    // sauvegarde les informations
    public function save() {
        $model = $this->models[0];
        unset($this->data['action']);    
        if($this->$model->verifications($this->data)){
            $this->$model->save($this->data);
        }
    }
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $d['admins'] = $this->$model->findAll(array("fields" => "id_admin,nom,identifiant,mot_de_passe"));
        $this->set($d);
        $this->render('index');
    } 
}

