<?php
class Asset extends BaseCtrl{
    function __construct(){
        parent::__construct();
        $this->_render=0;
    }
    
/*
 dari lib/img.php
*/ 
    function test(){
        echo 'done';
    }
    function image(){
        $file=empty($this->_qry[0])?'nofile':$this->_qry[0];
        $res=empty($this->_qry[1])?'small':$this->_qry[1];
        
        /*
        menampilkan image dengan class image
        render($file,$res)
        */
        
        $img=new Img;
        if(isset($this->_imgDir)) $img->setDir($this->_imgDir);
        $img->render($file,$res);
    }
    function image_upload(){
        $var=empty($this->_qry[0])?'image-file':$this->_qry[0];

        /*
        menyimpan gambar dengan input file
        save($file,$prefix)
        */
        if(isset($_FILES[$var])) {
            $img=new Img;
            if(isset($this->_imgDir)) $img->setDir($this->_imgDir);
            $img->save($_FILES[$var],'');
        }
    }
    function image_post(){
        /*
        menyimpan gambar dari httpuri
        misalnya capture canvas
        */
        $var=empty($this->_qry[0])?'image-data':$this->_qry[0];
        $res='notfound.png';
        if($this->_post->submitted($var)){
            $img=new Img;
            if(isset($this->_imgDir)) $img->setDir($this->_imgDir);
            $res=$img->post($this->_post->get($var),'jpg');
        }
        echo $res;
    }
    
/*
sama dengan menampilkan image,hanya
direktori-nya yang berbeda
*/
    
    function ava(){
        /*
        render($file,$res)
        */
        $this->_imgDir='ava';
        $this->image();
    }
    
    function ava_upload(){
        $this->_imgDir='ava';
        $this->image_upload();
    }
            
    
    function ava_post(){
        /*
        $this->_imgDir='ava';
        $this->image_post();
        */
        
        echo 'notfound.png';
    }
    
    
    function background(){
        $col=empty($this->_qry[0])?'silver':$this->_qry[0];
        $res=empty($this->_qry[1])?'small':$this->_qry[1];
        $ext=empty($this->_qry[2])?'jpeg':$this->_qry[2];
        /*
        background($color='silver',$res='small',$ext='png')
        */
        if($ext=='jpg')$ext='jpeg';
        $img= new Img;
        $img->background($col,$res,$ext);
    }
        
        
    function testing(){
        echo 'ddddddddd';
    }    
        
/*
dari lib/pdf
*/
    function pdf(){
        
    }
    
    function pdf_upload(){
        
    }
    
    function pdf_thumbnail(){
        
    }
    
}
