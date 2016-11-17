<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:27:55
         compiled from "/media/Share/Web/github/media-umat/src/redaktur/tpl/drafts.html" */ ?>
<?php /*%%SmartyHeaderCode:122530128582d31cb86a682-13462943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1af8f96760f3202b73cab865d93d0a470059dd3' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/redaktur/tpl/drafts.html',
      1 => 1479322031,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122530128582d31cb86a682-13462943',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'draft' => 0,
    'val' => 0,
    'tipe' => 0,
    'baseurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d31cb919341_56671454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d31cb919341_56671454')) {function content_582d31cb919341_56671454($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php echo $_smarty_tpl->getSubTemplate ("sidebar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3>Submitted Draft</h3>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Pengirim</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['draft']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['tgl'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['judul'];?>
</td>
                            <td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['val']->value['tipe'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['tipe']->value[$_tmp1];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ctrprofile_nama'];?>
</td>
                            <td class="text-right">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
draft-eval/<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" class="btn btn-success">Evaluasi</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
