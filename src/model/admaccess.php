<?php

/*
table untuk login pengirim
*/
class Admaccess extends Model{
    protected $columns = array(
        'admprofile_id' =>  'INT DEFAULT 0',
        'email'         =>  'VARCHAR(128)',
        'pwd'           =>  'VARCHAR(128)',
        'level'         =>  'INT(1)',
    );
    protected $firstdata = array(
        array(
            'email' =>  'admin@email.com',
            'pwd'   =>  'admin',
            'level' =>  '1',
            ),
    );
    
    public $adminlevel= array(
        '1' => 'Pimpinan Redaksi',
        '2' => 'Staf Khusus / Pertimbangan',
        '3' => 'Dewan Redaksi / Editor', 
        '4' => 'Tata Usaha',
    );
    

    
/* akhir admaccess */   
}