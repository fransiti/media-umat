<?php
/* 
 tabel untuk data lengkap penulis
 bisa ditampilkan sebagai profil dibawah tulisannya
 
 kolom acs_id adalah kolom untuk leftjoin denga 
 tabel acs -> /model/acs.php
 
*/
 
class Author extends Model{
    protected $columns = array (
        'acs_id'=>'INT DEFAULT 0',
        'region_id'=>'INT DEFAULT 0',
        'img'=>'VARCHAR(24)',
        'nick'=>'VARCHAR(64)',
        'nama'=>'VARCHAR(255)',
        'profesi'=>'VARCHAR(128)',
        'posisi'=>'VARCHAR(128)',
        'tentang'=>'TEXT',
    );
    function autoCreate($acs_id){
        $name='auto'.uniqid();
        $array=array(
            'acs_id'=>$acs_id,    
            'img'=>'ava.jpg',
            'nick'=>$name,
            'nama'=>$name,
        ); 
        $c=$this->countRec('acs_id ='.$acs_id);
        if(empty($c)){ 
            $this->add($array);
            $this->save();
        }
        $this->andWhere('acs_id',$acs_id);
        $ret = $this->select();
        return $ret[0];
    }
        
}
