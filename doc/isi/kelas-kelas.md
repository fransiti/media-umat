###  KELAS-KELAS DASAR


#### CONTROLLER

File controller diletakkan dalam `ctrl/`

Apabila controller diturunkan dari `BaseCtrl` maka akan didapat properti-properti
yang telah di inisialisasi yaitu

- $_view : kelas View 
- $_post : kelas Post
- $_render : Apakah menampilkan template atau tidak, default 1(true) berarti menampilkan template.

Dan variabel-variabel yang diteruskan ke dalam template, 
( dalam template menjadi tanpa garis bawah )

- $\_baseurl : nama\_kelas/nama\_method  ( diteruskan dalam template sebagai{$baseurl} )
- $\_qry  : array dari qry[0].. 
- $\_hta  : `?u=` 
- $\_url  : Request asli ( `$_GET['u']` )
- $\_header : title dan subtitle untuk template
- $\_meta   : meta untuk template

Method-method dalam kelas ini

- createMenu() : inisialisasi variabel $menu untuk template, berisi data dari tabel menu (`model/menu.php`), 
nilai kembalian adalah array bertingkat atau kalau memakai `var_dump($this->createMenu())` hasilnya

        
        array (
            0 => array (
                'nama' => 'nama_satu',
                'url'  => 'url_satu',
                
                'submenu'=> 
                    0 => array (
                            'nama'=>'sub_satu',
                            'url' =>'urlsub_satu'
                    ),
                    1 => array (
                            'nama' => 'sub_dua',
                            'url' =>'urlsub_dua',
                    ),   
            ),
        );
        

- pagination($halaman\_ini,$jumlah\_record,$nama\_paginasi) : membuat paginasi, $nama\_paginasi adalah variabel 
untuk template dan mempunyai nilai default `{$pagination}`, banyaknya record perhalaman berdasar `$record_perpage` atau nilai `$db['rec']` 
dalam cfg/db.php

    - $pagination['first'] : halaman awal, nilai 0 bila halaman ini < 2
    - $pagination['prev'] : halaman sebelum halaman ini  nilai 0 bila  halaman ini < 3 
    - $pagination['page'] : halaman ini
    - $pagination['next'] : halaman setelah ini, nilai 0 bila  halaman ini > total-2 
    - $pagination['last'] : halaman , nilai 0 bila halaman ini > total-1
    - $pagination['rec\_count'] : jumlah record
    - $pagination['total'] : total halaman
    
    dibawah ini `var_dump` dengan $this->pagination(3,250);
    
            array(
                'first' => '1',
                'prev'  => '2',
                'page'  => '3',
                'next'  => '4',
                'last'  => '5',
                'rec_count' =>'250',
                'total' => '5',
            );
                
.    
   
- redir(url) sama dengan redirect dengan `header('location: url')` dengan mebuang semua $\_POST.
- setUrl() untuk menganti nilai $\_url
- setMeta() untuk mengganti/menambah meta
- setHeader() untuk mengganti/menambah header
- addModel(nama\_kelas) cara aman untuk menambahkan kelas sebagai anggota, nama\_kelas akan menjadi propertinya, misalnya

        $this->addModel('session');
        /* session menjadi nama propertinya */
        $this->session->..
        
.        

- notfound() menampilkan http 404 not found

---

.

#### MODEL

File model diletakkan dalam `model/`

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
- leftJoin($nama\_tabel,$kolom\_tabel,$reverse) membuat tabel left join, kolom  join adalah `tablesatu.id = tabledua.tablesatu_id`, 
sedangkan apabila $reverse bernilai 1 maka dibalik kolom join menjadi `tabledua.id = tablesatu.tabledua_id`. 
Kolom-kolom tabeldua akan ditampilkan sebagai tabledua_namakolom. Contohnya

            <?php
            /*
            misalnya
            tbsatu kolomnya adalah id, nama,alamat,
            tbdua kolomnya adalah id, tbsatu_id, email,pwd
            tbtiga kolomnya adalah id,tbsatu_id,kota
            
            membentuk SELECT FROM tbsatu 
            LEFT JOIN tbdua ON tbsatu.id = tbdua.tbsatu_id ,
            LEFT JOIN tbtiga ON tbsatu.id = tbtiga.tbsatu_id 
            
            */
            
                
            $tbsatu->leftJoin($tbdua.tableName(),tbdua.colName);
            $tbsatu->leftJoin($tbtiga.tableName(),tbtiga.colName);
            
            
            /*
            
            hasilnya bila pake var_dump adalah  
            
            array (
                0 => array (
                            'id'   => 1,
                            'nama' => 'iwan',
                            'alamat'=> 'jl.merdeka',
                            'tbdua_id'=>'1',
                            'tbdua_email'=>'iwan@yahoo.com',
                            'tbdua_pwd'=>'rahasia',
                            'tbtiga_id'=>'2',
                            'tgtiga_kota'=>'jakarta',
                            ),
                1 => array (
                            'id'   => 2,
                            'nama' => 'zaskia',
                            'alamat'=> 'jl.embong',
                            'tbdua_id'=>'2',
                            'tbdua_email'=>'zaskia@gmail.com',
                            'tbdua_pwd'=>'rahasiajuga',
                            'tbtiga_id'=>'1',
                            'tgtiga_kota'=>'surabay',
                            ),
                
                // dst...
                );
                
            */    

            var_dump($tbsatu->select());
            
            
