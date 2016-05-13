<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: cassettes.php
 */

class Cassettes extends Controller{
    
    var $models = array('cassette', 'frais_de_port');
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $d['cassettes'] = $this->$model->getAllInfos(array('groupBy' => "id_".$model));
        $d['artistes'] = $this->$model->getAllInfos(array('fields' => "artiste.nom, cassette.id_cassette"));
        $length = sizeof($d['cassettes']);
        for ($i = 0; $i < $length; $i++) {
            $imgResize = explode('.', $d['cassettes'][$i]['image_pochette']);
            $d['cassettes'][$i]['image_pochette_resize'] = $imgResize[0].'-resize.'.$imgResize[1];
        }
        $this->set($d);
        $this->render('index');
    }
    
   /**
    *  affiche les détails d'un élément particulier
    *  @param int|string $id l'id de l'élément dont on souhaite visualiser les détails
    */
    public function view($id){
        $model = $this->models[0];
        if($this->$model->exist('id_'.$model,$id)){
            $d['cassette'] = $this->$model->getAllInfos(array('id' => $id));
            $this->set($d);            
            $s['shipInfos'] = $this->frais_de_port->findAll();
            $this->set($s);
            $i['date']['min'] = $this->$model->getDataMaxMin("date_sortie", "MIN")["min"];
            $i['date']['max'] = $this->$model->getDataMaxMin("date_sortie", "MAX")["max"];
            $this->set($i);
            if($d['cassette'][0]['date_sortie'] > $i['date']['min']){
                $dPrev['cassPrev'] = $this->$model->getAllInfos(array("conditions" => $model.".date_sortie <= '".$d['cassette'][0]['date_sortie']."' AND ".$model.".id_".$model." != ".$id,
                                                                      "order" => "date_sortie DESC, ".$model.".id_".$model." DESC",
                                                                      "limit" => 1));
                $dPrev['cassPrev'] = $dPrev['cassPrev'][0];
                $this->set($dPrev);
            }
            if($d['cassette'][0]['date_sortie'] < $i['date']['max']){
                $dNext['cassNext'] = $this->$model->getAllInfos(array("conditions" => $model.".date_sortie >= '".$d['cassette'][0]['date_sortie']."' AND ".$model.".id_".$model." != ".$id,
                                                                      "order" => "date_sortie ASC, ".$model.".id_".$model." ASC",
                                                                      "limit" => 1));                
                $dNext['cassNext'] = $dNext['cassNext'][0];
                $this->set($dNext);
            }
            $this->render('view');
        } else {
            require(ROOT."view/erreur404.php");
        }
    }
    
    // lance le telechargement d'un fichier 
    public function download(){
        $model = $this->models[0];
        $this->$model->telecharger_fichier($this->data['nomFichier']);
    }
}

