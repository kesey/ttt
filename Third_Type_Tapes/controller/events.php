<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: events.php
 */

class Events extends Controller{
    
    var $models = array('event');
    
    // affiche tous les éléments 
    public function index(){
        $model = $this->models[0];
        $d['events'] = $this->$model->findAll(array("order" => "date_event DESC"));        
        foreach ($d['events'] as $key => $event){
            $d['events'][$key]['date_event'] = $this->$model->dateFr($event['date_event']);
            $imgResize = explode('.', $d['events'][$key]['image_event']);
            $d['events'][$key]['image_event_resize'] = $imgResize[0].'-resize.'.$imgResize[1];
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
            $d['events'] = $this->$model->findAll(array("conditions" => "id_".$model." = '".$id."'"));
            $d['events'] = $d['events'][0];
            $d['events']['date_event'] = $this->$model->dateFr($d['events']['date_event']); 
            $d['events']['lieu'] = $this->$model->adresseGMaps($d['events']['lieu']);
            $this->set($d);
            $i['id']['min'] = $this->$model->getIdMaxMin("MIN")["min"];
            $i['id']['max'] = $this->$model->getIdMaxMin("MAX")["max"];            
            $this->set($i);
            if($id > $i['id']['min']){
                $sous = -1;
                do {
                    $idPrev = $id + $sous;
                    $dPrev['eventPrev'] = $this->$model->findAll(array("conditions" => "id_".$model." = ".$idPrev));
                    $sous -= 1;
                } while(!$dPrev['eventPrev']);                                
                $dPrev['eventPrev'] = $dPrev['eventPrev'][0];
                $this->set($dPrev);
            }
            if($id < $i['id']['max']){
                $add = 1;
                do {
                    $idNext = $id + $add;
                    $dNext['eventNext'] = $this->$model->findAll(array("conditions" => "id_".$model." = ".$idNext));
                    $add += 1;
                } while(!$dNext['eventNext']);                               
                $dNext['eventNext'] = $dNext['eventNext'][0];
                $this->set($dNext);
            }            
            $this->render('view');
        } else {
            require(ROOT."view/erreur404.php");
        }
    }
}

