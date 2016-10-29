## CONTOH PRAKTIS

Berikut ini adalah contoh implementasi, controller, model dan view, 

kita akan membuat kontak atau urlnya **`?u=kontak`**

Buat file **model/kontakmodel.php**

        <?php
            class KontakModel extends Model{
            /* 
            ini adalah nama kolom-kolomnya 
            berarti kontak mempunyai kolom id,nama,telpon 
            id ditambahkan oleh Model (parent class-nya)
            */
            protected $columns= array(
                'nama'   => 'VARCHAR(128)',
                'telpon' => 'VARCHAR(24)',
            );
                
            /* 
            ini adalah dua data pertama bila tabel kontak kosong
            variabel ini bleh diabaikan
            */
            protected $firstdata = array (
                array(
                    'nama'   => 'iwan',
                    'telpon' => '081xxx',
                ),
                array(
                    'nama'   => 'budi',
                    'telpon' => '0855xxx',
                ),
            );
            
            /* akhir kelas kontak */
            }        
            
.

Buat Controllernya file **ctrl/kontak.php**

Mempunyai tiga buah method yaitu 

- index() menampilkan daftar kontak
- submit() form menambah dan mengubah kontak
- delete() menghapus kontak 

.

                <?php
                    class Kontak extends BaseCtrl{
                        /*
                        method default menampilkan seluruh kontak
                        */
                        function index(){
                            $this->addModel('KontakModel');
                            
                            /* 
                            menampilkan record, 
                            dalam template dengam variabel {$kontak}
                            */
                            $this->_view->set('kontak',$this->KontakModel->select());
                        }

            
                    /* 
                    urlnya
                    ?u=kontak/submit record baru
                    ?u=kontak/submit/1 ubah record id=1
                    */    
                    function submit(){

                        $id=$this->_qry[0];
                        $this->addModel('KontakModel');
                        /*
                        bila ada post
                        */
                        if($this->_post->submitted()){
                            /* 
                            menambah atau mengubah record
                            */
                            $this->KontakModel->add( $this->_post->all() );
                            $this->KontakModel->save($id);

                            /*
                            redirect ke ?u=kontak/index
                            */
                            $this->redir('kontak');
                        }

                        /* 
                        variabel kosong untuk form
                        */
                        $this->_view->set('kontak',$this->KontakModel->colNames());
                        if(!empty($id)) $this->_view->set('kontak',$this->KontakModel->select($id));
                    }
        
                    /* 
                    fungsi hapus --> tanpa konfirmasi, langsung hapus
                    */
                    function delete(){

                        $id =$this->_qry[0];
                        $this->addModel('KontakModel');
                        /*
                        hapus berdasar id
                        */
                        if(!empty($id)) {
                            
                            $this->KontakModel->delete($id);
                            /*
                            redirect ke ?u=kontak/index
                            */
                            $this->redir('kontak');
                        }
                    }
                }



.

Dari Controller diatas kita membuat dua buah template yaitu  index.html untuk daftar kontak 
dan submit.html untuk menambah atau mengubah kontak , sedangkan delete tidak mempunyai template, karena langsung redirect ke index.
        

- file **tpl/kontak/index.html**
    
            <!doctype html>
            <html>

            <head>
                <meta charset="UTF-8">
                <title>Kontak</title>
            </head>

            <body>
                <h3>Daftar Kontak</h3> Buat 
                <a href="{$hta}kontak/submit">Kontak Baru</a>
                
                <ul>
                
                {foreach $kontak as $key=>$val}
                    <li>
                        {$val['nama']} &nbsp; - &nbsp;
                        <a href="{$hta}kontak/submit/{$val['id']}">
                            Edit
                        </a> &nbsp; - &nbsp;
                        <a href="{$hta}kontak/delete/{$val['id']}">
                            Hapus
                        </a>
                    </li>
                {/foreach}
                </ul>
    
            </body>

            </html>
                
.

- file **tpl/kontak/submit.html**


            <!doctype html>
            <html>
            
            {*  komentar ditulis seperti ini *}
            
            {*
                atau seperti ini    
            *}
            
            <head>
                <meta charset="UTF-8">
                <title>Kontak</title>
            </head>

            <body>
                <h3>Ubah Kontak</h3>
                
                <form name="form" action="{$url}" method="post">
                    <label>Nama</label><br>
                    <input type="text" name="nama" value="{$kontak['nama']}"><br>
                    <label>Nama</label><br>
                    <input type="text" name="telpon " value="{$kontak[ 'telpon']}">
                    <br>
                    <br>
                    <button type="submit" name="submit" value="submit">Simpan</button>
                </form>
            </body>

            </html>
            
sekarang kita coba lihat di url `?u=kontak`
                
---
##### akhir CONTOH PRAKTIS