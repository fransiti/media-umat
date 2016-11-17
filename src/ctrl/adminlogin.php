<?php
/*
untuk controller redaktur dipisah menjadi 3 bagian
untuk memudahkan pengerjakan

- AdminLogin untuk menangani login dan
  AdminLogin nanti dipakai juga untuk tatausaha   
  diturunkan dari basectrl.
- RedakturAdmin untuk manajemen account
  diturunkan dari adminlogin
- Readaktur untuk manajemen kiriman
  diturunkan dari redakturadmin
*/
class AdminLogin extends BaseCtrl{
    protected $_login=false;
    protected $_level='0';
    
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
        $this->_level=$this->session->get('level');
        $this->_view->set('profile_nama',$this->session->get('admprofile_nama'));
        $ava=$this->session->get('admprofile_ava');
        if(empty($ava)) $ava='notfound.jpg';
        $this->_view->set('profile_ava',$ava);
        /*
        menu masing-masing
        */
        $level=$this->session->get('level');
        $this->_view->set('sidebar_menu',$this->sidebar_menu[$level]);
    }

    /*
    halaman login
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
            $this->addModel('admprofile');
            $this->addModel('admaccess');
            
            $all=$this->_post->all();
            foreach($all as $key=>$val){
                if(empty($val))
                    $all[$key]=uniqid();
            } 
            $this->admaccess->add($all);
            $this->admaccess->leftJoin( 
                $this->admprofile->tableName(), 
                $this->admprofile->column_avail 
            );
            $result=$this->admaccess->select();
            /*
            record cocok 
            masukkan dalam session
            dan redirect ke redaktur->index
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
                
        
    function profile(){
        $this->need_login();
        $this->addModel('admprofile');
        $pr_id=$this->session->get('admprofile_id');
        if($this->_post->submitted()){
            $this->admprofile->add($this->_post->all());
            $this->admprofile->save($pr_id);
            $this->session->set('admprofile_ava',$this->_post->get('ava'));
            $this->session->set('admprofile_nama',$this->_post->get('nama'));
            $this->redir();
        };
        $this->_view->set('profile',$this->admprofile->select($pr_id));
        
    }
            
    
            
    
    /*
    edit ctraccess
        email
        pwd
    alur A3-b    
    */
    function account(){
        $this->need_login();
        $this->addModel('admaccess');
        $id=$this->session->get('id');
        if($this->_post->submitted()){
            $this->admaccess->add($this->_post->all());
            $this->admaccess->save($id);
            $this->session->close();
            $this->redir();
        }
        $this->_view->set('account',$this->admaccess->select($id));
    }
    
    function logout(){
        $this->need_login();
        $this->session->close();
        $this->redir();
    }
    
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
        

    
}
            

    
    