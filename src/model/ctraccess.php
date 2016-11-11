<?php

/*
table untuk login pengirim
*/
class Ctraccess extends Model{
    protected $columns = array(
        'ctrprofile_id' =>  'INT',
        'email'         =>  'VARCHAR(128)',
        'pwd'           =>  'VARCHAR(128)',
    );
}