<?php
/*
message board
*/


class Msgboard extends Model{
  protected $columns =   array(
      'author_id'=>'INT',
      'tgl'=>'DATE',
      'jam'=>'TIME',
      'isi'=>'VARCHAR(512)',
  );
}