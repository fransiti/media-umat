<?php

function auto_load($_class){

  $_file = strtolower($_class).'.php';
  $_core = ROOT_DIR . DS . 'core'  . DS . $_file ;   
  $_ctrl = ROOT_DIR . DS . 'ctrl'  . DS . $_file ;
  $_mdl  = ROOT_DIR . DS . 'model' . DS . $_file ;
  $_lib  = ROOT_DIR . DS . 'lib' .   DS . $_file ;

  if(file_exists($_ctrl)){require_once($_ctrl);}
    elseif(file_exists($_core)){ require_once($_core);}
    elseif(file_exists($_mdl)){ require_once($_mdl);}
    elseif(file_exists($_lib)){ require_once($_lib);}
    else{return false;}
}

define('SMARTY_SPL_AUTOLOAD',0);
spl_autoload_register('auto_load'); 

