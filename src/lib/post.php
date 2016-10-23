<?php
class Post{
    protected $_vars=array();
    
	function __construct(){
        if(isset($_POST)){
            foreach($_POST as $k => $v) $this->_vars[$k]=$v; 
            unset($_POST);
        } 
    }
    
    function submitted($key=null){
        $s=empty($key)?'submit':$key;
        return $this->get($s)!=false;
    }
    
    function set($key,$val){
        $this->_vars[$key]=$val;
    }    
    
    function all($submit_key=null){
        $s=$this->submitted($submit_key);
        return $s?$this->_vars:false;
    }
    
	function get($key){
        return isset($this->_vars[$key])? $this->_vars[$key] : false;
	}

/* akhir kelas Post */
}
