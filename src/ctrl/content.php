<?php
class Content extends BaseCtrl{
    protected $_id='';
    protected $_page='';

    
    function __construct(){
        parent::__construct();
        
        if(!empty($this->_qry[0])){
            if(is_numeric($this->_qry[0])){
                $this->_id=$this->_qry[0];
            }else{
                $this->_ur=$this->_qry[0];
            }
            
        }
        $this->_page=empty($this->_qry[1])?'1':$this->_qry[1];
        if(!is_numeric($this->_page)) $this->_page='1';
        $this->createMenu();
    }
        
        
    function index(){
        
    }
    function into(){
        
    }

}