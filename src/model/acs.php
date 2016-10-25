<?php
/*

 nama kelas akan menjadi nama tabelnya ->acs
 
    $columns -> adalah nama kolom-kolomnya, harus ada
    $firstdata  -> adalah data bila tabel belum berisi record
                ->  boleh tidak ada
                
 tidak perlu memakai kolom primary karena akan 
 dibuatkan otomatis sebaga id INT AUTO_INCREMENT PRIMARY KEY,
 

 level : 1.Admin            : manage akun
         2.Redaktur/Editor  : manage posting   
         3.Contrib          : manage miliknya sendiri 
         
*/

class Acs extends Model{
    protected $columns=array(
        'email'=>'VARCHAR(128)',
        'sandi'=>'VARCHAR(128)',
        'level'=>'INT(1)',
    );
/* 
    email dan sandi default 
    data yang akan masuk otomatis
    bila record kosong
*/
    protected $firstdata = array(
       array(
           'email'=>'admin@email.com',
           'sandi'=>'admin',
           'level'=>'1',
        ),
    );
    
    function getLevel(){
        return array(
            '1'=>'Admin, Pemred ',
            '2'=>'Redaktur, Editor',
            '3'=>'Reporter, Kontributor, Koresponden',
        );
    }
    
/* end of Acs */    
}