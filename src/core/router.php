<?php

class Router{
    public $domain='';
    public $controller='';
    public $method='index';
    public $qry=array();
    public $url='';
    public $not_subdomain=true;
    protected $_route;
    
    function __construct($default_controller,$get_key=null){
        $this->_route=$default_controller;
        $this->parserTLD();
        $this->get($get_key);
    }
        
    protected function parserTLD(){

        /*
        dirty parsing 
        soalnya belum ketemu 
        yang bener-bener solved
        hehehe
        
        siap-siap untuk pakai
        subdomain..
        */
        
        $prefix= array(
            'https://',
            'http://',
            'www.',
        );
        $suffix= array(
            '.com',
            '.org',
            '.web',
            '.net',
            '.co',
            '.or',
            '.id',
        );
        /*
        $this->url=strtolower($_SERVER)
        
        /*
        domain
        tanpa sufix
        */
        $sub_domain='';
        $s=strtolower($_SERVER['SERVER_NAME']);
        foreach($prefix as $val) $s=str_replace($val,'',$s);
        foreach($suffix as $val) $s=str_replace($val,'',$s);
        $a=explode('.',$s);
        if(!empty($a))$sub_domain=array_shift($a);
        $domain=empty($a)?$sub_domain:array_shift($a);
        if($domain==$sub_domain) $sub_domain='';
        $this->not_subdomain=empty($sub_domain);
        
        $this->controller=$this->not_subdomain ?
            $this->_route : $sub_domain;
        
        /*
        cari sufix 
        */
        $s=strtolower($_SERVER['SERVER_NAME']);
        foreach($prefix as $val) $s=str_replace($val,'',$s);
        if(!empty($sub_domain)) $s=str_replace($sub_domain.'.','',$s);
        /* domain tanpa www. */
        $this->domain=$s;
    }

        
    
    protected function get($key=null){
        if(empty($key)) $key='u';
        $_get=isset($_GET[$key])?strtolower($_GET[$key]):'';
        $this->url=$_get;
        unset($_GET[$key]);
        
            
        
        
        
        /*
        koreksi $_GET
        */
        $_get=str_replace('//','/',$_get);
        $_get=str_replace('-','_',$_get);
        $_get=str_replace(' ','_',$_get);
        $_get=str_replace('=/','',$_get);
        
        /* 
        cari controller 
        dari subdomain atau request $_GET
        */
        $qry=explode('/',$_get);
        
        if(!empty($qry)){
            if($qry[0]==$this->controller) array_shift($qry);
            if(!empty($qry)&&$this->not_subdomain){
                $ctr=ucfirst($qry[0]);
                if(class_exists($ctr))
                    $this->controller=array_shift($qry);
            }
        }
            
                    
            
        if(!empty($qry)){
            $ctr=ucfirst($this->controller);
            if(method_exists($ctr,$qry[0]))
                $this->method=array_shift($qry);
        }
        $this->qry=$qry;    
    }   
}
    
