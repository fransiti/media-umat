<?php
require_once (ROOT_DIR.DS.'core'.DS.'auto.php');

$basecfg=ROOT_DIR.DS.'cfg'.DS.'base.php';
$dbcfg=ROOT_DIR.DS.'cfg'.DS.'db.php';
include $basecfg;
include $dbcfg;
$record_perpage=$db['rec'];
$_hta=(HT_ACCESS==0)?'?u=':'';

error_reporting(E_ALL);
if(DEV_MODE==1){
    ini_set('display_errors','On');
} else {
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log',ROOT_DIR.DS.'tmp'.DS.'error.log');
}

function strips($_val) {
    return is_array($_val) ?
        array_map('strips', $_val) : stripslashes($_val);
}

if(get_magic_quotes_gpc()){
    $_GET    = strips($_GET);
    $_POST   = strips($_POST);
    $_COOKIE = strips($_COOKIE);
}

    
/*bersihkan variabel $_GLOBALS*/
if (ini_get('register_globals')) {
    $_qry = array('_SESSION',
                    '_POST',
                    '_GET',
                    '_COOKIE',
                    '_REQUEST',
                    '_SERVER',
                    '_ENV',
                    '_FILES'
    );
    foreach ($_qry as $array) {
      foreach ($GLOBALS[$array] as $key => $var) {
        if ($var === $GLOBALS[$key])unset($GLOBALS[$key]);
      }
   }    
}





/* 
    routing 
    default "content/index" atau yang ditentukan dengan $route
*/
$default_control=empty($route)?'content':strtolower($route);
$default_method='index';


$_get='';
if(isset($_GET['u'])) $_get=str_replace('-','_',strtolower($_GET['u']));
$_get=str_replace(' ','_',$_get);
unset($_GET);

$_qry=explode('/',$_get);
$ctrl=empty($_qry)?$default_control:$_qry[0];
//$ctrl=ucfirst($ctrl);




if(class_exists(ucfirst($ctrl))){ 
    array_shift($_qry);
}else{
    $ctrl=$default_control;
}
$mtd=empty($_qry)?$default_method:$_qry[0];
if(method_exists($ctrl,$mtd)){
    array_shift($_qry);
}else{
    $mtd=$default_method;
}

$_baseurl=$ctrl==$default_control?'':$ctrl.'/';
$_baseurl.=$mtd==$default_method?'':$mtd;

$ctrl=ucfirst($ctrl);

if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
    ob_start("ob_gzhandler");
}else{
    ob_start();
}
$object=new $ctrl;
$object->$mtd();