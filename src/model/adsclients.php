<?php
class Adsclients extends Model{
    protected $columns=array(
        'nama'=>'VARCHAR(128)',
        'tipe'=>'INT(1) DEFAULT 0',
        'phone'=>'VARCHAR(24)',
        'alamat'=>'VARCHAR(255)',
        'kota'=>'VARCHAR(128)',
        'pwd'='VARCHAR(128)',
    );
    public tipe_client=array(
        '0'=>'User',
        '1'=>'Member',
        '2'=>'Biro',
    );
    
} 