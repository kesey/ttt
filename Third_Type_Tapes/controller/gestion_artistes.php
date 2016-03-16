<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: gestionEvents.php
 */

class Gestion_artistes extends Controller{
    
    var $models = array('artiste', 'admin', 'produire', 'cassette');
    
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
        $modelProd = $this->models[2];
        $modelCass = $this->models[3];
        if($this->$model->exist('id_'.$model,$this->data['id_artiste'])){
            $this->$model->id = $this->data['id_artiste'];
            $this->$model->read();
            $d['detailsArt']['id_artiste'] = $this->$model->id_artiste;
            $d['detailsArt']['nom'] = $this->$model->nom;            
            $d['detailsArt']['lien_artiste'] = $this->$model->lien_artiste;
            $d['detailsArt']['bio'] = $this->$model->bio;
            $d['detailsArt']['image_artiste'] = $this->$model->image_artiste;
            $d['detailsArt']['prodArt'] = $this->$modelProd->findAll(array('conditions' => 'id_artiste = '.$this->$model->id_artiste,
                                                                                'order' => 'id_cassette DESC'));
            $d['allProd'] = $this->$modelCass->findAll(array('fields' => 'id_cassette, titre'));                                                                          
            $this->set($d);
        }
    }
    
    // archive l'élément séléctionné
    public function archive(){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$this->data['id_artiste'])){
            $this->$model->archive($this->data['id_artiste']);
        }
    }
    
    // sauvegarde les informations
    public function save() {
        $model = $this->models[0];
        $modelProd = $this->models[2];
        unset($this->data['action']);        
        if($this->$model->verifications($this->data, $this->files['new_image_artiste'])){
            $this->data['nom'] = $this->$model->noSensChars($this->data['nom']);
            $actualImg = isset($this->data['image_artiste']) ? $this->data['image_artiste'] : 0;
            $uploadOk = FALSE;
            if($this->$model->verifFile($this->files['new_image_artiste'])){
                if(file_exists(ROOT.'images/'.$model.'/'.$actualImg)){
                    $this->$model->delete_file($actualImg, 'images', $model);
                }
                if($this->$model->upload_file($this->files['new_image_artiste']['tmp_name'], $this->files['new_image_artiste']['name'], 'images', $model)){
                    $this->data['image_artiste'] = $this->files['new_image_artiste']['name'];
                    $uploadOk = TRUE;
                }
            }          
            if($this->$modelProd->verifProd($this->data['productions'])){
                $productions = $this->data['productions'];
                unset($this->data['productions']);
                if($actualImg || $uploadOk){
                    $this->$model->save($this->data);
                }            
                if($this->$model->exist('id_'.$model,$this->data['id_artiste'])){
                    $idArt = $this->data['id_artiste'];
                    $this->$modelProd->deleteProd($idArt);
                } else {
                    $idArt = $this->$model->findAll(array('fields' => 'id_artiste',
                                                      'conditions' => "nom = '".$this->data['nom']."'"));
                    $idArt = $idArt[0]['id_artiste'];
                }
                foreach ($productions as $idCass) {                
                    $tabProduire['id_cassette'] = $idCass;
                    $tabProduire['id_artiste'] = $idArt;
                    $this->$modelProd->save($tabProduire);
                }
            }
        }
    }
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $modelAdm = $this->models[1];
        $modelCass = $this->models[3];
        $d['admins'] = $this->$modelAdm->findAll(array('fields' => 'nom'));
        foreach ($d['admins'] as $key => $value){
            $d['admins'][$key] = $value['nom'];
        }
        $d['artistes'] = $this->$model->findAll();
        $d['allProd'] = $this->$modelCass->findAll(array('fields' => 'id_cassette, titre'));
        $this->set($d);
        $this->render('index');
    }    
}

