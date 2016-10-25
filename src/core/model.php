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


/* Kelas dasar Model
 * turunan dari kelas DbSQL
 */
class Model extends DbSQL{

  /* properti nama tabel */
  protected $_table;

  /* properti tabel left join */
  protected $_jointbl=array();

  /* properti kolom tabel left join */
  protected $_joincols=array();

  /* properti where kondisi and */
  protected $_and = array();

  /* properti where kondisi or */
  protected $_or = array();

  /* properti orderby */
  protected $_orderby;

  /* properti groupby */
  protected $_groupby;

  /* property offset untuk paginasi */
  protected $_offset;

  /* properti limit untuk paginasi */
  protected $_limit;

  protected $_db;
      
  /* konstruktor model */
  function __construct(){
      global $db;
      if($this->is_connect()){
          $this->_table=strtolower(get_class($this));
          $this->reset();
          if(!empty($this->columns)){
              $qry='SHOW TABLES LIKE \''.$this->_table.'\'';
              $res=$this->query($qry);
              if(empty($res)) $this->createTable();
              $this->createFirstData();
          }
      }else{
          $this->disconnect();
      }
  }
                  
    
    
  /* metod untuk membuat table */
  protected function createTable(){
    $array=array();
    /* kolom pertama id untuk index primary key */
    $s='id INT AUTO_INCREMENT PRIMARY KEY';
    array_push($array,$s);
    /* nama masing-masing kolom dan tipe kolom */
    foreach($this->columns as $key => $val){
     array_push($array,$key.' '.$val);
    }
    $fields=implode(',',$array);
    $table=$this->_table;

/* heredoc query membuat tabel */
$qry=<<<QRY
CREATE TABLE IF NOT EXISTS $table(
$fields
)ENGINE=InnoDb
DEFAULT CHARSET=utf8
QRY;

    return $this->query($qry);
  }

/* metod untuk memperbarui tabel hanya
 * dipakai saat develop */
  protected function resetTable(){
    $s='DROP TABLE '.$this->_table ;
    $this->query($s);
    return $this->createTable();

  }
  protected function createFirstData(){
      if(!isset($this->firstdata)) return;
      $this->select();
      $c=$this->countRec();
      if($c>0) return;
      foreach($this->firstdata as $val){
          foreach($val as $_key => $_val)  {
              $this->colVal($_key,$_val);
          }
          $this->save();
      }
  }    
  /* metod mengembalikan nilai
   * awal semua properti */
  function reset(){
    /* properti record perhalaman
     * diambil dari config.php */
    global $record_perpage;
    /* default limit */
    $this->_limit=
       empty($record_perpage)? '10':$record_perpage;
    /* offset */
    $this->_offset=0;
    /* kosongkan semua properti */
    $this->_jointbl=array();
    $this->_joincols=array();
    $this->_and = array();
    $this->_or = array();
    /* default orderby adalah id descending */
    $s=$this->_table.'.id DESC';
    $this->_orderby =$s;
    $this->_groupby = '';
    /* properti kolom id */
    $this->id='';
    /* kosongkan properti nama kolom-kolomnya */
    foreach($this->columns as $key=>$val){
        $this->$key = '';
    }
   }

  /* metod memasukkan left join */
  function leftJoin($table,$columns,$rev=0){
    $s ='LEFT JOIN '.$table.' ON ';

    /* tbsatu = modelnya
     * tbdua  = tabel leftjoin
     *
     * x= tbdua.id=tbsatu.tbdua_id */
    $x=$table.'.id='.$this->_table.'.'.$table.'_id';
    /* $y= tbsatu.id=tbdua.tbsatu_id */
    $y=$this->_table.'.id='.$table.'.'.$this->_table.'_id';
    /* x atau y sebagai lefjoin-nya tergantung argumen $rev */
    $s .= $rev==0 ? $x : $y ;
    array_push($this->_jointbl,$s);

    /* kolom tabel join yang harus ditampilkan */
    foreach($columns as $key=>$val){
    /* untuk menghindari
     * ambigu
     * nama kolom memakai alias
     * tabel.kolom AS tabel_kolom */
      $s=$table.'.'.$key.' AS '.
         $table.'_'.$key;
      array_push($this->_joincols,$s);
    }
   }
    /*
    leftjoin tabel kedua
     tabel_satu leftjoin table_dua,
     table_dua leftjoin table_tiga
    */
    
    function secLeftJoin($sectable,$table,$columns,$rev=0){
        $s ='LEFT JOIN '.$table.' ON ';
        $x = $table.'.id='.$sectable.'.'.$table.'_id';
        $y = $sectable.'.id='.$table.'.'.$sectable.'_id';
        $s .=$rev==0 ? $x : $y ;
        array_push($this->_jointbl,$s);
        foreach($columns as $key=>$val){
            $s=$table.'.'.$key.' AS '.$table.'_'.$key;
            array_push($this->_joincols,$s);
        }
    }   

  /* metod memasukkan nilai untuk WHERE .. AND */
   function andWhere($col,$val,$con='='){
      /* memeriksa bila kolom memakai nama tabel */
      $array=explode('.',$col);
      $s=(count($array)<2)?
        $this->_table.'.'.$col : $col;
      $s.=' '.$con.' '.$this->sanitize($val);
      array_push($this->_and,$s);
   }

