<?php

/* kelas untuk variabel $_COOKIES */
class Cookie{
  /* properti untuk waktu kadaluarsa */
    protected $next;
    protected $_token;
    
  /* konstruktor */
  function __construct(){
    /* default cookie berlaku 24 jam */
      $this->expired(24);
      $this->_token=$this->get('token');
  }


  /* merubah waktu kadaluarsa */
  function expired($hour){
      $this->next=time()+(3600*$hour);
  }

  /* menyimpan nilai kedalam cookie */
  function set($key, $value=null) {
      if(is_array($key)){
          foreach($key as $k => $v)
              setcookie("$k",$value,$this->next);
          return ;
      }
      setcookie($key,$value,$this->next);
  }

  /* mengambil nilai dari cookie */
  function get($key=null){
      if(empty($key)) return $_COOKIE;
      return isset($_COOKIE[$key])? $_COOKIE[$key]:false;
  }


  /* menghapus sebuah nilai cookie */
  function delete($key){
      setcookie($key,'',time()-3600);
  }

/* menutup semua cookie */
  function close(){
      foreach($_COOKIE as $key=>$val) $this->delete($key);
  }
  function createToken(){
      $s=sha1(uniqid());
      $this->set('token',$s);
      $this->_token=$s;
      return $s;
  }
  function token(){
      return $this->_token;
  }    

/* akhir kelas Cookie */
}
