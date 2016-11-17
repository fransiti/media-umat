<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:23:46
         compiled from "/media/Share/Web/github/media-umat/src/reporter/tpl/sidebar.html" */ ?>
<?php /*%%SmartyHeaderCode:1383447485582d30d2523667-95970988%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25352f556f7871f481f7af2a0dc75c872525f7a9' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/reporter/tpl/sidebar.html',
      1 => 1479104002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1383447485582d30d2523667-95970988',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ava' => 0,
    'profile_ava' => 0,
    'baseurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d30d2557ba8_56912300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d30d2557ba8_56912300')) {function content_582d30d2557ba8_56912300($_smarty_tpl) {?><button id="menu-toggle" type="button" class="btn btn-primary">
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
    background-color: #333;
    }
</style>
    <ul class="sidebar-nav">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" data-target="#">
                <img src="<?php echo $_smarty_tpl->tpl_vars['ava']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['profile_ava']->value;?>
/24" class="img-circle img-shaddow">&nbsp;&nbsp;Change&nbsp;&nbsp;&nbsp;<span class="caret"></span>
            </a>
             <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                 <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
profile">Profile</a></li> 
                 <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
account">Account</a></li>
                 
            </ul>
            
        </li>
        <li class="nav-divider"></li>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
">Draft</a>
        </li>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
release">Rilis </a>
        </li>
        <li class="nav-divider"></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
logout">Logout</a></li>
        
    </ul>
</div>

<!-- /#sidebar-wrapper --><?php }} ?>
