<?php

/*
 tabel untuk seluruh draft sama dengan 
 posting hanya draft untuk miliknya sendiri,
 excerpt bisa abstraksi atau paragraf pertama,
 ini nanti yang akan di isikan ke rss.
 status : 1. Submitted -> diajukan sebagai rilis
 apabila submit diaccept - oleh editor 
 data draft dipindah ke tabel posting,
 draft dapat diakses siapa saja namun author adalah
 yang perttama menulis
 
*/
  
 
class Draft extends Model{
    protected $columns = array(
        'menu_id'=>'INT DEFAULT 0',
        'author_id'=>'INT',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'status'=>'INT(1) DEFAULT 0',
        'img'=>'VARCHAR(24)',
        'judul'=>'VARCHAR(128)',
        'subjudul'=>'VARCHAR(255)',
        'ekserp'=>'VARCHAR(512)',
        'isi'=>'TEXT',
    );
    
    function evalCode(){
        return array(
            '1'=>'Saved',
            '2'=>'Submitted',
            '3'=>'Rejected',
        );
    }
} 
        