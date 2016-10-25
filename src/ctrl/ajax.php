<?php
class Ajax extends BaseCtrl{
    /*
    memeriksa session
    apakah sudah melalui login
    setiap request dengan ajax 
    */
    function isLogin(){
        $this->_session=new Session;
        $ret=$this->_session->get('login')==$this->_session->Id();
        if(!$ret)  $this->redir('ajax/notfound');
        $this->_view->set('acs',$this->_session->all());
        $this->_level=$this->_session->get('level');
        return $ret;
    }    
    /*
     message board
     */
    function sendboard(){
        $this->isLogin();
        $cookie=new Cookie;
        $mboard=new Msgboard;
        $auth=new Author;
        if( $this->_post->submitted() && $this->_post->get('submit')==$cookie->get('token')){
            $mboard->add($this->_post->all());
            $mboard->tgl='CURDATE()';
            $mboard->jam='CURTIME()';
            $mboard->author_id=$this->_session->get('author_id');
            $mboard->save(); 
        }
        $cp=empty($this->_qry[0])?1:$this->_qry[0];
        $mboard->curPage($cp);
        $mboard->limit(5);
        $mboard->leftJoin($auth->tableName(),$auth->colNames());
        $this->_view->set('mboard',$mboard->select());
        $this->_view->set('token',$cookie->createToken());
    }
    /*
     form draft
     */
    function getdraft(){
        $this->isLogin();
        $this->createMenu();
        $draft=new Draft;
        if(!empty($this->_qry[0])){
            $res=$draft->select($this->_qry[0]);
        }else{
            $res=$draft->colNames();
        }
        $this->_view->set('draft',$res);
    }
    
    /*
    eval halaman submitet draft
    */
    function evaldraft(){   
        $this->isLogin();
        $draft=new Draft;
        $auth=new Author;
        $menu=new Menu;
        $draft->leftJoin($auth->tableName(),$auth->colNames());
        $draft->leftJoin($menu->tableName(),$menu->colNames());
        $this->_view->set('draft',$draft->select($this->_qry[0]));
    }
    
    /*
    konfirmasi hapus account
    sama dengan ambil form hanya ganti template
    */
    function confirmaccountdel(){
        $this->getaccount();
    }
            
    /*
    form tambah/edit account
    qry[0] acs id
    */
    function getaccount(){
        $this->isLogin();
        $acs=new Acs;
        $author=new Author;
        $region=new Region;
        $id=empty($this->_qry[0])?'':$this->_qry[0];
        if(!is_numeric($id))$id='';
        $acs->leftJoin($author->tableName(),$author->colNames(),true);
        $acs->secLeftJoin($author->tableName(),$region->tableName(),$region->colNames());
        $this->_view->set('account',$acs->colNames());
        if(!empty($id)) $this->_view->set('account',$acs->select($id));
        $this->_view->set('level',$acs->getLevel());
        $region->orderBy('nama','asc');
        $this->_view->set('region',$region->select());
    }
    
/* end Ajax */
}