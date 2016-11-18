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

class RedakturAdmin extends AdminLogin{
    function need_login_top_level(){
        $this->need_login();
        if($this->_level!=='1'){
            $this->redir('restricted');
        }
    }
    function restricted(){
        $this->need_login();
        /* 
        ini adalah halaman untuk level dibawahnya
        yang berusaha masuk ke top level
        */
    }

    function accounts(){
        $this->need_login_top_level();
        $this->addModel('admaccess');
        $this->addModel('admprofile');
        $this->admaccess->leftJoin($this->admprofile->tableName(),
                    $this->admprofile->colNames()  );
        $this->admaccess->orderBy('id,level',false);
        $this->admaccess->andWhere('admprofile_id','0','>');
        $this->_view->set('accounts',$this->admaccess->select());
        $this->_view->set('level',$this->admaccess->adminlevel);
    }
    function account_submit(){
        $this->need_login_top_level();
        $id=$this->_qry[0];
        $this->addModel('admprofile');
        $this->addModel('admaccess');
        if($this->_post->submitted()){
            $all=$this->_post->all();
            if(empty($all['ava']))$all['ava']='notfound';
            $all['id']=$this->_post->get('admprofile_id');
            $this->admprofile->add($all);
            $pr_id=$this->admprofile->save();
            $this->admaccess->add($this->_post->all());
            $this->admaccess->admprofile_id=$pr_id;
            $this->admaccess->save();
            $this->redir('accounts');
        }
        if(empty($id)){
            $account=$this->admaccess->colNames();
            $profile=$this->admprofile->colNames();
        }else{
            $account=$this->admaccess->select($id);
            $profile=$this->admprofile->select($account['admprofile_id']);
        }
        $this->_view->set('level',$this->admaccess->adminlevel);
        $this->_view->set('account',$account);
        $this->_view->set('profile',$profile);
    }
            
    function account_delete(){
        $this->need_login_top_level();
        if($this->_post->submitted()){
            $this->addModel('admaccess');
            $this->admaccess->delete($this->_post->get('id'));
        }
        $this->redir('accounts');
    }
        
    
    function rubrics(){
        $this->need_login_top_level();
        $this->addModel('rubrik');
        if($this->_post->submitted()){
          
            $this->rubrik->add($this->_post->all());
            $this->rubrik->save();
        }
        $this->rubrik->andWhere('rubrik_id','0');
        $rubrik=$this->rubrik->select();
        foreach($rubrik as $key => $val){
            $this->rubrik->andWhere('rubrik_id',$val['id']);
            $this->rubrik->orderBy('id',0);
            $rubrik[$key]['sub_rubrik']=$this->rubrik->select();
        }
        $this->rubrik->orderBy('id',0);
        $this->_view->set('rubrik',$rubrik);
    }
    
    function rubric_delete(){
        $this->need_login_top_level();
        
            
        if($this->_post->submitted()){
            $this->addModel('rubrik');
            $this->rubrik->delete($this->_post->get('del-id'));
        }
        $this->redir('rubrics');
    }
    
    function forums(){
        $this->need_login();
        /*
        $this->addModel('admforum');
        $this->addModel('draft');
        $this->addModel('admprofile');
        $this->addModel('ctrprofile');
        $id=$this->_qry[0];
        /* 
        inisialisasi
        biar nggak error raise
    
        $forum=array();
        $draft=$draft->colNames();
        $draft_item=array();
        $last_forum=array();
        if(is_numeric($id)){
            
            $this->admforum->andWhere('draft_id',$id);
            $this->admforum->andWhere('status','0');
            $this->admforum->leftJoin(
                $this->admprofile->tableName(),$this->admprofile->colNames();
            );
            $this->admforum->orderBy('id',false);
            $forum=$this->admforum->select();
            /* ------------------------ 
            $this->admforum->testQry();
            $this->_render=0;
            /* ------------------------ 
            //last
            $draft=$this->draft->select($id);
            if($draft['tipe']>1){
                $this->draft->andWhere('draft_id',$id);
                $draft_item=$this->draft->select();
            }
            
        }
        $this->_view->set('draft',$draft);
        $this->_view->set('draft_item',$draft_item);
        $this->_view->set('forum',$forum);
        */
    }
    /*
    ajax posting forum
    */
    function forum_submit(){
        $this->need_login();
        /*
        $this->addModel('admforum');
        $this->addModel('admprofile');
        $forum=array();
        if($this->_post->submitted()){
            $this->admforum->add($this->_post->all());
            $id=$this->admforum->save();
            $this->admforum->leftJoin(
                $this->admprofile->tableName(),
                $this->admprofile->colNames()
            );
            $forum=$this->admforum->select($id);
        }
        $this->_view->set('forum',$forum);        
        */
    }
    /*
    ajax update forum
    */
    function forum_update(){
        $this->need_login();
        /*
        $forum=array;
        if($this->_post->submitted('id')){
            $this->addModel('admforum');
            $this->addModel('admprofile');
            $this->admforum->andWhere('id',$this->_post->get('id'));
            $forum=$this->admforum->select();
        }
        $this->_view->set('forum',$forum);
    }
    function forum_status(){
        */
    }
            
        
    
        
    
}