<?php
class Session{

  /*
   * konstruktor
   */
  function __construct($new_ses=0){
      if (session_id() == false) session_start();
      if($new_ses!=0) $this->newId();
  }


  /* memasukkan nilai ke dalam session */
  function set($key, $value=null) {

    /* periksa bila value adalah array, masukkan nilai array */
    if (is_array($key)){
        foreach($key as $_key => $_val) $_SESSION[$_key] = $_val;
        return ;
    }
    $_SESSION[$key] = $value;
  }
    function all(){
        return $_SESSION;
    } 
	function get($key=null){
        if(empty($key)) return $_SESSION;
        return isset($_SESSION[$key])?$_SESSION[$key]:false;
    }

	/* hapus sebuah variabel dari session */
	function delete($key){
        unset($_SESSION[$key]);
	}

	/* mengambil session_id */
	function id(){
		return session_id();
	}
    function newId(){
        session_regenerate_id();
        return session_id();
    }
    
	/* menutup sebuah session */
	function close(){
        if (session_id() != false) session_unset();
	}

/* akhir kelas Session */
} 