   /* metod memasukkan nilai untuk WHERE .. OR */
   function orWhere($col,$val,$con='='){
      $array=explode('.',$col);
      $s=(count($array)<2)?
      $this->_table.'.'.$col : $col;
      $s.=' '.$con.' '.$this->sanitize($val);
      array_push($this->_or,$s);
   }

   /* metod untuk memasukkan GROUP BY */
   function groupBy($col){
    $array=explode(',',$col);
    foreach($array as $key=>$val){
      $array[$key]=$this->_table.'.'.$val;
    }
    $this->_groupby=implode(',',$array);
   }

   /* metod untuk memasukkan ORDER BY
    * default adalah descending */
   function orderBy($fields,$desc=1){
    $array=explode(',',$fields);
    foreach($array as $key=>$val){
     $array[$key]=$this->_table.'.'.$val;
    }
    $s=implode(',',$array);

    /* descending atau ascending
     * lihat argumen desc */
    $s .= $desc==1?' DESC':'';
    $this->_orderby=$s;
   }

   /* metod untuk menampilkan random record */
   function byRandom(){
     $this->_orderby = ' RAND()';
   }

   /* metod memasukkan limit */
   function limit($val){
     $this->_limit=$val;
   }
   /* metod memasukkan offset */
   function curPage($val){
     $val=$val-1;

     /* memastikan bahwa nilai val paling
        kecil adalah 0 */
     if($val<0){
       $val=0;
     }
     $this->_offset=
      ($val) * $this->_limit;
   }

   /* metod untuk query SELECT */
   function select($rec_id=null){

    /* periksa argumen rec_id sebagai
      id,  bila kosong, masukkan
      dari properti id */
    $id=empty($rec_id)?
         $this->id:$rec_id;

    /* kolom-index nya */
    $s=$this->_table.'.id  AS id';
    $array=array($s);

    /* kolom-kolomnya yang lain */
    foreach($this->columns as $key=>$val){

   /* kolom menghindari ambigu
      alias tabel.kolom AS kolom */
     $s=$this->_table.'.'.$key.
      ' AS '.$key;
     array_push($array,$s);
    }

/* kolom tabel join bila ada */
    if(!empty($this->_joincols)){
     foreach($this->_joincols as $val){
       array_push($array,$val);
     }
    }
    /* gabung semua kolom-kolomnya */
    $fields=implode(',',$array);

    /* nama tabel */
    $array=array($this->_table);

    /* nama tabel join */
    foreach($this->_jointbl as $val){
      array_push($array,$val);
    }

    /* gabung semua tabelnya */
    $table=implode(' ',$array);

    /* limit dan where
       melihat argumen id
       bila id kosong tampilkan
       berdasar limit dan offset */
   if(empty($id)){
     $limit=$this->_offset.','.
        $this->_limit;

    /* kondisi-kondisi where */
    $array=array();

    $where='';

   /* bila properti nama kolom
      diberi nilai,
      masukkan sebagai where */
    foreach($this->columns as $key=>$val){
      if(!empty($this->$key)){
      $s=$this->_table.'.'.$key.
        ' = '.$this->$key;
      array_push($array,$s);
     }
   }

/* bila _and punya nilai
tambahkan dalam where */
 foreach($this->_and as $val){
   array_push($array,$val);
 }

/* gabung where kondisi AND */
 $and=implode(' AND ',$array);

 /* bila or diberi nilai
  tambahkan kedalam $where */
 $or=implode(' OR ',$this->_or);

 /* gabungkan or dan and */
 $array=array();
 if(!empty($and)){
   array_push($array,$and);
 }
 if(!empty($or)){
   array_push($array,$or);
 }
 if(!empty($array)){
    $where=implode(' OR ',$array);
  }

 /* where masih kosong tambahkan 1=1 */
 if(empty($where)){
   $where=' 1=1 ';
 }

  /* group by dan orderby */
 $groupby=empty($this->_groupby)?'':
    ' GROUP BY '.$this->_groupby ;
 $orderby=empty($this->_orderby)?'':
   ' ORDER BY '.$this->_orderby;
}else{

 /* id diberi nilai berarti hanya
   where tabel.id = nilai id limit 1*/
  $limit='1';
  $where=$this->_table.'.id='.$id;

 /* kosongi group by dan orderby */
 $groupby='';
 $orderby='';
}
/* kembalikan semua properti
   ke default */
$this->reset();

/* heredoc membentuk query select */
$qry=<<<QRY
SELECT $fields FROM $table
WHERE $where  $groupby  $orderby
LIMIT $limit
QRY;

$_table=$this->_table;

/* menyimpan query untuk total record */
$this->_countqry=<<<QRY
SELECT count( $_table.id ) AS id FROM $table
WHERE $where
QRY;

/* mengirim query */
     $res=$this->query($qry);
     if(empty($id)){
        return $res;
     }else{
      return $res[0];
     }
}

/* metod untuk memasukkan nilai post
 * kedalam kolom-kolom tabelnya */
  function add($post){
  $array=$this->colNames();
    foreach($array as $key=>$val){

     /* masukkan nilai post yang sesuai
      * dengan properti kolom dan tidak kosong */
      if(isset($post[$key]) &&
        $post[$key] != ''){
         $this->$key=
           $this->sanitize($post[$key]);
       }
     }
  }

/* metod memasukkan nilai perkolom */
function colVal($col,$val){
  /* masukkan nilai sesuai
     properti kolomnya */
  $this->$col=$this->sanitize($val);
}

