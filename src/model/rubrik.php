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
    /*
    tipe berita
    dan fragmen berita masuk dalam kolom yang sama
    */
    public $tipe = array(
        '1'=>'Berita',
        '2'=>'Foto',
        '3'=>'Video',
    );
    /* end of rubrik */
}