<?php

/*
 tabel untuk seluruh posting masuk
 excerpt bisa abstraksi atau paragraf pertama,
 ini nanti yang akan di isikan ke rss.
*/
 
class Posting extends Model{
    protected $columns = array(
        'menu_id'=>'INT DEFAULT 0',
        'author_id'=>'INT',
        'acs_id'=>'INT',
        'url'=>'VARCHAR(128)',
        'tgl'=>'DATE',
        'jam'=>'TIME',
        'rilis'=>'INT(1) DEFAULT 0',
        'hit'=>'BIGINT',
        'img'=>'VARCHAR(24)',
        'judul'=>'VARCHAR(128)',
        'subjudul'=>'VARCHAR(255)',
        'ekserp'=>'VARCHAR(512)',
        'isi'=>'TEXT',
    );
} 
        