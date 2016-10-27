## BAB II.MODEL

#### KELAS MODEL

File model diletakkan dalam ./model

File model yang diturunkan dari kelas Model harus mempunyai property $column yang berisi nama kolom untuk tabelnya, 
tanpa kolom index. Model akan membuatkan kolom index dengan **id INT AUTO_INCREMENT PRIMARY KEY**

Apabila ingin mempunyai sebuah record default, buatlah property *$firstdata* yang berisi array

contoh membuat tabel akun dengan kolom nama dan pwd dan mempunyai record pertama 
        
        <?php
        
            class Login extends Model{
                protected $columns = array(
                  'nama'=> 'VARCHAR(128)',
                  'pwd' => 'VARCHAR(100)',
                );
                protected $firstdata = array(
                    array (
                     'nama'=>'admin',
                     'pwd'=>'admin',
                    ),
                );
            } 


Nama-nama kolom akan menjadi property modelnya. Pada contoh diatas kelas akun akan mempunyai properti $id, $nama, $pwd.

Method-method yang diturunkan dari kelas Model adalah

- tableName() mengembalikan nama tabel. biasa digunakan untuk left join.

- colNames() mengembalikan array kolom-kolomnya. biasa digunakan untuk left join.

- limit($banyak_record) mengatur limit record, tanpa limit, tabel akan menampilkan sejumlah record dengan global variable $db['rec'], 
lihat di `cfg/db.php`

- curPage($offset) mengatur offset, bila tidak diatur maka offset adalah 0 atau `curPage(1)`, offset mempunyai nilai **($offset-1)*limit.**

- colVal($nama_kolom,$nilai_kolom,$operator) Memasukkan nilai untuk insert atau update dengan memakai sanitizer atau `mysql_real_escape` 
dan ditambah `"\'"` untuk tiap nilainya. $operator mempunyai nilai default '='. 
Apabila nilai_kolom merupakan fungsi pakailah properti-nya misalnya kolom tanggal akan diisi `CURDATE()` dalam model $posting maka  
        
            <?php
                $posting->tanggal = 'CURDATE()';
                
.

- andWhere($nama_kolom,$nilai_kolom,$operator) memasukkan ke dalam kondisi `AND WHERE ..` dengan 

- andWhereFunction($nama_kolom,$nilai_kolom,$operator) memasukkan ke dalam kondisi `AND WHERE ..` tanpa sanitizer

- orWhere($nama_kolom,$nilai_kolom,$operator) memasukkan ke dalam kondisi `OR WHERE ..`

- andWhereFunction($nama_kolom,$nilai_kolom,$operator) memasukkan ke dalam kondisi `OR WHERE ..` tanpa sanitizer

- leftJoin($nama_tabel,$kolom_tabel,$reverse) membuat tabel left join, kolom  join adalah `tabledua.id = tablesatu_id`, 
sedangkan apabila $reverse bernilai 1 maka dibalik kolom join menjadi `tablesatu.id = tabledua_id`. 


- secLeftJoin($nama_tabel_kedua,$nama_table_ketiga,$kolom_table_ketiga) membuat query LEFT JOIN dengan kolom join tabel kedua dan ketiga,
dengan syarat left join tabel pertama telah di left join.
misalnya
        
        /* membentuk SELECT FROM table_satu LEFT JOIN table_dua ON table_dua_id = table_satu.id , 
           LEFT JOIN table_tiga ON table_dua_id = table_tiga.id */
        
        $table_satu->leftJoin($table_dua->tableName(),$table_dua->colNames());
        $table_satu->secLeftJoin($table_dua->tableName(),$table_tiga->colNames());
        
- orderBy($nama_kolom,$descending) membentuk query ORDER BY dengan default `ORDER BY .. DESC` apabila
ingin `ASC` beri nilai $descending dengan selain '1'.

- groupBy($nama_kolom) membentuk query GROUP BY

- byRandom() membentuk query dengan order random atau `ORDER BY RAND()`

- select($id) membentuk query SELECT, apabila id diberi nilai maka akan membentuk query `SELECT .. FROM .. WHERE id=$d LIMIT 1`
    
        /* 
        query ini 
        kembalian array satu tingkat
            $res=array(
                nama_kolom => nilai kolom
            );
        */
        $res=$table->select($id);
        
        /* 
        sama dengan diatas 
        */
            $table->id=$id;
            $res=$table->select();
     
    
    
        /* 
        tidak sama dengan atas
        kembalian adalah array bertingkat 
            $res= array(
                0 => array (
                    kolom=>nilai_kolom
                ),
            );
        */
        $table->andWhere('id',$id);
        $res=$table->select();


- save($id) membentuk query INSERT atau UPDATE tergantung dengan $id bila bernilai maka query yang dibentuk adala `UPDATE.. WHERE id=$id`, 
sebaliknya akan membentu `INSERT INTO`

- delete($id) membentuk query `DELETE FROM .. WHERE id=$id`

- selectFunction($fungsisql) membentuk query SELECT dari fungsi MySQL. 
            
            /* 
            sama dengan SELECT CURDATE()
             */
            
            $res=$table->selectFunction('CURDATE()');
            
            
            
- add(array $kolom__value) memasukkan nilai kedalam kolom dengan array, array_kolom yang tidak sesuai, tidak ada nilainya atau bernilai kosong akan diabaikan.
misalnya dari POST bisa langsung dengan
    
            /* query select  */
                $table->add($this->_post->all());
                $table->select();
    
            /* query insert */
                $table->add($this->_post->all());
                $table->save();
            
- countRec($where) membuat query `SELECT count(id) WHERE $where` atau kalau $where tidak bernilai, 
akan diambilkan dari kondisi WHERE sebelumnya.

.

#### DbSQL

Method yang diturunkan dari DbSQL

- sanitize($val) sama dengan `'\''.mysql_real_escape_string($val).'\''`

.

Method yang hanya biasa dijalankan saat debug / develop

- is_connect() true untuk terhubung dan sebaliknya

- getError() menampilkan error dari mysql

- testQry() menampilkan query yang dibentuk 

- query($sqlqry) menjalankan sama dengan `mysql_query($sqlqry)` dengan nilai yang dikembalikan adalah 0 untuk error, 
1 untuk resource ( `INSERT`, `UPDATE`, `DELETE` ) atau array untuk query `SELECT`

.

---            
##### akhir BAB II.MODEL