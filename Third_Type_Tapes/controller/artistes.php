<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: artistes.php
 */

class Artistes extends Controller{
    
    var $models = array('artiste');
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $d['artistes'] = $this->$model->getAllInfos(array('groupBy' => "id_".$model));
        $length = sizeof($d['artistes']);
        for ($i = 0; $i < $length; $i++) {
            $imgResize = explode('.', $d['artistes'][$i]['image_artiste']);
            $d['artistes'][$i]['image_artiste_resize'] = $imgResize[0].'-resize.'.$imgResize[1];
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
            $d['artistes'] = $this->$model->getAllInfos(array('id' => $id));
            $this->set($d);            
            $i['id']['min'] = $this->$model->getIdMaxMin("MIN")["min"];
            $i['id']['max'] = $this->$model->getIdMaxMin("MAX")["max"];
            $this->set($i);
            if($id > $i['id']['min']){
                $sous = -1;
                do {
                    $idPrev = $id + $sous;
                    $dPrev['artPrev'] = $this->$model->getAllInfos(array('id' => $idPrev));
                    $sous -= 1;
                } while(!$dPrev['artPrev']); 
                $dPrev['artPrev'] = $dPrev['artPrev'][0];
                $this->set($dPrev);
            }
            if($id < $i['id']['max']){
                $add = 1;
                do {
                    $idNext = $id + $add;
                    $dNext['artNext'] = $this->$model->getAllInfos(array('id' => $idNext));
                    $add += 1;
                } while(!$dNext['artNext']);
                $dNext['artNext'] = $dNext['artNext'][0];
                $this->set($dNext);
            }
            $this->render('view');
        } else {
            require(ROOT."view/erreur404.php");
        }
    }
}

