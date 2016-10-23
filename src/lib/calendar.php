<?php
/*
 * Koio
 * An open source application development framework for PHP
-----------------------------------------------------------------------------
The MIT License (MIT)

Copyright (c) 2015 agus-ariyanto

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-----------------------------------------------------------------------------
 * @package	Koio
 * @author	agus ariyanto
 * @email 	agus.ariyanto.solo@gmail.com
 * @since	Version 1.0.0
 * @filesource
*/


/*
 * untuk menampilkan kalendar
 */
class Calendar{
  /**
   * Nama hari, bulan dipaksa pakai bahasa indonesia
   * tidak tergantung lokalisasi.
   */
  protected $_days   = array('Senin','Selasa','Rabu','Kamis',
                             'Jum`at','Sabtu','Minggu');
  protected $_months = array('Januari','Februari','Maret','April',
                             'Mei','Juni','Juli','Agustus','September',
                             'Oktober','November','Desember');

  /* hari libur selain minggu (greeting) */
  protected $_array  = array();
  /* css built in */
  protected $_css  = '' ;

/**
 * built in css
 */
  protected function writeCSS(){
$out = <<< HERE
<style>
  .cal{}
  .cal-prev{}
  .cal-month{}
  .cal-next{}
  .cal-days{}
  .cal-monday{}
  .cal-today{}
</style>
HERE;
    $this->_css=$out;
}


  /**
   * Bulan diambil 3 huruf pertama untuk format pendek
   */
  function shortTitle($day=null,$month=null){
      if(!empty($day)){
        foreach($this->_days as $key=>$val){
          $this->_days[$key]=substr($val,0,3);
        }
      }
      if(!empty($month)){
        foreach($this->_months as $key=>$val){
          $this->_months[$key]=substr($val,0,3);
        }
      }
    }

  /*
   * Hari libur selain minggu
   */
  function addGreet($key,$val){
    $this->_array[$key]=$val;
  }

  /*
   * Menampilkan kalender
   */
  function render($month=null,$year=null){
       return $this->display($month,$year);
  }
    
  function display($month=null,$year=null) {
    $date = time();
    if(empty($month)) $month=date('n');
    if(empty($year))  $year=date('Y');
    /*
     * wrap call
     *
     * -----------------
     * | < | Month | > |
     * -----------------
     */
    $day='0';
    if( date('Yn') == $year.$month ) $day=date('j');
    $first_day = mktime(0, 0, 0, $month, 1, $year);
    $day_of_week = date('D', $first_day);
    switch ($day_of_week) {
      case "Mon": $blank = 0;
        break;
      case "Tue": $blank = 1;
        break;
      case "Wed": $blank = 2;
        break;
      case "Thu": $blank = 3;
        break;
      case "Fri": $blank = 4;
        break;
      case "Sat": $blank = 5;
        break;
      case "Sun": $blank = 6;
        break;
    }
    $cal=$this->_css;

    $days_in_month = cal_days_in_month(0, $month, $year);
    $cal.= '<div class="cal">'.
      '<ul>'.
      '<li class="cal-prev"><a href="#">&lsaquo;</a></li>'."\n".
      '<li class="cal-month">'.$this->_months[$month-1] . ' ' . $year . '</li>'."\n".
      '<li class="cal-next"><a href="#">&rsaquo;</a></li>'."\n".
      '</ul><ul>';
    $days=array();
    foreach($this->_days as $key=>$val){
      $days[$key]='<li class="cal-days">'.$val.'</li>'."\n";
    }
    $days[6]='<li class="cal-monday">'.$this->_days[6].'</li>'."\n";
    $cal.=implode('',$days).
      '</ul>';
    $day_count = 1;
    $cal.='<ul>';
    while ($blank > 0) {
      $cal.= '<li>&nbsp;</li>'."\n";
      $blank = $blank - 1;
      $day_count++;
    }
    $day_num = 1;
    while ($day_num <= $days_in_month) {
      $li='<li>'.$day_num.'</li>'."\n";
      if($day_count==7){ $li='<li class="cal-monday">'.$day_num.'</li>'; }
      if($day==$day_num){$li='<li class="cal-today">'.$day_num.'</li>'; }
      foreach($this->_array as $key=>$val){
        if($key==$day_num){
          $li='<li><a href="'.$val.'">'.$day_num.'</a></li>';
        }
      }
      $cal.=$li;
      $day_num++;
      $day_count++;
      if ($day_count > 7) {
        $cal.= '</ul><ul>';
        $day_count = 1;
      }
    }
    while ($day_count > 1 && $day_count <= 7) {
      $cal.= '<li class="'.$day_count.'">&nbsp;</li>'."\n";
      $day_count++;
    }
    $cal.='</ul></div>';
    return $cal;
  }
}