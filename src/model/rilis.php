<?php
class Rilis extends Model{
    protected $columns = array(
        'admprofile_id'=>'INT',
        'ctrprofile_id'=>'INT',
        'rubrik_id' =>'INT',
        'rilis_id' =>'INT',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'judul'=>'VARCHAR(128)',
        'url'=>'VARCHAR',
        'status'=>'INT(1)',
        'seq'=>'INT(2) DEFAULT 0',
        'tipe'=>'INT',
        'ekserp'=>'INT',
        'isi'=>'INT',
    );
    function selectMonth($month=''){
        $month=empty($month)?'MONTH(CURDATE())':$month ;
        $qry=$this->tableName().'.MONTH(tgl) = '.$month ;
        $this->andQry( $qry );
        return $qry;
    }
    function selectYear($year=''){
        $year=empty($year)?'YEAR(CURDATE())':$year;
        $qry=$this->tableName().'.YEAR(tgl) = '.$year ;
        $this->andQry( $qry );
        return $qry;
    }
}