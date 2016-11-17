<?php
class Unixip extends Model{
    protected $columns=array(
        'ip'        =>'VARCHAR(24) UNIQUE',
        'rilis_id'  =>'INT',
        'tgl'=>'DATE',
    );
    function save($rilis_id, $ip){
        $qry='INSERT IGNORE into '.$this->tableName().
             '(ip,rilis_id) VALUE ('.$this->sanitize($ip).
             ','.$this->sanitize($rilis_id).')';
        $this->query($qry);
        $qry='SELECT last_insert_id() as id'; 
        
        $lid=$this->query($qry);
        $id=$lid[0]['id'];
        return (!empty($id));
    }
}