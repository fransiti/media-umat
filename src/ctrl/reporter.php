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
        $ava=$this->session->get('ctrprofile_ava');
        if(empty($ava)) $ava='notfound.jpg';
        $this->_view->set('profile_ava',$ava);
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
        $pr_id=$this->session->get('ctrprofile_id');
        if($this->_post->submitted()){
            $this->ctrprofile->add($this->_post->all());
            $this->ctrprofile->save($pr_id);
            $this->session->set('ctrprofile_ava',$this->_post->get('ava'));
            $this->session->set('ctrprofile_nama',$this->_post->get('nama'));
            $this->redir();
            
        };
        $this->_view->set('profile',$this->ctrprofile->select($pr_id));
    }
        
            
    
    /*
    edit ctraccess
        email
        pwd
    alur A3-b    
    */
    function account(){
        $this->need_login();
        $this->addModel('ctraccess');
        $id=$this->session->get('id');
        if($this->_post->submitted()){
            $this->ctraccess->add($this->_post->all());
            $this->ctraccess->save($id);
            $this->session->close();
            $this->redir();
        }
        $this->_view->set('account',$this->ctraccess->select($id));
    }
        
    /*
    
    karena ajax post tidak mengijinkan cross domain
    maka terpaksa harus membuat even tambahan
    untuk ajax post ava dan post image
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
            $this->draft->status='1';
            $this->draft->ctrprofile_id=$this->session->get('ctrprofile_id');
            $id=$this->draft->save();
            $this->redir('compose/'.$id);
        }
        
        $this->draft->andWhere( 'ctrprofile_id', 
                                       $this->session->get('ctrprofile_id') );
        $this->draft->andWhere('draft_id','0');
        $this->_view->set('draft',$this->draft->select());
        $this->_view->set('tipe',$this->rubrik->tipe);
        $this->_view->set('status',$this->draft->statuskode);
    }

        

  /*
  tipe compose
  model/rubrik.php
  
    public $tipe = array(
        '1'=>'Berita',
        '2'=>'Foto',
        '3'=>'Video',
        '4'=>'Laporan Khusus',
        '5'=>'Profile',
    );
*/  
    /*
    handle
    tipe berita(1)
    */
    protected function compose_berita(){
        if($this->_post->submitted()){
            $this->draft->add($this->_post->all());
            $this->draft->status='1';
            $this->draft->save();
            $this->redir();
        }
        $this->_view->setTpl('compose_berita');
    }
    /*
    handle
    tipe foto(2)
    */
    protected function compose_foto($draft_id){
        if($this->_post->submitted()){
            $urls=$this->_post->get('urls');
            $ekserps=$this->_post->get('ekserps');
            $ids=$this->_post->get('ids');
            foreach($urls as $key=>$val){
                if(!empty($ekserps[$key]))
                    $this->draft->colVal('ekserp',$ekserps[$key]);
                if(!empty($ids[$key]))
                    $this->draft->id=$ids[$key];
                $this->draft->tgl='CURDATE()';
                $this->draft->jam='CURTIME()';
                $this->draft->colVal('url',$val);
                $this->draft->draft_id=$draft_id;
                $this->draft->status='1';
                $this->draft->ctrprofile_id=$this->session->get('ctrprofile_id');
                $this->draft->save();
            }
            $this->draft->add($this->_post->all());
            $this->draft->save($draft_id);
            $this->redir();
        }
        $this->draft->andWhere('draft_id',$draft_id);
        $this->_view->set('sub_draft',$this->draft->select());
        $this->_view->setTpl('compose_foto');
    }
    
    /*
    ajax handle
    hapus foto
    */
    function delete_foto(){
        $this->_render=0;
        if($this->_post->submitted()){
            $id=$this->_post->get('fid');
            if(!empty($id)){
                $this->addModel('draft');
                $this->draft->delete($id);
            }
            $fname=$this->_post->get('fname');
            if(!empty($fname)){
                $img=new Img;
                $img->delete($fname);
            }
            echo $fname.'-'.$id;
        }
        echo '<br>1';
    }    
    /*
    handle
    video
    */
    protected function compose_video($draft_id){
        if($this->_post->submitted()){
            $urls=$this->_post->get('urls');
            $ids=$this->_post->get('ids');
            foreach($urls as $key=>$val){
                if(!empty($ids[$key]))
                    $this->draft->id=$ids[$key];
                $this->draft->tgl='CURDATE()';
                $this->draft->jam='CURTIME()';
                $this->draft->status='1';
                $this->draft->colVal('url',$val);
                $this->draft->draft_id=$draft_id;
                $this->draft->ctrprofile_id=$this->session->get('ctrprofile_id');
                $this->draft->save();
            }
            $this->draft->add($this->_post->all());
            $this->draft->save($draft_id);
            $this->redir();
        }
        $vid=new Video;
        $this->draft->andWhere('draft_id',$draft_id);
        $this->_view->set('sub_draft',$this->draft->select());
        $this->_view->set('video',$vid);
        $this->_view->setTpl('compose_video');
    }
    /*
    ajax
    parsing youtube untuk 
    embed
    */
    function get_video(){
        $this->_render=0;
        if($this->_post->submitted('vid_url')){
            $url=$this->_post->get('vid_url');
            $vid=new Video;
            echo $vid->youtube($url);
        }
    }
        
    /*
    ajax handle
    hapus url video
    */
    function delete_video(){
        $this->_render=0;
        if($this->_post->submitted()){
            $id=$this->_post->get('fid');
            if(!empty($id)){
                $this->addModel('draft');
                $this->draft->delete($id);
            }
            echo 'done';
        }
        echo '<br>1';
    }    
        
    function compose(){
        /* draft baru */
        $this->need_login();
        
        /* 
        prevent id kosong
        */
        if(empty($this->_qry[0])) $this->redir();
        if(!is_numeric($this->_qry[0])) $this->redir();
        
        $this->addModel('draft');
        $this->addModel('rubrik');
        $this->rubrik->orderBy('id','asc');
        $this->_view->set('rubrik',$this->rubrik->select());
        $draft=$this->draft->select($this->_qry[0]);
        $this->_view->set('draft',$draft);
        
        switch ($draft['tipe']){
            case '2':$this->compose_foto($draft['id']);
                break;
            case '3':$this->compose_video($draft['id']);
                break;
            default :$this->compose_berita();
                break;
        } 
    }
    
        
        
    function compose_delete(){
        $this->need_login();
        if($this->_post->submitted()){
            $this->addModel('draft');
            $this->draft->andWhere('draft_id',$this->_post->get('id'));
            $res=$this->draft->select();
            if(!empty($res)){
                foreach($res as $key=>$val)
                    $this->draft->delete($val['id']);
            }
            $this->draft->delete($this->_post->get('id'));
        }
        $this->redir();
    }
        
        
    
    
    function submit(){
        $this->need_login();
        if(!empty($this->_qry[0])&&is_numeric($this->_qry[0])){
            $this->addModel('draft');
            $this->draft->colVal('status',2);
            $this->draft->save($this->_qry[0]);
        }
        $this->redir();
    }
        
    function release(){
        $this->need_login();
        if(!isset($this->_qry[0]))$this->_qry[0]='';
        if(!isset($this->_qry[1]))$this->_qry[1]='';
        $this->addModel('rilis');
        $this->addModel('rilistraffic');
        $this->rilis->andWhere('ctrprofile_id',$this->session->get('ctrprofile_id'));
        $this->rilis->selectMonth($this->_qry[0]);
        $this->rilis->selectYear($this->_qry[1]);
        $this->rilis->leftJoin($this->rilistraffic->tableName(),
                               $this->rilistraffic->colNames(),
                              true);
        $this->_view->set('rilis', $this->rilis->select());
        $this->_view->set('total',$this->rilis->countRec());
    }
        
/* akhir Reporter */        
}