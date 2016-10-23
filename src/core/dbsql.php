<?php
/*
 * Koio
 * An open source application development framework for PHP
-----------------------------------------------------------------------------
The MIT License (MIT)

Copyright (c) 2015 agus-ariyanto

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-----------------------------------------------------------------------------
 * @package	Koio
 * @author	agus ariyanto
 * @email 	agus.ariyanto.solo@gmail.com
 * @since	Version 1.0.0
 * @filesource
*/

/*
 *  kelas untuk berhubungan dengan mysql
 */
class DbSQL {
  /*
   * status koneksi
   */
  protected $_handle;
  /*
   * pesan error /
   */
  protected $_error;
  /*
   * debug
   */
  protected $_testqry;
    
  /*
   * Menghubungi MySQl Server
   */
  protected function connect(){
     /*
      * variabel untuk konfigurasi Mysql diambilkan
      * dari /app/config/dbase.php
      */
     global $db;

    /* memeriksa apakah sudah terkoneksi */
    if(empty($this->_handle)){
          $this->_handle = @mysql_connect(
            $db['host'],
            $db['user'],
            $db['pwd']);
     }
     /* berusaha membuka database bila
        telah terkoneksi */
     if($this->_handle!=0){
         $res=mysql_select_db($db['name'],$this->_handle);
         return $res;
     }else{
        /* kalau terjadi kesalahan */
        $this->_error=mysql_error();
        return 0;
     }
   }
   /* method untuk memutuskan hubungan
      dengan MySQL */
  protected function disconnect(){
     @mysql_close($this->_handle);
  }
  /* method untuk mengirim query ke MySQL */
  function query($val){
    /* menyimpan query yang akan dijalankan
     * untuk debug  */
    $this->_testqry=$val;
    /* menjalankan query */
    $result=mysql_query( $val , $this->_handle);
      if($result==0){
            // bila terjadi kesalahan
            $this->_error=mysql_error();
            return 0 ;
      } elseif( !is_resource($result) ){
           // bila berhasil melaksanakan query
           return 1 ;

      } else {
            // mengembalikan array untuk SELECT
            $array=array();
            while($row=mysql_fetch_assoc($result)){
                $temp=array();
                foreach( $row as $key=>$val ){
                     $temp[$key]=$val;
                }
                array_push($array,$temp);
            }
          return $array;
        }
    }
    function is_connect(){
        return $this->connect()!=0;  
    }   
    
  /* membersihkan nilai postingan dengan
     mysql_real_escape_str */
  function sanitize($val){
    return '\''.mysql_real_escape_string($val).'\'';
  }
  /* menampilkan error yang telah disimpan */
  function getError(){
    return $this->_error;
  }
   /* metod ini hanya untuk debug saat develop
   * untuk menampilkan query yang terakhir dijalankan */
  /* method untuk menghubungi MySQL */
  function testQry(){
     return $this->_testqry;
  }

/* akhir kelas DbSQL */
}
