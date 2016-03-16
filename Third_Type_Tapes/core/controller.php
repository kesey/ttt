<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/core/
 * NAME: controller.php
 */

class Controller{
        
    protected $infos = array();
    var $layout = 'default';
    
    // instancie le(s) model(s) utile(s) et assigne les données passées en POST à un tableau $this->data
    function __construct() {
        if(isset($_POST)){
            $this->data = $_POST;
        }
        if(isset($_FILES)){
            $this->files = $_FILES;
        }
        if(isset($this->models)){
            foreach($this->models as $value){
                $this->loadModel($value);
            }
        }
    }
    
   /**
    *  stocke la/les donnée(s) utile(s) dans le tableau $infos 
    *  @param array $data  à stocker 
    */
    protected function set($data) {
        $this->infos = array_merge($this->infos,$data);
    }
    
   /**
    *  récupère la/les donnée(s) stockée(s) dans $infos et appelle la page à afficher
    *  @param string $fileName nom de la page à afficher
    */
    protected function render($fileName){
        extract($this->infos);
        ob_start();
        require(ROOT.'/view/'.get_class($this).'/'.$fileName.'.php');        
        $content_for_layout = ob_get_clean();
        if(!$this->layout){
            echo $content_for_layout;
        } else {
            require(ROOT.'/view/layout/'.$this->layout.'.php');
        }
    }
    
   /**
    *  instancie le model demandé et permet son utilisation sous forme d'objet  
    *  @param string $name nom du model à instancier
    */
    protected function loadModel($name){
        require_once(ROOT.'/model/'.strtolower($name).'.php');
        $this->$name = new $name();
    }
   
    // vérifie l'identifiant et le mot de passe et log l'utilisateur
    public function login(){
        $class = $this->models;        
        $class = $class[0];       
        $this->$class->verifLog($this->data['identifiant'],$this->data['mot_de_passe']);
    }
    
    // Déconnecte l'utilisateur
    public function logout(){
        unset($_SESSION['mais qui cela peut-il bien être ?']);
    }
}  


