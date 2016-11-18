<?php
class Rilis extends Model{
    protected $columns = array(
        'admprofile_id'=>'INT',
        'ctrprofile_id'=>'INT',
        'rubrik_id' =>'INT',
        'rilis_id' =>'INT DEFAULT 0',
        'spcreport_id'=>'INT DEFAULT 0',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'tipe'=>'INT',
        'judul'=>'VARCHAR(255)',
        'url'=>'VARCHAR(255)',
        'status'=>'INT(1)',
        'ekserp'=>'TEXT',
        'isi'=>'TEXT',
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