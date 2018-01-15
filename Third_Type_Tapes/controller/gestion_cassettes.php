<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: gestionCassettes.php
 */

class Gestion_cassettes extends Controller{
    
    var $models = array('cassette', 'admin', 'exemplaire');
    
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
                    $d['searchResults'][$key]['date_sortie'] = $this->$model->dateFr($value['date_sortie']);
                }
            }
            $this->set($d);           
        }
    }
    
    // récupère les infos d'un élément
    public function details(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_cassette'])){
            $this->$model->id = $this->data['id_cassette'];
            $this->$model->read();
            $d['detailsCass']['id_cassette'] = $this->$model->id_cassette;
            $d['detailsCass']['titre'] = $this->$model->titre;
            $d['detailsCass']['date_sortie'] = $this->$model->dateFr($this->$model->date_sortie);
            $d['detailsCass']['code'] = $this->$model->code;
            $d['detailsCass']['longueur'] = $this->$model->longueur;
            $d['detailsCass']['prix'] = $this->$model->prix;
            $d['detailsCass']['lien_bandcamp'] = $this->$model->lien_bandcamp;
            $d['detailsCass']['lien_soundcloud'] = $this->$model->lien_soundcloud;
            $d['detailsCass']['lien_youtube'] = $this->$model->lien_youtube;
            $d['detailsCass']['description'] = $this->$model->description;
            $d['detailsCass']['download'] = $this->$model->download;
            $d['detailsCass']['image_pochette'] = $this->$model->image_pochette;
            $d['detailsCass']['nombre_de_download'] = $this->$model->nombre_de_download;
            $this->set($d);
        }
    }
    
    // archive l'élément séléctionné
    public function archive(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_cassette'])){
            $this->$model->archive($this->data['id_cassette']);
        }
    }
    
    // sauvegarde les informations
    public function save() {
        $model = $this->models[0];
        $modelEx = $this->models[2];
        unset($this->data['action']);        
        if($this->$model->verifications($this->data, $this->files['new_image_pochette'])){
            $this->data['date_sortie'] = $this->$model->dateUs($this->data['date_sortie']);
            $this->data['titre'] = $this->$model->noSensChars($this->data['titre']);
            if(empty($this->data['prix'])){ unset($this->data['prix']); }
            $actualImg = isset($this->data['image_pochette']) ? $this->data['image_pochette'] : 0;
            $uploadImgOk = FALSE;
            if($this->$model->verifFile($this->files['new_image_pochette'])){
                if(file_exists(ROOT.'images/'.$model.'/'.$actualImg)){
                    $this->$model->delete_file($actualImg, 'images', $model);
                }
                if($this->$model->upload_file($this->files['new_image_pochette']['tmp_name'], $this->files['new_image_pochette']['name'], 'images', $model)){
                    $this->data['image_pochette'] = $this->files['new_image_pochette']['name'];
                    $uploadImgOk = TRUE;
                }
            }
            $actualRar = isset($this->data['download']) ? $this->data['download'] : 0;
            if($this->$model->verifRar($this->files['new_download'])){
                if(file_exists(ROOT.'fichiers/'.$actualRar)){
                    $this->$model->delete_file($actualRar, 'fichiers');
                }
                if($this->$model->upload_file($this->files['new_download']['tmp_name'], $this->files['new_download']['name'], 'fichiers')){
                    $this->data['download'] = $this->files['new_download']['name'];
                }
            }
            if($actualImg || $uploadImgOk){
                $success = $this->$model->save($this->data);
                if($success && empty($this->data['id_cassette'])){           
                    $creaEx = array("id_cassette" => $this->$model->id,
                                        "id_etat" => 1,
                                      "id_client" => 32);                              
                    for($i = 1; $i <= 75; $i++){
                        $addTab = array("numero_exemplaire" => $i);
                        $dataCreaEx = array_merge($creaEx, $addTab);
                        $this->$modelEx->save($dataCreaEx);    
                    }
                }                
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
        $d['cassettes'] = $this->$model->findAll(array('order' => 'date_sortie DESC'));
        foreach ($d['cassettes'] as $key => $value){
            $d['cassettes'][$key]['date_sortie'] = $this->$model->dateFr($value['date_sortie']);
        } 
        $this->set($d);
        $this->render('index');
    }    
}