.

        
- secLeftJoin($nama\_tabel_kedua,$nama\_table\_ketiga,$kolom\_table\_ketiga) membuat query `LEFT JOIN` dengan kolom join tabel kedua dan ketiga,
dengan syarat left join tabel pertama telah di left join. Nama kolom yang ditampilkan sama dengan `leftJoin()` 
misalnya

            /* 
            misalnya
            tbsatu kolomnya adalah id, nama,alamat,
            tbdua kolomnya adalah id, tbsatu_id, email,pwd
            tbtiga kolomnya adalah id,tbdua_id,kota
            
         
            membentuk SELECT FROM tbsatu 
            LEFT JOIN tbdua ON tbsatu.id = tbdua.tbsatu_id ,
            LEFT JOIN tbtiga ON tbdua.id = tbtiga.tbdua_id 
         

            
                
            */    
                
            $tbsatu->leftJoin($tbdua.tableName(),tbdua.colName);
            $tbsatu->secLeftJoin($tbdua.tableName(),$tbtiga.tableName(),tbtiga.colName());

            /*
            
            hasilnya bila pake var_dump adalah
            
            array (
                0 => array (
                            'id'   => 1,
                            'nama' => 'iwan',
                            'alamat'=> 'jl.merdeka',
                            'tbdua_id'=>'1',
                            'tbdua_email'=>'iwan@yahoo.com',
                            'tbdua_pwd'=>'rahasia',
                            'tbtiga_id'=>'2',
                            'tgtiga_kota'=>'jakarta',
                            ),
                1 => array (
                            'id'   => 2,
                            'nama' => 'zaskia',
                            'alamat'=> 'jl.embong',
                            'tbdua_id'=>'2',
                            'tbdua_email'=>'zaskia@gmail.com',
                            'tbdua_pwd'=>'rahasiajuga',
                            'tbtiga_id'=>'1',
                            'tgtiga_kota'=>'surabay',
                            ),
                
                // dst...
                );
                
            */    

            var_dump($tbsatu->select());


- orderBy($nama_kolom,$descending) membentuk query ORDER BY dengan default `ORDER BY .. DESC` 
apabila ingin `ASC` beri nilai $descending dengan selain '1'.

- groupBy($nama_kolom) membentuk query GROUP BY
- byRandom() membentuk query dengan order random atau `ORDER BY RAND()`
- select($id) membentuk query SELECT, apabila id diberi nilai maka akan membentuk query `SELECT .. FROM .. WHERE id=$d LIMIT 1`
        
        <?php
        
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
            tidak seperti dengan atas
            bila id dipakai sebagai andWhere 
            kembalian berupa array bertingkat 
            
                $res= array(
                    0 => array (
                        kolom=>nilai_kolom
                    ),
                );
            */
            
            $table->andWhere('id',$id);
            $res=$table->select();
        

- save($id) membentuk query `INSERT` atau `UPDATE` tergantung dengan $id, bila mempunyai nilai 
maka query yang dibentuk adalah `UPDATE.. WHERE id=$id` nilai kembalian adalah $id ,  sebaliknya akan membentuk `INSERT INTO ..` 
dengan nilai kembalian adalah `last_insert_id()`.

            
            <?php
                /*
                ini UPDATE .. SET WHERE id=$id
                */
                $table->id=$id;
                $table->colVal('nama',$nama);
                $table->save();
            
                /* 
                ini juga UPDATE..
                */
                $table->colVal('nama',$nama);
                $table->save($id);
            
                /*
                ini insert
                */
                $table->colVal('nama',$nama);
                $table->save();

- delete($id) membentuk query `DELETE FROM .. WHERE id=$id`
- selectFunction($fungsisql) membentuk query SELECT dari fungsi MySQL. 

            <?php
            
                /* 
                sama dengan SELECT CURDATE()
                */
            
                $res=$table->selectFunction('CURDATE()');
            
            
