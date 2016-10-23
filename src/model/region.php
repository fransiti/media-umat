<?php
/*
 tabel untuk wilayah leftjoin dengan author
*/
class Region extends Model{
    protected $columns = array (
        'nama'=>'VARCHAR(128)',
    );
    protected $firsdata=array(
        array(
            'nama'=>'Dki',
        ),
        array(
            'nama'=>'Jabar',
        ),
        array(
            'nama'=>'Jateng',
        ),
        array(
            'nama'=>'Jatim',
        ),
        array(
            'nama'=>'Kalimantan',
        ),
        array(
            'nama'=>'Riau',
        ),
        array(
            'nama'=>'Sulawesi',
        ),
    );
}    