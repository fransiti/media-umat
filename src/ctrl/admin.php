<?php
class Admin extends BaseCtrl{
    protected $_ses;
    protected $_page;
    protected $_id;
    protected $_level; 
    
    function __construct(){
        parent::__construct();
        $this->checkPage();
        $this->checkId();
    }
   
    
    protected function isLogin($redir=null){
        if(empty($redir)) $redir='admin/login';
        $this->_session=new Session;
        $ret=$this->_session->get('login')==$this->_session->Id();
        if(!$ret)  $this->redir($redir);
        $this->_view->set('acs',$this->_session->all());
        $this->_level=$this->_session->get('level');
        return $ret;
    }
    
    /* 
    _qry pertama sebagai {$page};
    dalam template
    */
    protected function checkPage(){
        $this->_page=empty($this->_qry[0])?'1':$this->_qry[0];
        if(!is_numeric($this->_page))$this->_page='1';
        $this->_view->set('page',$this->_page);
        return $this->_page;
    }
    
        
    /*
    _qry kedua sebagai {$id}
    dalam template
    */
    protected function checkId(){
        $this->_id=empty($this->_qry[1])?'':$this->_qry[1];
        if(!is_numeric($this->_id))$this->_id='';
        $this->_view->set('id',$this->_id);
        return $this->_id;
    }
/*    
    protected function checkPostToken(){
        $cookie=new Cookie;
        $return=$this->_post->submitted() && $this->_post->get('token')==$cookie->get('token');
        $this->_view->set('token',$cookie->createToken());
        return $return;
    }
*/
    function logout(){
        $this->isLogin();
        $this->_session->close();
        $this->redir();
    }
    
    
    /*
     halaman login
     akun login
     lihat model/acs.php
     dan model/author.php
     */
    function login(){
        $sesi=new Session;
        /* 
        periksa bila sudah login
        */
      //  if($sesi->get('login')==$sesi->Id()) $this->redir('admin/page/1');
        $acs=new Acs;
        $msg='Silahkan memasukkan Email dan Password';
        
        /* 
        verifikasi login submit
        */
        if($this->_post->submitted()){
            /*
            hole 
            */
            $email=$this->_post->get('email')!=false?$this->_post->get('email'):'no-user';
            $pwd=$this->_post->get('sandi')!=false?$this->_post->get('sandi'):'no-password';
            $pwd=trim($pwd);
            if(empty($pwd)) $pwd=uniqid();
            $acs->andWhere('email',$email);
            $acs->andWhere('sandi',$pwd);
            
            $res=$acs->select();
            $c=$acs->countRec();
            
            
            /*
            login berhasil  
            buat id sesi baru  dan data acs 
            untuk author hanya 
            id dan nick yang masuk ke session 
            (optimasi)
            */
            if($c>0){
                $account=$res[0];
                $sesi->newId();
                $sesi->set($account);
                $auth=new Author;
                $res=$auth->autoCreate($account['id']);
                $sesi->set('author_id',$res['id']);
                $sesi->set('nick',$res['nick']);
                $sesi->set('login',$sesi->Id());
                $this->redir('admin/draft');
            }
            /* login gagal */
            $msg='Kesulitan Login ? <br>Silahkan hubungi Administrator';
        }  
        $this->_view->set('msg',$msg);
    }
            
                

    
    function index(){
        $this->redir('admin/page/1');
    }
    
    
    /* 
      menu belum login redirect ke admin/login
    */  
    function menu(){
        $this->isLogin();
        $this->addModel('menu');
        if($this->_post->submitted()){
            $this->menu->add($this->_post->all());
            $this->menu->colVal('url',
                          strtolower(
                              str_replace(' ','-',$this->_post->get('nama'))
                          ));
            $this->menu->save();
        }
        $this->createMenu();
    }
        
    function profil(){
        //
    }
        
