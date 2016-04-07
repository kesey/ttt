<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/controller/
 * NAME: exemplaires.php
 */

class Exemplaires extends Controller{
    
    var $models = array('exemplaire', 'admin', 'cassette', 'etat_exemplaire', 'client');
    
    // effectue une recherche dans un champ
    public function search(){
        $modelCass = $this->models[2];
        $field = $this->data['field'];
        $what = $this->data['recherche'];
        if(!empty($what) && !empty($field)){
            if($this->$modelCass->isDateUsFr($what)){
                $what = $this->$modelCass->dateUs($what);
            }
            $d['searchResults'] = $this->$modelCass->search(array('field' => $field,
                                                                  'what'  => $what));
            if($d['searchResults']){
                foreach ($d['searchResults'] as $key => $value){
                    $d['searchResults'][$key]['date_sortie'] = $this->$modelCass->dateFr($value['date_sortie']);
                }
            }
            $this->set($d);           
        }
    }
    
    // reorganise l'ordre d'affichage des infos
    public function order(){
        $acceptOrd = array('ASC', 'DESC');
        $acceptFld = array('numero_exemplaire', 'id_etat', 'localite_exemplaire', 'id_vendeur', 'prix_vente_euros', 'vente_remboursee', 'id_client', 'date_vente', 'montant_frais_de_port', 'frais_de_port_rembourses', 'commentaire');
        if(in_array($this->data['order'], $acceptOrd) && in_array($this->data['field'], $acceptFld)){
            $ordre = $this->data['field'].' '.$this->data['order'];
            $this->details($ordre);
        }        
    }

    private function getAdmins(){
        $modelAdm = $this->models[1];
        $admins = $this->$modelAdm->findAll(array('fields' => 'nom, id_admin'));
        return $admins;
    }

    private function ventes($who, $id){
        $model = $this->models[0];
        $d['ventes'][$who] = $this->$model->findAll(array("fields" => "SUM(prix_vente_euros) AS somme",
                                                      "conditions" => "id_vendeur = ".$id." AND id_cassette = ".$this->data['id_cassette']));
        $d['ventes'][$who] = $d['ventes'][$who][0];
        return $d['ventes'][$who];
    }

    private function compta($who, $id){
        $model = $this->models[0];
        $d['compta'][$who]['recupere'] = $this->$model->findAll(array("fields" => "SUM(montant_frais_de_port) AS somme",
                                                                  "conditions" => "id_vendeur = ".$id." AND frais_de_port_rembourses = 0 AND id_cassette = ".$this->data['id_cassette']));
        $d['compta'][$who]['recupere'] = $d['compta'][$who]['recupere'][0];
        $d['compta'][$who]['doit'] = $this->$model->findAll(array("fields" => "SUM(prix_vente_euros) AS somme",
                                                              "conditions" => "id_vendeur = ".$id." AND vente_remboursee = 0 AND (montant_frais_de_port = 0 OR montant_frais_de_port IS NULL) AND id_cassette = ".$this->data['id_cassette']));
        $d['compta'][$who]['doit'] = $d['compta'][$who]['doit'][0];
        return $d['compta'][$who];
    }
    
