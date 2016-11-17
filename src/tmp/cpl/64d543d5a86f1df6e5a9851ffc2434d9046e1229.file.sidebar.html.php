<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:30:19
         compiled from "/media/Share/Web/github/media-umat/src/redaktur/tpl/sidebar.html" */ ?>
<?php /*%%SmartyHeaderCode:1646078409582d2e440e0b72-20726569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64d543d5a86f1df6e5a9851ffc2434d9046e1229' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/redaktur/tpl/sidebar.html',
      1 => 1479357018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1646078409582d2e440e0b72-20726569',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d2e44122bf3_81638929',
  'variables' => 
  array (
    'ava' => 0,
    'profile_ava' => 0,
    'baseurl' => 0,
    'sidebar_menu' => 0,
    'val' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d2e44122bf3_81638929')) {function content_582d2e44122bf3_81638929($_smarty_tpl) {?><button id="menu-toggle" type="button" class="btn btn-primary">
        <span class="glyphicon glyphicon-align-justify menu-toggle-icon"></span>
</button>

<div id="sidebar-wrapper">
<style>
    .img-shaddow{
        box-shadow: 0px 0px 2px #fafafa;
    }
   .nav-divider {
    height: 1px;
    margin: 9px 0px;
    overflow: hidden;
    background-color: #acacac;
    }
</style>
    <ul class="sidebar-nav">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" data-target="#">
                <img src="<?php echo $_smarty_tpl->tpl_vars['ava']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_ava']->value;?>
/32" class="img-circle img-shaddow">&nbsp;&nbsp;Change&nbsp;&nbsp;&nbsp;<span class="caret"></span>
            </a>
             <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                 <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
profile">Profile</a></li> 
                 <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
account">Account</a></li>
                 
            </ul>
        </li>
            
        <li class="nav-divider"></li>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sidebar_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['val']->value=='-') {?>
        <li class="nav-divider"></li>
        <?php } else { ?>
        <li><a href=<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</a></li>
        <?php }?>
        <?php } ?>
        <li class="nav-divider"></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
logout">Logout</a></li>
    </ul>
</div>
<!-- /#sidebar-wrapper --><?php }} ?>
