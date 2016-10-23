<?php
class Image extends BaseCtrl{
    protected $_img;

    
    function __construct(){
        parent::__construct();
        $this->_render=0;
        $this->_img=new Img;
    }
    
    /*
    lihat kelas /lib/img.php
    render image
    - ?u=image/namafile.jpg/small
            ukuran valid  tiny(64) thumb(96) small(240) medium(520) big(960) large(1280)
    - ?u=image/namafile.jpg/320
            render lebar 320px tinggi menyesuaikan rasio
    - ?u=image/namafile.jpg/320x240
            render lebar 320px tinggi 240
    */
    function index(){
        $file=empty($this->_qry[0])?'notfound.png':$this->_qry[0];
        $res=empty($this->_qry[1])?'medium':$this->_qry[1];
        $this->_img->render($file,$res);
    }
    
    /*
    render warna sebagai image
    -  ?u=image/bakcground/silver/small/jpg
           valid warna adalah valid warna dalam w3cs
           ukuran small(240)
           dirender sbg jpg
        
    -  ?u=image/background/#dadada/big/png    
           warna menggunakan kode warna
           dirender sbg png
    -  ?u=image/background/#ccbbaa/240x320/gif
           ukuran lebar 240px tinggi 320px
    */               
    function background(){
        $col=empty($this->_qry[0])?'gray':$this->_qry[0];
        $res=empty($this->_qry[1])?'small':$this->_qry[1];
        $ext=empty($this->_qry[2])?'jpeg':$this->_qry[2];
        if($ext=='jpg')$ext='jpeg';
        $this->_img->background($col,$res,$ext);
    }    
    
    /* 
     upload image 
     belum dibuat lebih enak pakai  post 
     */
     
    function upload(){
        
    }
    /* 
     menangkap image yang dikirim dalamformat http->uri
     dengan form, contohnya dalam crop image halaman draft
     */
    function post(){
        $id=empty($this->_qry[1])?'image-data':$this->_qry[1];
        $res='notfound.png';
        if($this->_post->submitted($id)){
            $ext=empty($this->_qry[0])?'png':$this->_qry[0];
            if($ext!='png')$ext='jpg';
            $ext='post'.strtoupper($ext);
            $img=new Img;
            $res=$img->post($this->_post->get($id),$ext);
        }
        echo $res;
    }

/* end kelas Image */
}
    
        
            
        