  /* metod untuk insert dan update  */
  function save($rec_id=null){

    /* periksa argumen rec_id sebagai
       id, bila kosong, masukkan
       dari properti id */
    $id=empty($rec_id)?
      $this->id:$rec_id;

    /* nama tabelnya */
    $table=$this->_table;

   /* id masih kosong membentuk query insert */
    if(empty($id)){

     /* memasukkan nilai masing-masing kolom */
     $ar_key=array();
     $ar_val=array();
     foreach( $this->columns as $key => $val ){
      if($this->$key != ''){
        array_push($ar_key,$key);
        array_push($ar_val,$this->$key);
      }
     }
    $fields=implode(',',$ar_key);
    $values=implode(',',$ar_val);

/* membentuk query insert */
$qry=<<<QRY
INSERT INTO $table( $fields )
VALUE( $values )
QRY;

    }else{

    /* id mempunyai nilai,
      membentuk query update */
    $array=array();
      foreach( $this->columns as $key => $val ){
        if($this->$key != ''){
         array_push($array,$key.'='.$this->$key);
        }
      }
     $fieldvals=implode(',',$array);

   /* membentuk query update */
$qry=<<<QRY
   UPDATE $table SET $fieldvals
   WHERE id=$id LIMIT 1
QRY;
    }

   /* melaksanakan query
    dan mengembalikan hasilnya */
    $res=$this->query($qry);

    if(empty($id)){

     /* bila insert, ambil id terakhir
        dari record yang ditambahkan */
     $qry='SELECT last_insert_id() as id';
     $lid=$this->query($qry);
     $id=$lid[0]['id'];
     }

     /* mengembalikan properti
      * ke nilai awal */
      $this->reset();

     /* mengembalikan nilai id bila sukses
      * dan 0 bila gagal */
      return $res==1?$id:0;
  }


  /* metod untuk menghapus
   * berdasar argumen rec_id atau id */
  function delete($rec_id=null){

    /* periksa argumen rec_id sebagai
     * id,  bila kosong, masukkan
     * dari properti id */
    $id=empty($rec_id)?
        $this->id:$rec_id;

    /* nama tabelnya */
    $table=$this->_table;

    /* memastikan bahwa id tidak kosong
     * untuk melaksanakan query delete */
     if(!empty($id)){

  /* menjalankan query hapus */
$qry=<<<QRY
 DELETE FROM $table
 WHERE id = '$id' LIMIT 1
QRY;

   return $this->query($qry);
    }else{
       $array=array();
       /* kolom-kolomnya yang lain */
       foreach($this->columns as $key=>$val){
         if(!empty($this->$key)){
            $s=$key.' = '.$this->sanitize($this->$key);
            array_push($array,$s);
         }
        }
       /* andWhere */
       foreach($this->_and as $val){
          array_push($array,$val);
       }
       $s='';
       if(!empty($array)){
        $s=implode(' AND ',$array);
       }
       /* kondisi masih kosong tidak melakukan apa-apa */
       if(empty($s)){
         /* kembalikan semua kondisi kosong */
          return '0';
       }else{
$qry=<<<QRY
  DELETE FROM $table
  WHERE $s
QRY;
         return $this->query($qry);
       }
    }
  }

  /* menghitung total record */
  function countRec($where=null){

    /* periksa argumen where */
    if(empty($where)){

    /* argumen where kosong
     * ambil  dari select */
    $qry=$this->_countqry;
    }else{

      /* bila where diberi nilai
       * buat query count */
      $table=$this->_table;

$qry=<<<QRY
SELECT count(id) as id FROM $table
WHERE $where
QRY;

    }
    $array=$this->query($qry);
    return $array[0]['id'];
  }


  /* metod untuk mengambil
   * nama-nama kolom turunannya,
   * berguna untuk leftjoin atau
   * menampilkan form kosong  */
  function colNames(){
    $array=array();

    /* ditambah kolom id */
    $array['id']='';

    /* ambilkan dari properti $columns */
    foreach($this->columns as $key=>$val){
      $array[$key]='';
    }
    /*
      $s=$table.'.'.$key.' AS '.
      $table.'_'.$key;
      array_push($this->_joincols,$s);
     */
    foreach($this->_joincols as $key){
        list($_val,$_key)=explode('AS',str_replace(' ','',$key));
        $array[$_key]='';
    }
    return $array;
  }
  function tableName(){
        return $this->_table;
    }

  /* destruktor memutuskan
   * hubungan dengan server MySQL */
  function __destruct(){
    $this->disconnect();
  }

 /* akhir kelas Model */
}