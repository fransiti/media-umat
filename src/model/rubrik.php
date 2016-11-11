<?php
class Rubrik extends Model{
    protected $columns = array(
        'rubrik_id'=>'INT DEFAULT 0',
        'nama'=>'VARCHAR(128)'
    );
        
        
    protected $firstdata = array(
        array(
            'nama'=>'Politik',
        ),
            
        array(
            'nama'=>'Olah Raga',
        ),
    );
    public $tipe = array(
        '1'=>'Berita',
        '2'=>'Foto',
        '3'=>'Video',
        '4'=>'Laporan Khusus',
        '5'=>'Profile',
    );

    /* end of rubrik */
}