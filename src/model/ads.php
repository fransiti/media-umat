<?php
class Ads extends Model{
    protected $columns=array(
        'adsclients_id'=>'INT',
        'start'=>'DATE',
        'stop'=>'DATE',
        'token'=>'VARCHAR(255)',
        'status'=>'INT(1) DEFAULT 0',
        'tipe'=>'INT(1) DEFAULT 0',
        'isi' =>'VARCHAR(255)',
        'url' =>'VARCHAR(255)',
        'link'=>'VARCHAR(255)',
    );
    
    public ads_tipe=array(
        '0'=>'Iklan Baris',
        '1'=>'Banner',
        '2'=>'Samping',
        '3'=>'Samping Dalam',
        '4'=>'Baner Dalam',
    );
    public status_kode=array(
        '0' => 'Tunggu',
        '1' => 'Tayang',
        '2' => 'Dicabut',
    );
}