<?php

class TldParser{
    protected $_parser=array();
    
    function __construct(){
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
        
        $s=strtolower($_SERVER['SERVER_NAME']);
        foreach($prefix as $val) $s=str_replace($val,'',$s);
        foreach($suffix as $val) $s=str_replace($val,'',$s);
        $a=explode('.',$s);
        $sub_domain=array_shift($a);
        $domain=$sub_domain;
        if(empty($a)){
            $sub_domain='';
        }else{
            $domain=array_shift($a);
        }
        $_parser['domain']=$domain;
        $_parser['subdomain']=$subdomain;
        
        
        $s=strtolower($_SERVER['SERVER_NAME']);
        $ss=empty($sub_domain)?$domain:$sub_domain.'.'.$domain;
        foreach($suffix as $val) $s=str_replace($val,'',$s);
        $s=str_replace($ss,'',$s);
        $_parser['prefix']=$s;
        
        $s=strtolower($_SERVER['SERVER_NAME']);
        foreach($prefix as $val) $s=str_replace($val,'',$s);
        $s=str_replace($ss,'',$s);
        $_parser['suffix']=$s;
        $this->_parser=$parser;
    }
        
    function get($val){
        return $this->_parser[$val];
    }
    function servername(){
        return strtolower($_SERVER['SERVER_NAME']);
    }

}