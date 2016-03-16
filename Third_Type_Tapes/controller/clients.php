<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: clients.php
 */

class Clients extends Controller{
    
    var $models = array('client', 'admin');
    
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
        if($this->$model->exist('id_'.$model,$this->data['id_client'])){
            $this->$model->id = $this->data['id_client'];
            $this->$model->read();
            $d['detailsClient']['id_client'] = $this->$model->id_client;
            $d['detailsClient']['nom_client'] = $this->$model->nom_client;
            $d['detailsClient']['mail_client'] = $this->$model->mail_client;
            $d['detailsClient']['adresse_client'] = $this->$model->adresse_client;
            $this->set($d);
        }
    }
    
    // archive l'élément séléctionné
    public function archive(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_client'])){
            $this->$model->archive($this->data['id_client']);
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
        $modelAdm = $this->models[1];
        $d['admins'] = $this->$modelAdm->findAll(array('fields' => 'nom'));
        foreach ($d['admins'] as $key => $value){
            $d['admins'][$key] = $value['nom'];
        }
        $d['clients'] = $this->$model->findAll(array('order' => 'nom_client ASC'));
        $this->set($d);
        $this->render('index');
    }    
}

