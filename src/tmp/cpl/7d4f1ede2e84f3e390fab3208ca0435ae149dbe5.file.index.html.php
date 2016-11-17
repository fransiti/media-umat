<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 13:48:51
         compiled from "/media/Share/Web/github/media-umat/src/tatausaha/tpl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:2092697434582d4bbd08f6a2-94476277%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d4f1ede2e84f3e390fab3208ca0435ae149dbe5' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/tatausaha/tpl/index.html',
      1 => 1479365329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2092697434582d4bbd08f6a2-94476277',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d4bbd100394_26350530',
  'variables' => 
  array (
    'background' => 0,
    'baseurl' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d4bbd100394_26350530')) {function content_582d4bbd100394_26350530($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("banner.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<style>
    .thumbnail{
        padding:5px;
    }
    .thumbnail>img{
        width:100%;
        height:auto;
    }
</style>
<div class="container">
<div class="row">
  <div class="col-md-4">
    <div class="thumbnail">
      <img src="<?php echo $_smarty_tpl->tpl_vars['background']->value;?>
/darkcyan/400">
      <div class="caption">
        <h3>PASANG IKLAN</h3>
          <p>Pasang iklan dihalaman 
            <a href="http://www.seruji.com">Seruji.com</a> hanya sekali saja
              tidak perlu mendaftar menjadi member
          </p>
          <a href="#" class="btn btn-primary" role="button">Go..</a>   
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="thumbnail">
      <img src="<?php echo $_smarty_tpl->tpl_vars['background']->value;?>
/darkgreen/400">
      <div class="caption">
        <h3>JADI MEMBER</h3>
          <p>dengan menjadi member,
            <a href="http://www.seruji.com">Seruji.com</a>
              dapatkan potongan menarik
              silahkan <strong><a href="">Daftar</a></strong>
          </p>
          <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
login" class="btn btn-success" role="button">Login</a>   
      </div>
    </div>
  </div>
    
  <div class="col-md-4">
    <div class="thumbnail">
      <img src="<?php echo $_smarty_tpl->tpl_vars['background']->value;?>
/red/400">
      <div class="caption">
        <h3>LAINNYA</h3>
          <p>Hanya melihat-lihat tarif iklan dan trafik pengunjung atau penawaran lainnya dari
            <a href="http://www.seruji.com">Seruji.com</a> 
          </p>
          <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
others" class="btn btn-danger" role="button">Go..</a>   
      </div>
    </div>
  </div>
    
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

          
        

<?php }} ?>
