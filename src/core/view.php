<?php
class View{
    protected $_dir;
    protected $_tpl;
    protected $_var=array();
    
    function __construct(){
        global $mtd;
        global $ctrl;
        $this->setDir($ctrl);
        $this->setTpl($mtd);
    }
    function setDir($dir){
        $this->_dir='tpl'.DS.strtolower($dir);
    }
    function setTpl($file){
        $this->_tpl=strtolower($file).'.html';
    }
    function set($key,$val){
        $this->_var[$key]=$val;
    }
    function fetch(){
        /*
        $_help=ROOT_DIR.DS.'tpl'.DS.'helper';
        if($handle=opendir($_help)){
            while (false !== ($entry = readdir($handle))){
                if(strpos(strtolower($entry),'.php') != false )
                    require_once( $_help.DS.$entry);
            }
        }
        */
        
        require_once( ROOT_DIR.DS.'smarty'.DS.'libs'.DS.'Smarty.class.php');
        $smt=new Smarty;
        $smt->setTemplateDir(ROOT_DIR.DS.$this->_dir);
        $smt->setConfigDir(ROOT_DIR.DS.'tmp'.DS.'cfg');
        $smt->setCacheDir(ROOT_DIR.DS.'tmp'.DS.'cache');
        $smt->setCompileDir(ROOT_DIR.DS.'tmp'.DS.'cpl' );
        $array=array('css','img','fonts','js');
        foreach($array as $key)  $smt->assign($key,$this->_dir.DS.$key);
        foreach($this->_var as $key=>$val) $smt->assign($key,$val);
        $out=$smt->fetch($this->_tpl);
        unset($smt);
        return $out;
    }
    
    function render(){
        echo $this->fetch();
    }
        
}