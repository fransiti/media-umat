<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:25:28
         compiled from "/media/Share/Web/github/media-umat/src/redaktur/tpl/login.html" */ ?>
<?php /*%%SmartyHeaderCode:1917742074582d3138f39896-53720331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fea7128c54a592927b2c395baa63c3554624999' => 
    array (
      0 => '/media/Share/Web/github/media-umat/src/redaktur/tpl/login.html',
      1 => 1479190768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1917742074582d3138f39896-53720331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'css' => 0,
    'js' => 0,
    'url' => 0,
    'message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d3139082c24_03376666',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d3139082c24_03376666')) {function content_582d3139082c24_03376666($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
/ie10-bug.css" rel="stylesheet">
    <link href="<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
/html5shiv.min.js"></script>
      <script src="<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
/respond.min.js"></script>
    <![endif]-->
  </head>
<style>
    .form-signin{
        
        padding-bottom:80px;
    }
</style>
  <body>

    <div class="container">
              
      <form class="form-signin" action="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" method="post">
        <h2 class="form-signin-heading text-center">LOGIN</h2>
        <p class="text-info text-center"><small><em><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</em></small></p>  
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="pwd">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="submit">Sign in</button>
      </form>
          

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
/ie10-bug.js"></script>
  </body>
</html>
<?php }} ?>
