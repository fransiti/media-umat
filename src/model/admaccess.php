<?php

/*
table untuk login pengirim
*/
class Admaccess extends Model{
    protected $columns = array(
        'admprofile_id' =>  'INT',
        'email'         =>  'VARCHAR(128)',
        'pwd'           =>  'VARCHAR(128)',
        'level'         =>  'INT(1)',
    );
    protected $firsdata = array(
        array(
            'email' =>  'admin@email.com',
            'pwd'   =>  'admin',
            'level' =>  '1',
            ),
    );
    
    public $level= array(
        '1' => 'Pimpinan Redaksi',
        '2' => 'Staf Khusus',
        '3' => 'Redaksi', 
    );
    
    
/* akhir admaccess */   
}