- add(array $kolom\_value) memasukkan nilai kedalam kolom dengan array, array\_kolom yang tidak sesuai, 
tidak ada nilainya atau bernilai kosong akan diabaikan. misalnya dari POST bisa langsung dengan
            
            <?php
                /* 
                query select  
                */
                
                $table->add($this->_post->all());
                $table->select();
    
                /* 
                query insert 
                */
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
1 untuk resource ( `INSERT`, `UPDATE`, `DELETE` ) atau array untuk query `SELECT`.


---

.


#### KELAS VIEW

Apabila controller diturunkan dari BaseCtrl, maka kelas view telah diinisialisas dalam property $_view

Method-method dari View antara lain

- set($nama\_variabel,$nilai\_variabel) untuk meletakkan variabel dalam template

- setTpl($nama\_template) mengganti file template dari template defaultnya. $nama\_template tanpa extensi.
Default filetemplate adalah nama methodnya misalnya controller Admin, methodnya login(), maka templatenya adalah `./tpl/admin/login.html`
       
- setDir($dir) mengganti direktori template 

contoh  
    
        /* 
        merubah direktori template dan file template menjadi
        tpl/lain/halaman.html
        */   
        $this->_view->setDir('lain');
        $this->_view->setTpl('halaman');
        
        
- fetch() template hanya dirender dalam buffer

        // jangan merender template lagi
        $this->_render=false;
        
        $buffer = $this->_view->fetch();
        echo $buffer;

- render() merender dan mengirimkan template ke browser, fungsi ini secara explisit tidak perlu dilakukan, 
karena controller otomatis akan merender di akhir rutin (lihat method ` __destruct()` dalam `/ctrl/basectrl.php`)

.

#### TEMPLATE

File template diletakkan dalam `tpl/controller/` dengan nama method dari controllernya.

misalnya request
    
    ?u=admin/login

maka

   - controller adalah Admin
   - method `login()`
   - maka template-nya adalah `tpl/admin/login.html`
   

Kelas View merender template dengan menggunakan [Smarty Template Engine](http://www.smarty.net), maka penulisan sintaks 
yang akan diparsing mengikuti aturan dari Smarty. 

Smarty memparsing `{..}` (kurawal tanpa spasi) dimanapun letaknya dalam template. Problem yang seringkali muncul adalah kalau kita menuliskan 
inline script dalam template. sedangkan eksternal file tidak diparsing misalnya yang diletakkan dalam folder css/js, 
kecuali file yang disertakan dengan memakai sintaks `{include file="namafile.html"}`

Sintaks komentar adalah diapit dengan `{* .. *}` ( kurawal asterisk )

Berikut ini contoh penulisan script yang ditolak
        
        <script>
            $(function()){$('.btn').click(function(e){console.log('clicked');})}
        </script>
        
Ini juga ditolak meskipun kurawal memakai spasi

        <script>
            $(function()){ $('.btn').click(function(e){ console.log('clicked'); }); }
        </script>        

Penulisan script yang tidak menimbulkan konflik seperti ini

        <script>
            $(function(){
                $('.btn').click(function(e){
                    console.log('clicked');
                });
            });
        </script

Variabel `{$var}` ini akan diparsing oleh smarty

        <script>
            $(function(){
                $('.btn').click{
                    var i = "{$var}";
                    console.log(i);
                } 
            });
            
Sintaks yang umum dipakai dalam smarty

- `{$var}`  sama dengan perintah php  `<?php echo $var; ?>`

- `{$var.nama}`, `{$var['nama']}` sama dengan `<?php echo $var['nama']; ?>`

- `{$var.nama.subnama}`, `{$var['nama'].subnama}` atau `{$var.nama['subnama']}`  sama dengan `<?php echo $var['nama']['subnama'];?>`


- `{if $var eq 1 }` .. `{/if}` atau `{if $var=1}` .. `{else}` .. `{/if}` sama dengan `<?php if($var=1){ ?>` .. `<?php } ?>`

- `{foreach $var as $key=>$val}` .. `{/foreach}` sama dengan `<?php foreach($var as $key=>$val){ ?>` .. `<?php } ?> 



Dari template sudah ada variabel yang siap dipakai yaitu

- `{$hta}` atau `?=u` dibutuhkan bila nanti mengunakan pretty_url htaccess.

- `{$baseurl}` atau `?u=nama_kelas/nama_method`

- `{$url}` atau sama dengan `$_GET['u']` 


Path relatif untuk script dan style menurut foldernya

- `{$css}` path untuk file css

- `{$js}` path untuk file js

- `{$img}` path untuk file img, ini bukan direktori upload untuk image, melainkan untuk image tambahan seperti image untuk loading dll

- `{fonts}` path untuk fonts


---

.

##### akhir kelas-kelas dasar