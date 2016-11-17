<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:23:46
         compiled from "/media/Share/Web/github/media-umat/src/reporter/tpl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1014319241582d30d237f309-33015179%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05346ed7a66d8ffaf44b899c710c22d5156ce8c5' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/reporter/tpl/index.html',
      1 => 1479137722,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1014319241582d30d237f309-33015179',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'draft' => 0,
    'val' => 0,
    'tipe' => 0,
    'color' => 0,
    'status' => 0,
    'baseurl' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d30d24cc938_95568065',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d30d24cc938_95568065')) {function content_582d30d24cc938_95568065($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php echo $_smarty_tpl->getSubTemplate ("sidebar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3>Daftar Draft</h3>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            
                            <th class="text-right">
                                <a href="#" data-toggle="modal" data-target="#draft-dialog" class="btn btn-primary">Baru</a>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $_smarty_tpl->tpl_vars['color'] = new Smarty_variable(array('text-primary','text-info','text-success','text-danger','text-danger','text-warning'), null, 0);?>
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
                            <td class="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['val']->value['status'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['color']->value[$_tmp2];?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['val']->value['status'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['status']->value[$_tmp3];?>
</td>
                            <td class="text-right"><?php if ($_smarty_tpl->tpl_vars['val']->value['status']!='2') {?>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['status']==1) {?> 
                                <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
submit/<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" class="text-success">Submit</a>&nbsp;&nbsp;
                                <?php }?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
compose/<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" class="text-primary">Edit</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" class="text-danger btn-delete" data-title="<?php echo $_smarty_tpl->tpl_vars['val']->value['judul'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">Hapus</a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="draft-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form name="draft-form" role="form" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Draft Baru</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Format</label>
                        <input type="hidden" name="judul" value="untitled">
                        <select name="tipe" class="form-control">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tipe']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Ok</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!---->
<div class="modal fade" id="del-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form name="del-form" role="form" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
compose_delete" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p id="draft-title"></p>
                        <input type="hidden" id="draft-id" name="id">
                        <p class="text-info"><small>
                            menghapus draft ini akan menghapus seluruh<br>
                            sub item yang termasuk bagian draft ini 
                            </small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" value="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
 $(function(){
     $('.btn-delete').click(function(e){
         e.preventDefault();
         var i=$(this).attr('data-id');
         var t=$(this).attr('data-title');
         $('#draft-title').html('Draft <strong>'+t+'</strong> akan dihapus..');
         $('#draft-id').attr('value',i);
         $('#del-dialog').modal();
     });
 });
</script>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