    // récupère les infos d'un élément
    public function details($ord = "numero_exemplaire ASC"){
        $model = $this->models[0];
        $modelCass = $this->models[2];
        $modelEtat = $this->models[3];
        $modelClient = $this->models[4];
        if($this->$model->exist('id_'.$modelCass,$this->data['id_cassette'])){
            $admins = $this->getAdmins();
            foreach ($admins as $key => $value){
                $d['ventes'][$value['nom']] = [];
                $d['compta'][$value['nom']] = [];
                /*----------------------------------------------------------------------compta & ventes individuelles----------------------------------------------------------------------------------------*/
                $d['ventes'][$value['nom']] = array_merge($d['ventes'][$value['nom']], $this->ventes($value['nom'], $value['id_admin']));
                $d['compta'][$value['nom']] = array_merge($d['compta'][$value['nom']], $this->compta($value['nom'], $value['id_admin']));
            }
            $d['dateTime'] = date("d-m-Y H:i:s");
        /*----------------------------------------------------------------------etat du stock----------------------------------------------------------------------------------------------------------------*/
            $d['stock'] = $this->$model->findAll(array("fields" => "COUNT(id_etat) AS enStock",
                                                   "conditions" => "id_etat = 1 AND id_cassette = ".$this->data['id_cassette']));
            $d['stock'] = $d['stock'][0];
            $d['depot'] = $this->$model->findAll(array("fields" => "COUNT(id_etat) AS enDepot",
                                                   "conditions" => "id_etat = 4 AND id_cassette = ".$this->data['id_cassette']));
            $d['depot'] = $d['depot'][0];
            $d['don'] = $this->$model->findAll(array("fields" => "COUNT(id_etat) AS donnes",
                                                 "conditions" => "id_etat = 5 AND id_cassette = ".$this->data['id_cassette']));
            $d['don'] = $d['don'][0];
            $d['noStock'] = $this->$model->findAll(array("fields" => "COUNT(id_etat) AS horsStock",
                                                 "conditions" => "id_etat = 3 AND id_cassette = ".$this->data['id_cassette']));
            $d['noStock'] = $d['noStock'][0];
            $d['vendus'] = NBRE_EX - ($d['stock']['enStock'] + $d['depot']['enDepot'] + $d['don']['donnes'] + $d['noStock']['horsStock']);
        /*----------------------------------------------------------------------compta general---------------------------------------------------------------------------------------------------------------*/        
            $d['total'] = $this->$model->findAll(array("fields" => "SUM(prix_vente_euros) AS somme",
                                                   "conditions" => "id_etat = 2 AND id_cassette = ".$this->data['id_cassette']));
            $d['total'] = $d['total'][0];
            $d['due'] = $this->$model->findAll(array("fields" => "SUM(montant_frais_de_port) AS somme",
                                                 "conditions" => "id_cassette = ".$this->data['id_cassette']));
            $d['due'] = $d['due'][0];
            $d['gainReel'] = $d['total']['somme'] - $d['due']['somme'];
        /*----------------------------------------------------------------------infos------------------------------------------------------------------------------------------------------------------------*/        
            $d['exemplaires'] = $this->$model->findAll(array("order" => $ord,
                                                        "conditions" => "id_cassette = ".$this->data['id_cassette']));
            foreach ($d['exemplaires'] as $key => $value){
                if($value['date_vente']){
                    $d['exemplaires'][$key]['date_vente'] = $this->$model->dateFr($value['date_vente']);
                }
            }
            $d['vendeurs'] = $this->getAdmins();
            $d['infosCassette'] = $this->$modelCass->findAll(array("fields" => "id_cassette, titre, code, nombre_de_download",
                                                               "conditions" => "id_cassette = ".$this->data['id_cassette']));
            $d['infosCassette'] = $d['infosCassette'][0];
            $d['etats'] = $this->$modelEtat->findAll(array("order" => "id_etat_exemplaire ASC"));
            $d['clients'] = $this->$modelClient->findAll(array("order" => "nom_client ASC"));            
        }
        $this->set($d);
    }
    
    // sauvegarde les informations
    public function save(){
        $model = $this->models[0];
        $modelCass = $this->models[2];
        unset($this->data['action']);
        if(isset($this->data['copy'])){
            unset($this->data['copy']);
        } else if(isset($this->data['paste'])){
            unset($this->data['paste']);
        }
        $idCass = $this->data['id_cassette'];
        unset($this->data['id_cassette']);        
        foreach($this->data as $key => $value){
            $decompName = explode('-', $key);
            $keyOk = $decompName[0];
            $idEx = $decompName[1];
            $data[$idEx][$keyOk] = $value;
        }
        unset($this->data);
        if($this->$model->verifications($data)){
            foreach($data as $k => $v){
                unset($data[$k]['numero_exemplaire']);
                if(!empty($data[$k]['date_vente'])){
                    $data[$k]['date_vente'] = $this->$model->dateUs($data[$k]['date_vente']);
                } else {
                    unset($data[$k]['date_vente']);
                }
                $this->$model->save($data[$k]);
            }
            $nbreExDispo = $this->$model->findAll(array("fields" => "COUNT(id_etat) AS dispo",
                                                    "conditions" => "id_etat = 1"));           
            if($nbreExDispo[0]['dispo'] != 0){
                $dispo = array("id_cassette" => $idCass,
                                  "sold_out" => 0);
                $this->$modelCass->save($dispo);   
            } else {
                $soldOut = array("id_cassette" => $idCass,
                                    "sold_out" => 1);
                $this->$modelCass->save($soldOut);
            }            
        }    
    }
    
    // affiche tous les éléments 
    public function index(){
        $modelCass = $this->models[2];
        $d['admins'] = $this->getAdmins();
        foreach ($d['admins'] as $key => $value){
            $d['admins'][$key] = $value['nom'];
        }
        $d['cassettes'] = $this->$modelCass->findAll(array("fields" => "id_cassette, code, titre",
                                                            "order" => "date_sortie DESC"));        
        $this->set($d);
        $this->render('index');
    }
}



