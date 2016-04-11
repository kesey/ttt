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
            $d['artiste'] = $this->$model->getAllInfos(array('id' => $id));
            $this->set($d);            
            $i['id']['min'] = $this->$model->getDataMaxMin("id_artiste", "MIN")["min"];
            $i['id']['max'] = $this->$model->getDataMaxMin("id_artiste", "MAX")["max"];
            $this->set($i);
            if($id > $i['id']['min']){
                $dPrev['artPrev'] = $this->$model->getAllInfos(array("conditions" => $model.".id_artiste < ".$d['artiste'][0]['id_artiste'],
                                                                      "order" => "id_artiste DESC",
                                                                      "limit" => 1));
                $dPrev['artPrev'] = $dPrev['artPrev'][0];
                $this->set($dPrev);
            }
            if($id < $i['id']['max']){
                $dNext['artNext'] = $this->$model->getAllInfos(array("conditions" => $model.".id_artiste > ".$d['artiste'][0]['id_artiste'],
                                                                      "order" => "id_artiste ASC",
                                                                      "limit" => 1));
                $dNext['artNext'] = $dNext['artNext'][0];
                $this->set($dNext);
            }
            $this->render('view');
        } else {
            require(ROOT."view/erreur404.php");
        }
    }
}

