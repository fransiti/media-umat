<?php

function auto_load($_class){

  $_file = strtolower($_class).'.php';
  $_core = ROOT_DIR . DS . 'core'  . DS . $_file ;   
  $_ctrl = ROOT_DIR . DS . 'ctrl'  . DS . $_file ;
  $_mdl  = ROOT_DIR . DS . 'model' . DS . $_file ;
  $_lib  = ROOT_DIR . DS . 'lib' .   DS . $_file ;
    
    if(file_exists($_core)){
        require_once($_core);
        return ;
    }
    if(file_exists($_ctrl)){
        require_once($_ctrl);
        return ;
    }
    if(file_exists($_mdl)){
        require_once($_mdl);
        return ;
    }
    if(file_exists($_lib)){
        require_once($_lib);
        return true;
    }
    return false;
}

  
define('SMARTY_SPL_AUTOLOAD',0);
spl_autoload_register('auto_load'); 

