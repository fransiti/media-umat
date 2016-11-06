<?php
class BaseCtrl{
    protected $_url;
    protected $_view;
    protected $_render;
    protected $_qry=array();
    protected $_hta='';
    protected $_domain;
    protected $_subdomain;
    protected $_header=array(
        'title'=>'title',
        'subtitle'=>'subtitle',
    );
    protected $_meta=array(
        'lang'=>'en',
        'charset'=>'utf-8',
    );
    
    function __construct(){
        global $_get;
        global $_qry;
        global $_hta;
        global $_baseurl;
        
        $this->setUrl($_get);
        unset($_get);
        
        $this->_baseurl=$_baseurl;
        unset($_baseurl);
        
        
        $this->_qry[0]='';
        if(!empty($_qry)) $this->_qry=$_qry;
        unset($_qry);
        
        $this->_hta=$_hta;
        unset($_hta);
        
        $this->_render=true;
        $this->_post=new Post;
        $this->_view=new View();
    }
        
    function __destruct(){
        if($this->_render){
            if(!empty($this->_baseurl))
                $this->_baseurl=$this->_hta.$this->_baseurl;
                $this->_url=$this->_hta.$this->_url;
                $this->_view->set('hta',$this->_hta);
                $this->_view->set('url',$this->_url);
                $this->_view->set('baseurl',$this->_baseurl);
                $this->_view->set('qry',$this->_qry);
                $this->_view->set('header',$this->_header);
                $this->_view->set('meta',$this->_meta);
                $this->_view->set('image',$this->_hta.'image');
                $this->_view->render();
        }
    }

    protected function pagination($cur_page,$count_rec,$pagename=null){
        global $record_perpage;
        if(empty($pagename)) $pagename='pagination'; 
        $count_page=ceil($count_rec/$record_perpage);
        $pages=array();
        $pages['first']= $cur_page<2 ? 0 : 1;
        $pages['prev'] = $cur_page<3 ? 0 : $cur_page-1;
        $pages['page'] = $cur_page;
        $pages['next'] = $cur_page>$count_page-2 ? 0 :  $cur_page+1;
        $pages['last'] = $cur_page>$count_page-1 ? 0 : $count_page;
        $pages['rec_count']=$count_rec;
        $pages['total']=$count_page;
        $this->_view->set($pagename,$pages);
        return $pages;
    }
    
    protected function redir($to_url=null){
        $to_url=strtolower($to_url);
        header('location: '.$this->_hta.$to_url);
    }
    
    function setUrl($url){
        $this->_url=$this->_hta.strtolower($url);
    }
    
    function settMeta($key,$val=null){
        if(is_array($key)){ 
            foreach($key as $_key=>$_val) 
                $this->_meta[$_key]=$_val;
            return;
        }
        $this->_meta[$key]=$val;
    }
    
    function setHeader($key,$val=null){
        if(is_array($key)){ 
            foreach($key as $_key=>$_val) $this->_header[$_key]=$_val;
            return;
        }
        $this->_header[$key]=$val;
    }
    
    function addModel($name){
        $res=ucfirst($name);
        if(!isset($this->$name)) $this->$name=new $res; 
        return $res;
    }
    
    function index(){
        $this->notfound();
    }
    function notfound(){
        $this->_render=false;
        $out = <<<HERE
    
<!Doctype HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>HTTP 404</title>
	</head>
	<body>
		<h1 style="color:red">ERROR 404</h1>
		<p>Halaman yang anda cari tidak ditemukan</p>
	</body>
</html>

HERE;
        echo $out;
    }
    /*
    hanya untuk test
    */
    
    function server(){
        $this->_render=0;
        print_r($_SERVER);
    }
/* end Content */    
    
}