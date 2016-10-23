<?php
class Menu extends Model{
    protected $columns = array(
        'menu_id'=>'INT DEFAULT 0',
        'nama'=>'VARCHAR(128)',
        'url'=>'VARCHAR(128)',
        
    );
    protected $firstdata = array(
        array(
            'nama'=>'Rubrik Satu',
            'url'=>'rubrik-satu',
        ),
        array(
            'nama'=>'Rubrik Dua',
            'url'=>'rubrik-dua',
        ),
    );
}