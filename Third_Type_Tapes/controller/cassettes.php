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
            $d['cassettes'] = $this->$model->getAllInfos(array('id' => $id));
            $this->set($d);            
            $s['shipInfos'] = $this->frais_de_port->findAll();
            $this->set($s);
            $i['id']['min'] = $this->$model->getIdMaxMin("MIN")["min"];
            $i['id']['max'] = $this->$model->getIdMaxMin("MAX")["max"];
            $this->set($i);
            if($id > $i['id']['min']){
                $sous = -1;
                do {
                    $idPrev = $id + $sous;
                    $dPrev['cassPrev'] = $this->$model->getAllInfos(array('id' => $idPrev));
                    $sous -= 1;
                } while(!$dPrev['cassPrev']);
                $dPrev['cassPrev'] = $dPrev['cassPrev'][0];
                $this->set($dPrev);
            }
            if($id < $i['id']['max']){
                $add = 1;
                do {
                    $idNext = $id + $add;
                    $dNext['cassNext'] = $this->$model->getAllInfos(array('id' => $idNext));
                    $add += 1;
                } while(!$dNext['cassNext']);                
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

