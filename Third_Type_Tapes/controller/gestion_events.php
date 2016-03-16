<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: gestionEvents.php
 */

class Gestion_events extends Controller{
    
    var $models = array('event', 'admin');
    
    // effectue une recherche dans un champ
    public function search(){
        $model = $this->models[0];
        $field = $this->data['field'];
        $what = $this->data['recherche'];
        if(!empty($what) && !empty($field)){
            if($this->$model->isDateUsFr($what)){
                $what = $this->$model->dateUs($what);
            }
            $d['searchResults'] = $this->$model->search(array('field' => $field,
                                                               'what'  => $what));
            if($d['searchResults']){
                foreach ($d['searchResults'] as $key => $value){
                    $d['searchResults'][$key]['date_event'] = $this->$model->dateFr($value['date_event']);
                }
            }
            $this->set($d);           
        }
    }
    
    // récupère les infos d'un élément
    public function details(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_event'])){
            $this->$model->id = $this->data['id_event'];
            $this->$model->read();
            $d['detailsEvt']['id_event'] = $this->$model->id_event;
            $d['detailsEvt']['titre_event'] = $this->$model->titre_event;
            $d['detailsEvt']['date_event'] = $this->$model->dateFr($this->$model->date_event);
            $d['detailsEvt']['lieu'] = $this->$model->lieu;
            $d['detailsEvt']['description_event'] = $this->$model->description_event;
            $d['detailsEvt']['image_event'] = $this->$model->image_event;
            $this->set($d);
        }
    }
    
    // archive l'élément séléctionné
    public function archive(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_event'])){
            $this->$model->archive($this->data['id_event']);
        }
    }
    
    // sauvegarde les informations
    public function save() {
        $model = $this->models[0];
        unset($this->data['action']);        
        if($this->$model->verifications($this->data, $this->files['new_image_event'])){
            $this->data['date_event'] = $this->$model->dateUs($this->data['date_event']);
            $this->data['titre_event'] = $this->$model->noSensChars($this->data['titre_event']);
            $actualImg = isset($this->data['image_event']) ? $this->data['image_event'] : 0;
            $uploadOk = FALSE;
            if($this->$model->verifFile($this->files['new_image_event'])){
                if(file_exists(ROOT.'images/'.$model.'/'.$actualImg)){
                    $this->$model->delete_file($actualImg, 'images', $model);
                }
                if($this->$model->upload_file($this->files['new_image_event']['tmp_name'], $this->files['new_image_event']['name'], 'images', $model)){
                    $this->data['image_event'] = $this->files['new_image_event']['name'];
                    $uploadOk = TRUE;
                }
            }
            if($actualImg || $uploadOk){
                $this->$model->save($this->data);
            }
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
        $d['events'] = $this->$model->findAll(array('order' => 'date_event DESC'));
        foreach ($d['events'] as $key => $value){
            $d['events'][$key]['date_event'] = $this->$model->dateFr($value['date_event']);
        } 
        $this->set($d);
        $this->render('index');
    }    
}