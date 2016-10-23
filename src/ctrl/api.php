<?php
/*
 calon controller untuk api
 */
class Api extends BaseCtrl{
    
    function __construct(){
        parent::__construct();
        $this->addModel('posting');
        $this->addModel('author');
        foreach($_SERVER as $key=>$val){
            $this->_view->set(strtolower($key),$val);
        }
    }
    
    function index(){
        $this->_render=false;
    }
    
    function rss(){
        /* ada postingan hari ini */
        $this->Posting->tgl='CURDATE()';
        $this->Posting->andWhere('rilis','1');
        $this->Posting->leftJoin(
            $this->Author->tableName(),
            $this->Author->colNames(),
                                );
        $this->_view->set('item',$this->Posting->select());
        /* 
        harus paling akhir dari method
        */
        header('Content-Type: text/xml');  
    }
    
    
    function json(){
        /*
        belum dibuat
         */
    }
    
    function xml(){
        /*
        belum dibuat
         */
    }        
    
}