    function rilis(){
        $this->isLogin();
        $posting=new Posting;
        $auth=new Author;
        $menu=new Menu;
        $posting->leftJoin($auth->tableName(),$auth->colNames());
        $posting->leftJoin($menu->tableName(),$menu->colNames());
        $this->_view->set('rilis',$posting->select());
        $this->_view->set('test',$posting->testQry());
    }
        
    
    
    
    function submit(){
        $this->isLogin();
        $draft=new Draft;
        if($this->_post->submitted()){
            $draft->add($this->_post->all());
            $draft->save();
        }
        $draft->andWhere('status','2');
        $auth=new Author;
        $menu=new Menu;
        $draft->leftJoin($auth->tableName(),$auth->colNames());
        $draft->leftJoin($menu->tableName(),$menu->colNames());
        $this->_view->set('draft',$draft->select());
        $c=$draft->countRec();
        $this->pagination($this->_page,$c);
    }
    
    /* 
     submit dikembalikan
     */
    function sendreject(){
        $this->isLogin();
        if($this->_post->submitted()){
            $id=$this->_post->get('id');
            if(!empty($id)){
                $draft=new Draft;
                $draft->colVal('status','3');
                $draft->save($id);
                $this->redir('admin/submit');
            }
        }
    }
    
    /*  
     submit dirilis
     */
    function sendaccept(){
        $this->isLogin();
        if($this->_post->submitted()){
            $id=$this->_post->get('id');
            if(!empty($id)){
                $draft=new Draft;
                $posting=new Posting;
                $res=$draft->select($id);
                $res['id']='';
                $posting->add($res);
                $posting->colVal('acs_id',$this->_session->get('id'));
                $posting->tgl='CURDATE()';
                $posting->jam='CURTIME()';
                $s=strtolower(trim($res['judul']));
                $s=str_replace(' ','-',$s);
                $res['url']=$s;
                $posting->save();
                $draft->delete($id);
                $this->redir('admin/submit');
            }
        }
    }
    
    /*
     * draft
     */
    function draft(){
        $this->isLogin();
        $draft=new Draft;
        if($this->_post->submitted()){
            $draft->add($this->_post->all());
            $id=$this->_post->get('id');
            if(empty($id))
                $draft->colVal('author_id',$this->_session->get('author_id'));
            $draft->colVal('status','1');
            $draft->tgl='CURDATE()';
            $draft->jam='CURTIME()';
            $draft->save();
        }
        $menu=new Menu;
        $draft->leftJoin($menu->tableName(),$menu->colNames());
        $draft->andWhere('author_id',$this->_session->get('author_id'));
        $this->_view->set('draft',$draft->select());
    }
    
    /*
     draft dikirim
     */
    function sendsubmit(){
        $this->isLogin('notfound');
        if($this->_post->submitted()){
            $draft=new Draft;
            $draft->status='2';
            $id=$this->_post->get('id');
            if(is_numeric($id) && $id!=0) $draft->save($id);
            $this->redir('admin/draft');
        }
    }  
        
    /* 
    draft dihapus
    */
    function senddelete(){
        $this->isLogin('notfound');
        if($this->_post->submitted()){
            $draft=new Draft;
            $id=$this->_post->get('id');
            if(is_numeric($id) && $id!=0) 
                $draft->delete($id);
            $this->redir('admin/draft');
        } 
    }
    
    
    /*
    *******************************
    meskipun config database
    disembunyikan dari menu
    !!!!! ini adalah hole !!!!!
    masih belum aman
    *******************************
    */
    
    function config(){
        global $dbcfg;
        global $db;
        if($this->_post->submitted()){
            $array=$this->_post->all();
            unset($array['submit']);
            foreach($array as $key=>$val){
                if(empty($val)) $array[$key]=$db[$key];
            }
            $array['rec']='50';
            file_put_contents( 
                $dbcfg , '<?php'."\n".'$db = ' . var_export($array, true) . ';'
            );
            $this->redir('admin');
        }
        $this->_view->set('db',$db);
    }
}
 