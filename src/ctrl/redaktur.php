<?php
class Redaktur extends RedakturAdmin{
    function index(){
        $this->need_login();
        /*
        $this->_render=false;
        echo '<pre>';
        print_r($this->session->all());
        echo '</pre>';
        */
    }
    function spc_reports(){
        $this->need_login();
        $this->addModel('spcreport');
        if($this->_post->submitted()){
            $this->spcreport->add($this->_post->all());
            $this->spcreport->save();
        }
        
        $this->spcreport->orderBy('id',0);
        $this->_view->set('spcreport',$this->spcreport->select());
    }
    function spcreport_delete(){
        $this->need_login();
        if($this->_post->submitted()){
            $this->addModel('spcreport');
            $this->spcreport->delete($this->_post->get('del-id'));
        }
        $this->redir('spc_reports');
    }
    
        
    function drafts(){
        $this->need_login();
        $this->addModel('draft');
        $this->addModel('rubrik');
        $this->addModel('ctrprofile');
        $this->draft->leftJoin(
            $this->ctrprofile->tableName(),
            $this->ctrprofile->colNames()
        );
        $this->draft->andWhere('status','2');
        $this->_view->set('draft',$this->draft->select());        
        $this->_view->set('tipe',$this->draft->draft_tipe);
    }
    function draft_eval(){
        $this->need_login();
        $this->addModel('draft');
        $id=$this->_qry[0];
        $draft=$this->draft->colNames();
        $sub_draft=array();
        if(!empty($id)&&is_numeric($id)){
            $draft=$this->draft->select($id);
            $this->draft->andWhere('draft_id',$id);
            $sub_draft=$this->draft->select();
        }
        /*
        template berita/video/foto
        */
        switch($draft['tipe']){
            case '2':$this->_view->setTpl('draft_eval_foto');
                break;
            case '3':$this->_view->setTpl('draft_eval_video');
                break;
            default :$this->_view->setTpl('draft_eval_berita');
                break;
                
        }
        $this->addModel('rubrik');
        $this->rubrik->orderBy('id','asc');
        $this->_view->set('rubrik',$this->rubrik->select());

        
        $this->addModel('spcreport');
        $this->_view->set('spcreport',$this->spcreport->select());
        $this->_view->set('draft',$draft);
        $this->_view->set('sub_draft',$sub_draft);
        $video=new Video;
        $this->_view->set('video',$video);
        $status=array();
        foreach($this->draft->statuskode as $key=>$val)
            if($key>2) $status[$key]=$val;
        $this->_view->set('status',$status);
    }
        
        
            
            
            
    /*
    draft
       protected $columns = array(
        'ctrprofile_id' => 'INT',
        'rubrik_id' => 'INT',
        'draft_id' => 'INT DEFAULT 0',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'tipe' =>'INT',
        'judul'=>'VARCHAR(255)',
        'url'=>'VARCHAR(255)',
        'status'=>'INT(1) DEFAULT 1',
        'tipe'=>'INT(1)',
        'ekserp'=>'TEXT',
        'isi'=>'text',
    rilis    
        'admprofile_id'=>'INT',
        'ctrprofile_id'=>'INT',
        'rubrik_id' =>'INT',
        'rilis_id' =>'INT',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'judul'=>'VARCHAR(128)',
        'url'=>'VARCHAR',
        'status'=>'INT(1)',
        'seq'=>'INT(2) DEFAULT 0',
        'tipe'=>'INT',
        'ekserp'=>'INT',
        'isi'=>'INT',
    
    );
    */
    function draft_release(){
        
        $this->need_login();
        $this->addModel('draft');
        $this->addModel('rilis');
        
        if($this->_post->submitted()){
            
            /*
            draft pindah draft  ke rilis
            */
            $this->rilis->add($this->_post->all());
            $draft_id=$this->_post->get('draft-id');
            $this->rilis->jam='CURTIME()';
            $this->rilis->tgl='CURDATE()';
            $this->rilis->colVal(
                'admprofile_id',
                $this->session->get('admprofile_id')
            ); 
            
            $rilis_id=$this->rilis->save();
            
            $urls=$this->_post->get('urls');
            $ekserps=$this->_post->get('ekserps');
            
            foreach($urls as $key => $val){
                $this->rilis->colVal('url',$val);
                $this->rilis->colVal('ekserp',$ekserps[$key]);
                $this->rilis->colVal('rilis_id',$rilis_id);
                $this->rilis->save();
            }
            
            /*
            hapus draft
            */
            $this->draft->delete($draft_id);
            /* 
            hapus sub-draft
            */
            $this->draft->andWhere('draft_id',$draft_id);
            $draft=$this->draft->select();
            foreach($draft as $key=>$val){
                $this->draft->delete($val['id']);
            }
                
                
        }
        $this->redir('drafts');
    }
        
        

    function draft_reject(){
        $this->need_login();
        if($this->_post->submitted()){
            $this->addModel('draft');
            $this->draft->add($this->_post->all());
            $this->draft->save();
        }
        $this->redir();
    }

        

    
        
}