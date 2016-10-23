<?php
class PDF{
  protected $_dir;
  function __construct(){
    if(!defined('ROOT_DIR')) define('ROOT_DIR',dirname(dirname(__FILE__)));  
    if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
    $this->_dir=ROOT_DIR . DS .'upl' . DS .'file';
  }
      
  function setDir($dir){
    $this->_dir= $dir;
  }
  function getDir(){
    return $this->_dir;
  }
    
  function save($file,$prefix='p'){
     $ext='pdf';
     $err=$file['error'];
     if( $err=='0' ){
        $name=$prefix.uniqid().'.'.$ext ;
        move_uploaded_file($file['tmp_name'], $this->_dir. DS . $name);
        return $name;
    }else{
        return 0;
    }

  }
  /* 
  thumbnail
  butuh imagemagick 
  */
  function thumbnail($file,$width='120'){
    $name=$this->_dir.DS.$file.'[0]';
    $im = new imagick($name);
    $im->setImageFormat('jpg');
    $im->scaleImage($width,0);
    header('Content-Type: image/jpeg');
    echo $im;
  }

  function delete($file){
     $pdf=$this->_dir.DS.$file;
     if(file_exists($pdf)){
        unlink($pdf);
    }
  }

/*
 * akhir kelas PDF
 */
}

      