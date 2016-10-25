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
        $admmenu=new AdminMenu;
        $this->_view->set('icon',$admmenu->getIcon());
        $this->_view->set('admin_menu',$admmenu->getLevel($this->_level));
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
        if($sesi->get('login')==$sesi->Id()) $this->redir('admin/draft');
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
                $sesi->set('img',$res['img']);
                $sesi->set('login',$sesi->Id());
                $this->redir('admin/draft');
            }
            /* login gagal */
            $msg='Kesulitan Login ? <br>Silahkan hubungi Administrator';
        }  
        $this->_view->set('msg',$msg);
    }
            
                

    
    function index(){
        $this->redir('admin/login');
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
        
    function profiles(){
        $this->isLogin();
    }
        
    function rilis(){
        $this->isLogin();
        $posting=new Posting;
        $auth=new Author;
        $menu=new Menu;
        $acs=new Acs;
        $posting->leftJoin($auth->tableName(),$auth->colNames());
        $posting->leftJoin($menu->tableName(),$menu->colNames());
        $posting->leftJoin($acs->tableName(),$acs->colNames());
        $this->_view->set('rilis',$posting->select());
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
        $this->_view->set('evalcode',$draft->evalCode());
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
     menangani akun dari admin (level 1)
     */
     
    function accounts(){
        $this->isLogin();
        $acs=new Acs;
        $auth=new Author;
        $reg=new Region;
        if($this->_post->submitted()){
            /*
             * access level
             */
            $acs->add($this->_post->all());
            $acs_id=$acs->save();
            $auth->add($this->_post->all());
            $auth->acs_id=$acs_id;
            $auth->save();
        }
        $acs->andWhere('id','1','>');
        $acs->leftJoin($auth->tableName(),$auth->colNames(),true);
        $acs->secLeftJoin($auth->tableName(),$reg->tableName(),$reg->colNames());
        $this->_view->set('accounts',$acs->select());
        $reg->orderBy('id','asc');
    }   
    /*
    hapus akun
    */
    function accountdelete(){
        $this->isLogin();
        $acs=new Acs;
        if($this->_post->submitted()){
            $id=$this->_post->get('id');
            if(!empty($id)&&$id>1){
                $acs->delete($id);
                $this->redir('admin/accounts');
            }
        }    
    }   
    /* 
    menangani akun miliknya sendiri
    */
    function accountchange(){
        $this->isLogin();
        $id=$this->_session->get('id');
        $acs=new Acs;
        $author=new Author;
        $region=new Region;
        if($this->_post->submitted()){
            if(empty($this->_qry[0])){
                $author->add($this->_post->all());
                $author->save($id);
                $this->_session->set('nick',$this->_post->get('nick'));
                $this->_session->set('img',$this->_post->get('img'));
                $this->redir('admin/draft');
            }else{
            $acs->add($this->_post->all());
            $acs->save($this->_post->get('id'));
            $this->_session->close();
            $this->redir('admin/login');
            }
        }
        $region->orderBy('nama','asc');
        $this->_view->set('region',$region->select());
        $this->_view->set('level',$acs->getLevel());
        $this->_view->set('access',$acs->select($id));
        $id=$this->_session->get('author_id');
        $this->_view->set('author',$author->select($id));
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
            $this->redir('admin/login');
        }
        $this->_view->set('db',$db);
    }
}
 