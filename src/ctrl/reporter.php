<?php
class Reporter extends BaseCtrl{
    protected $_login=false;
    
    /* 
    constructor
    inisialisasi session
    sekalian memeriksa 
    apakah sudah melakukan login ?
    */
    function __construct(){
        parent::__construct();
        $this->addModel('session');
        $this->_login=
            $this->session->id()==$this->session->get('login');
    }
    
    /*
    default redirect bila 
    belum melakukan login
    dan menampilkann data akun yang disimpan 
    */
    protected function need_login(){
        if(!$this->_login) $this->redir('login');
        $this->_view->set('profile_nama',$this->session->get('ctrprofile_nama'));
        $this->_view->set('profile_ava',$this->session->get('ctrprofile_ava'));
        
        
    }
        
        

            
    
    /*
    daftar baru 
    profil dan access
    alur A1
    */
     
    function  signup(){
        $this->addModel('ctraccess');
        $this->addModel('ctrprofile');
        
        /* 
        bila submit akun  baru
        masukkan profil untuk dapat ctrprofil_id
        baru data access dimasukkan
        */
        if($this->_post->submitted()){
            
            $this->ctrprofile->add($this->_post->all());
            $pr_id=$this->ctrprofile->save();
            
            $this->ctraccess->add($this->_post->all());
            $this->ctraccess->ctrprofile_id=$pr_id;
            $this->ctraccess->save();
            
            $this->redir('login');
        }
    }   
        
    /*
    halaman login
    alur A2
    */
    function login(){
        $message='Masukkan Email dan Password';
        /*
        sudah login redirect ke operator->index
        */
        if($this->_login) $this->redir();    
        /*
        bila submit login 
        */
        if($this->_post->submitted()){
            $this->addModel('ctrprofile');
            $this->addModel('ctraccess');
            
            $all=$this->_post->all();
            foreach($all as $key=>$val){
                if(empty($val))
                    $all[$key]=uniqid();
            } 
            $this->ctraccess->add($all);
            $this->ctraccess->leftJoin( $this->ctrprofile->tableName(), $this->ctrprofile->column_avail );
            $result=$this->ctraccess->select();
            /*
            record cocok 
            masukkan dalam session
            dan redirect ke reporter->index
            */    
            if(!empty($result)){
                $id=$this->session->newId();
                $this->session->set('login',$id);
                $this->session->set($result[0]);
                $this->redir();
            }
            $message='Email dan Password tidak cocok';
        }
        $this->_view->set('message',$message);
        
    }
    
    
    /*
     mengubah profil
     edit ctrprofile
     nama
     ava   -> image 
     profesi
     tentang
     
     alur A3-a
    */
    function profile(){
        $this->need_login();
        $this->addModel('ctrprofile');
        $pr_id=$this->session->get('profile_id');
        if($this->_post->submitted()){
            $this->ctrprofile->add($this->_post->all());
            $this->ctrprofile->save($pr_id);
        };
        $this->set('profile',$this->ctrprofile->select($pr_id));
    }
        
            
    
    /*
    edit ctraccess
        email
        pwd
    alur A3-b    
    */
    function access(){
        $this->need_login();
        $this->addModel('ctraccess');
        $id=$this->session->get('id');
        if($this->_post->submitted){
            $this->ctraccess->add($this->_post->all());
            $this->ctraccess->save($id);
            $this->session->close();
            $this->redir('login');
        }
        $this->_view->set('access',$this->ctraccess->select($id));
    }
        
    /*
    ava_post
    karena ajax post tidak mengijinkan cross domain
    maka terpaksa harus membuat even tambahan
    untuk ajax post ava
    masalah ini telah membuat pusing sehari 
    
    */
        
    function image_post(){
        // tidak menggunakan template
        $this->_render=0; 
        $res='notfound.png';
        $var='image-data';
        /*
        menyimpan gambar dari httpuri
        misalnya capture canvas
        */
        if($this->_post->submitted($var)){
            $img=new Img;
            if(isset($this->_imgdir)) $img->setDir($this->_imgdir);
            $res=$img->post($this->_post->get($var),'jpg');
        }
            
        echo $res;
    }
    
    function ava_post(){
        /*
        ava  sama dengan image_post
        hanya deirektori penyimpanan
         ke upl/ava
        */ 
        $this->_imgdir='ava';
        $this->image_post();
    }
        
    

    /*
    logout
    kembali ke halaman login
    */
    function logout(){
        $this->session->close();
        $this->redir();
    }
    
    /*
    drat baru atau edit
    */
    
        /*
    halaman pertama setelah pengirim 
    melakukan login, berisi daftar draft miliknya
    alur A5
    */
    function index(){
        $this->need_login();
        $this->addModel('draft');
        $this->addModel('rubrik');
        if($this->_post->submitted()){
            $this->draft->add($this->_post->all());
            $this->draft->jam='CURTIME()';
            $this->draft->tgl='CURDATE()';
            $this->draft->ctrprofile_id=$this->session->get('ctrprofile_id');
            $id=$this->draft->save();
            $this->redir('compose/'.$id);
        }
        
        $this->draft->andWhere(
            'ctrprofile_id', $this->session->get('ctrprofile_id')
        );
        $this->draft->andWhere('draft_id','0');
        $this->_view->set('draft',$this->draft->select());
        $this->_view->set('tipe',$this->rubrik->tipe);
    }
        

    
    function compose(){
        /* draft baru */
        $this->need_login();
        $this->addModel('rubrik');
        $this->addModel('draft');
        /*
        if($this->_post->submitted()){
            $this->draft->add($this->_post->all());
            $this->draft->tgl='CURDATE()';
            $this->draft->jam='CURTIME()';
            $this->redir();
            
        }*/
        $this->rubrik->orderBy('id','asc');
        $this->_view->set('rubrik',$this->rubrik->select());
        if(empty($this->_qry[0])) $this->redir();
        if(!is_numeric($this->_qry[0])) $this->redir();
        $draft=$this->draft->select($this->_qry[0]);
        $this->_view->set('draft',$draft);
        $this->draft->andWhere('draft_id',$draft['id']);
        $this->_view->set('sub_draft',$this->draft->select());
        $this->_view->setTpl('compose_'.$draft['tipe']);
    }
    
    function submit(){
        
    }
    function release(){
        
    }
        /*
        $this->draft->colVal('judul','Untitled');
        $this->draft->tgl='CURDATE()';
        $this->draft->jam='CURTIME()';
        /* record baru kosong */
        /* 
        $tpl='compose_';
        $tipe=$this->rubrik->tipe;
        $dr_tipe=empty($this->_qry[0])?'1':$this->_qry[0];
        if(!is_numeric($dr_tipe)) $dr_tipe='1';
        if($dr_tipe>0 && $dr_tipe<=count($tipe)){
            $tpl.=$dr_tipe;
        }
        
        $this->_view->set('tipe',$tipe);
        $this->_view->setTpl($tpl);
    }
    */    

        
/* akhir Reporter */        
}