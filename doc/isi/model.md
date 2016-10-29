## MODEL

#### KELAS MODEL

File model diletakkan dalam **model/**

File model yang diturunkan dari kelas Model harus mempunyai property $column yang berisi nama-nama kolom untuk tabelnya, 
tanpa kolom index. Model akan membuatkan kolom index dengan **id INT AUTO_INCREMENT PRIMARY KEY**.

Untuk kolom yang akan join aturan penamaan adalah `namatabeljoin_id INT`.

Apabila ingin mempunyai sebuah record default, buatlah property *$firstdata* yang berisi array.


Ini adalah contoh membuat tabel akun dan nantinya left join dengan tabel profil.

Tabel akun mempunyai kolom `nama` dan `pwd` dan mempunyai sebuah record pertama. 

Maka tabel profil harus mempunyai sebuah kolom join dengan nama `akun_id` atau sebaliknya.

File **model/akun.php** akan seperti ini

            <?php
        
                class Akun extends Model{
                
                    /* 
                    kolom tabel akun tanpa index
                    */
                    protected $columns = array(
                        'nama'=> 'VARCHAR(128)',
                        'pwd' => 'VARCHAR(100)',
                    );
                    
                    /*
                    data pertama 
                    */
                    protected $firstdata = array(
                        array (
                            'nama'=>'admin',
                            'pwd'=>'admin',
                        ),
                    );
                    
            /* akhir kelas Akun */        
            } 

File **model/profil.php**

            <?php
            
                class Profil extends Model{
                    /*
                    nama kolom, harus mempunyai sebuah kolom join akun_id
                    */
                    protected columns = array (
                        'akun_id'       => 'INT',
                        'nama_lengkap'  => 'VARCHAR(128)',
                        'alamat'        => 'VARCHAR(256)',
                        'kota'          => 'VARCHAR(64)', 
                    );
                }




Nama-nama kolom akan menjadi property modelnya. Pada contoh diatas kelas akun akan mempunyai properti $id, $nama, $pwd.

Method-method yang diturunkan dari kelas Model adalah

- tableName() mengembalikan nama tabel. biasa digunakan untuk left join.
- colNames() mengembalikan array kolom-kolomnya. biasa digunakan untuk left join.
- limit($banyak\_record) mengatur limit record,  tanpa limit, tabel akan menampilkan sejumlah record dengan global $record_perpage, (lihat di `cfg/db.php`);
- curPage($offset) mengatur offset, bila tidak diatur maka offset adalah 0 atau `curPage(1)`, 
offset mempunyai nilai **($offset-1)*limit.**

- colVal($nama_kolom,$nilai_kolom,$operator) Memasukkan nilai untuk insert atau update dengan memakai sanitizer atau `mysql_real_escape` 
dan ditambah `"\'"` untuk tiap nilainya. $operator mempunyai nilai default '='. 
Apabila nilai\_kolom merupakan fungsi berilah nilai pada properti-nya misalnya kolom tanggal dalam tabel `posting` yang akan diisi `CURDATE()` maka akan seperti ini
        
            <?php
                $posting = new Posting;
                $posting->tanggal = 'CURDATE()';
                
.

- andWhere($nama\_kolom,$nilai\_kolom,$operator) memasukkan ke dalam kondisi `AND WHERE ..` dengan sanitizer
- andWhereFunction($nama_kolom,$nilai_kolom,$operator) memasukkan ke dalam kondisi `AND WHERE ..` tanpa sanitizer
- orWhere($nama\_kolom,$nilai\_kolom,$operator) memasukkan  kondisi `OR WHERE ..` dengan sanitizer
- andWhereFunction($nama_kolom,$nilai_kolom,$operator) memasukkan kondisi `OR WHERE ..` tanpa sanitizer
- leftJoin($nama\_tabel,$kolom\_tabel,$reverse) membuat tabel left join, kolom  join adalah `tabledua.id = tablesatu_id`, 
sedangkan apabila $reverse bernilai 1 maka dibalik kolom join menjadi `tablesatu.id = tabledua_id`. 

- secLeftJoin($nama\_tabel_kedua,$nama\_table\_ketiga,$kolom\_table\_ketiga) membuat query `LEFT JOIN` dengan kolom join tabel kedua dan ketiga,
dengan syarat left join tabel pertama telah di left join.
misalnya

         /* 
         membentuk SELECT FROM table_satu LEFT JOIN table_dua ON table_dua_id = table_satu.id ,
         LEFT JOIN table_tiga ON table_dua_id = table_tiga.id 
         */

        $table_satu->leftJoin($table_dua->tableName(),$table_dua->colNames());
        $table_satu->secLeftJoin($table_dua->tableName(),$table_tiga->colNames());


- orderBy($nama_kolom,$descending) membentuk query ORDER BY dengan default `ORDER BY .. DESC` 
apabila ingin `ASC` beri nilai $descending dengan selain '1'.

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
        

- save($id) membentuk query `INSERT` atau `UPDATE` tergantung dengan $id bila bernilai maka query yang dibentuk adala `UPDATE.. WHERE id=$id`, 
sebaliknya akan membentuk `INSERT INTO`

- delete($id) membentuk query `DELETE FROM .. WHERE id=$id`
- selectFunction($fungsisql) membentuk query SELECT dari fungsi MySQL. 
            
            /* 
            sama dengan SELECT CURDATE()
             */
            
            $res=$table->selectFunction('CURDATE()');
            
            
- add(array $kolom\_value) memasukkan nilai kedalam kolom dengan array, array\_kolom yang tidak sesuai, 
tidak ada nilainya atau bernilai kosong akan diabaikan. misalnya dari POST bisa langsung dengan
            
    
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

Method yang biasa dijalankan saat debug / develop

- is\_connect() memeriksa koneksi, `true` untuk terhubung dan sebaliknya

- getError() menampilkan error dari mysql

- testQry() menampilkan query yang telah dibentuk 

- query($sqlqry) sama dengan `mysql_query($sqlqry)` dengan nilai yang dikembalikan adalah 0 untuk error, 
1 untuk resource ( `INSERT`, `UPDATE`, `DELETE` ) atau array untuk query `SELECT`

.

lihat BAB V. CONTOH QUERY

---            
##### akhir MODEL