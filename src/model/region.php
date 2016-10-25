<?php
/*
 tabel untuk wilayah leftjoin dengan author
 region untuk pengda media umat
*/
class Region extends Model{
    protected $columns = array (
        'nama'    =>'VARCHAR(128)',
        'wilayah' =>'VARCHAR(512)',
    );
    protected $firstdata=array(
        array(
            'nama'=>'DKI',
            'wilayah'=>'Jakarta,Bogor'
        ),
        array(
            'nama'=>'Jabar',
            'wilayah'=>'Bandung, Tasikmalaya, Cirebon',
        ),
        array(
            'nama'=>'Jateng',
            'wilayah'=>'Semarang, Surakarta, Tegal',
        ),
        array(
          'nama'=>'Jatim',
          'wilayah'=>'Jawa Timur',   
        ),
    );

/* end Region */
}    