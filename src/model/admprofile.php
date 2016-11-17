<?php

/*
tabel untuk profil  pengirim
ava foto disimpan dalam /upl/ava
*/
class Admprofile extends Model{
    protected $columns = array(
        'nama'      =>  'VARCHAR(255)',
        'ava'       =>  'VARCHAR(32)',
        'profesi'   =>  'VARCHAR(128)',
        'tentang'   =>  'TEXT',
    );
    
    /*
     ini hanya dipakai untuk session
     saat check login leftjoin access
    */
    public $column_avail=array (
        'nama'  =>  '',
        'ava'   =>  '',
    );
}
    