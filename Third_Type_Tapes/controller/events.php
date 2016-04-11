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
            $d['event'] = $this->$model->findAll(array("conditions" => "id_".$model." = '".$id."'"));
            $d['event'] = $d['event'][0];
            $d['event']['date_event_fr'] = $this->$model->dateFr($d['event']['date_event']); 
            $d['event']['lieu'] = $this->$model->adresseGMaps($d['event']['lieu']);
            $this->set($d);
            $i['date']['min'] = $this->$model->getDataMaxMin("date_event", "MIN")["min"];
            $i['date']['max'] = $this->$model->getDataMaxMin("date_event", "MAX")["max"];            
            $this->set($i);
            if($d['event']['date_event'] > $i['date']['min']){
                $dPrev['eventPrev'] = $this->$model->findAll(array("conditions" => "date_".$model." <= '".$d['event']['date_event']."' AND id_".$model." != ".$id,
                                                                   "order" => "date_".$model." DESC, id_".$model." DESC",
                                                                   "limit" => 1));
                $dPrev['eventPrev'] = $dPrev['eventPrev'][0];
                $dPrev['eventPrev']['date_event_fr'] = $this->$model->dateFr($dPrev['eventPrev']['date_event']);
                $this->set($dPrev);
            }
            if($d['event']['date_event'] < $i['date']['max']){
                $dNext['eventNext'] = $this->$model->findAll(array("conditions" => "date_".$model." >= '".$d['event']['date_event']."' AND id_".$model." != ".$id,
                                                                   "order" => "date_".$model." ASC, id_".$model." ASC",
                                                                   "limit" => 1));
                                                   
                $dNext['eventNext'] = $dNext['eventNext'][0];
                $dNext['eventNext']['date_event_fr'] = $this->$model->dateFr($dNext['eventNext']['date_event']);
                $this->set($dNext);
            }            
            $this->render('view');
        } else {
            require(ROOT."view/erreur404.php");
        }
    }
}

