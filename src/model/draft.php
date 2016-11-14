<?php
/*
tabel draft
kolom tipe lihat kode dalam model/rubrik.php
status 3-5 reject
*/

    
class Draft extends Model{
    protected $columns = array(
        'ctrprofile_id' => 'INT',
        'rubrik_id' => 'INT',
        'draft_id' => 'INT DEFAULT 0',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'tipe' =>'INT',
        'judul'=>'VARCHAR(255)',
        'url'=>'VARCHAR(255)',
        'status'=>'INT(1) DEFAULT 1',
        'tipe'=>'INT(1)',
        'ekserp'=>'TEXT',
        'isi'=>'text',
    );
     
    public $statuskode = array(
        '1'=>'Saved',
        '2'=>'Submitted',
        '3'=>'Reject : re Edit',
        '4'=>'Reject : Content Warning',
        '5'=>'Reject : Others',
    );
}