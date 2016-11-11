<?php

/*
log pengirim
*/
class Ctrlog extends Model{
    protected $columns = array(
        'ctrprofile_id' => 'INT',
        'tgl'           => 'DATE',
        'jam'           => 'TIME',
        'ip'            => 'VARCHAR(24)',
    );
}