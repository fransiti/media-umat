<?php
class Rss2{
    protected $_channel=array(
        'header'=>'<?xml version="1.0" encoding="ISO-8859-1"?><rss version="2.0"><channel>',
        'footer'=>'</channel></rss>',
    );
    protected $_header=array();
    protected $_item=array();
        
    private function toXml($key,$val){
        return '<'.$key.'>'.$val.'</'.$key.'>';
    }
    function __construct(){
        $this->_header['link']=$this->toXml('link','http://'.$_SERVER['SERVER_NAME']);
    }
    function setHeader($title,$desc){
        $this->_header['title']=$this->toXml('title',$title);
        $this->_header['desc']=$this->toXml('description',$desc);
    } 
    
    function addItem($title,$desc,$url,$date){
        $title=$this->toXml('title',$title);
        $desc=$this->toXml('description','<![CDATA['.$desc.']]>');
        $url=$this->toXml('link','http://'.$_SERVER['SERVER_NAME'].'/'.$url);
        $gmt=date("r", strtotime($date));
        $gmt=$this->toXml('pubDate',$gmt);
        $this->_item[]=$this->toXml('item',$title.$desc.$url.$gmt);
        
    }
    
    function render(){
        header('Content-Type: text/xml');
        echo $this->_channel['header'];
        foreach($this->_header as $key => $val)  echo $val;
        foreach($this->_item as $val) echo $val;
        echo $this->_channel['footer'];
    }
    

    
        
} 