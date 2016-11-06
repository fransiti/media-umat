<?php
/*

Ini adalah controller default
atau untuk menangani halaman halaman untuk pembaca
atau dalam bagan alur-web adalah menangani
template D1..Dn

Untuk halaman Home/Beranda 
methodnya adalah index();

Untuk melihat bagaimana bekerja dengan model, silahkan 
melihat
    ctrl/admin.php
    
untuk melihat struktur tabel, silahkan lihat

    model/author.php

*/

class Content extends BaseCtrl{
    protected $_id='';
    protected $_page='';

    
    function __construct(){
        parent::__construct();
        
        /*
        
        mengambil daftar rubrik dari tabel rubrik
        
        untuk melihat cara menampilkan rubrik dalam template
        silahkan melihat 
            tpl/content/banner.html
        
        $this->createRubrik();
        */
        $this->createRubrik();
        
        /*
        
            untuk prototype inisialisasikan model dibawah komentar ini
            misalnya untuk tabel rilis dan isi dari rilis maka
            
                $this->addModel('rilis');
                $this->addModel('rilisurl);
                
        */
    }
        
    /* 
    menampilkan daftar rubrik dalam banner
    */
    protected function createRubrik(){

        /*
        menu rubrik level satu atau navigasi
        */
        
        $this->addModel('rubrik');
        $this->rubrik->andWhere('rubrik_id','0');
        $this->rubrik->orderBy('id','ASC');
        $res=$this->rubrik->select();
        
        /*
        submenu rubrik dengan dropdown
        */
        
        foreach($res as $key=>$val){
            $this->rubrik->andWhere('menu_id',$val['id']);
            $this->rubrik->orderBy('id','ASC');
            $array=$this->rubrik->select();
            $res[$key]['submenu']=$array;
        }
        $this->_view->set('rubrik',$res);
        
    }

/*
ini adalah home/beranda
*/
    function index(){
        /*
            Untuk menampilkan daftar rilis
            kita tinggal menambahkan 
            
            $rilis=$this->riis->select();
            
            kemudian
            meletakkan daftar rilis dengan 
            variabel {$index} dalam template tpl/content/index.html
            
            $this->->_view->set('index',$index);
            
            atau langsung juga boleh
            
            $this->_view->set('index', $this->rilis->select());
        */    
    }
    
    
    function into(){
        /* 
        ini tidak dipakai boleh dihapus
        */
    }
    
    function rubrik(){
        /* 
        menampilkan daftar rilis dalam kelompok menu tertentu
        misalnya ingin menggunakan judul atau id dari rubrik secara bergantian
        kita bisa memakai qry[0] sebagai judul atau rubrik
        memakai id atau nama rubrik misalnya
        $what='';
        if(!empty($this->_qry[0])) $what=$this->_qry[0];
        
        $this->rilis->leftJoin(
            $this->rubrik->tableName(),$this->rubrik->colNames());
        );
        
        
        //ini adalah id
        
        if(is_numeric($what)) {
            $this->rilis->andWhere('rubrik_id',$what);
        }else{
        
        //kalau bukan id maka cari nama rubrik
        //( karena spasi direplace dengan underscore maka harus dikembalikan dahulu );
        
            $what=str_replace('_',' ',$what);
            $this->rilis->andWhere(
                $this->rubrik->tableName().'.judul',$what
            );
        }
        
        // hanya menampilkan excerpt-nya saja
        // dalam template dipanggil dengan {$rilis}
        $this->_view->set('rilis',$this->rilis->select());
        
        */
        
    }

}