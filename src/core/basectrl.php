<?php
class BaseCtrl{
    /*
    diganti dengan class global $router 
    protected $_url;
    protected $_qry=array();
    protected $_hta='';
    protected $_domain;
    */
    
    protected $_router;
    protected $_render;
    protected $_view;
    protected $_url;
    protected $_list=array();
    protected $_header=array(
        'title'=>'title',
        'subtitle'=>'subtitle',
    );
    protected $_meta=array(
        'lang'=>'en',
        'charset'=>'utf-8',
    );
    
    function __construct(){
        global $router;
        global $_hta;
        /*
        global $_get;
        global $_qry;
        global $_baseurl;
        */
        $this->_router=$router;
        unset($router);
        
        $this->_hta=$_hta;
        unset($_hta);
        
        $this->_qry=$this->_router->qry;
        /*
        biar nggak "raise error" saja
        */
        if(empty($this->_qry[0]))$this->_qry[0]='';
        if(empty($this->_qry[1]))$this->_qry[1]='';
        
        $this->setUrl($this->_router->url);
        
        $this->_baseurl =  
            $this->subDomainVar($this->_router->controller);
        
        /*
        inisialisasi post
        */
        $this->_post=new Post;
        
        
        /*
        inisialisasi template
        */
        $this->_render=true;
        $this->_view=new View();
        $this->_view->setDir($this->_router->controller.DS.'tpl');
        

        $this->_view->setTpl($this->_router->method);
    }
    
    
    function __destruct(){
        if($this->_render){
            if(class_exists('Asset')){
                $array=$this->getAllMethods('Asset');
                foreach($array as $val) 
                    $this->_view->set(
                        $val,$this->subDomainVar('Asset',$val)
                );
            }
            $this->_view->set('hta',$this->_hta);
            $this->_view->set('url',$this->_url);
            $this->_view->set('baseurl',$this->_baseurl);
            $this->_view->set('header',$this->_header);
            $this->_view->set('meta',$this->_meta);
            $array=array('css','img','fonts','js');
            $tpldir='tpl'.DS;
            if($this->_router->not_subdomain)
                $tpldir=$this->_view->getDir().DS;
            foreach($array as $key)$this->_view->set($key,$tpldir.$key);
            
            $this->_view->render();
            
            
            
        }
    }
    protected function getAllMethods($class){
        $_this = get_class_methods($class);
        if($parent_class = get_parent_class($class)){
            $_parent = get_class_methods($parent_class);
            $_dif = array_diff($_this, $_parent);
            return $_dif;
        }
        return $_this;
    }
    protected function subDomainVar($ctrl,$mtd=''){
        $ctrl=strtolower($ctrl);
        return $this->_router->not_subdomain ?
            /*
            ?u=controller/
            */
            $this->_hta.$ctrl.'/'.$mtd :
            /*
            controller.domain.com/?=
            */
            'http://'.$ctrl.'.'.$this->_router->domain.'/'.$this->_hta.$mtd;
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
        str_replace($this->_route->controller.'/',$to_url);
        header('location: '.$this->_baseurl.$to_url);
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
    
/* end Content */    
    
}