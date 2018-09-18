<!doctype html>
<html dir="rtl">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title><?=(isset($this->title)) ? $this->title : 'إدارة المهام -- مؤسسة رؤية'; ?></title>
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css" />
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/w3.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/sunny/jquery-ui.css" />-->
    <script type="text/javascript" src="<?php echo URL; ?>public//js/jquery-3-3-1.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui-1-12-1.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>
    <?php 
    if (isset($this->js)) 
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }
    ?>
</head>
<body>

<?php Session::init(); ?>
    
<div id="header">

    <?php if (Session::get(LOGGEDINFLAG) == false):?>
        <a href="<?php echo URL; ?>index">الرئيسية</a>
    <?php endif; ?>    
    <?php if (Session::get(LOGGEDINFLAG) == true):?>
        <?php if (Session::get('role') == 'owner'):?>
        <a href="<?php echo URL; ?>user">Users</a>
        <?php endif; ?>
        
        <label style="font-size:20px; color:yellow">
            <?php echo $_SESSION['CurrentEmp']->getFullName(); ?>
        </Label>
        <a href="<?php echo URL; ?>dashboard/logout">اخرج</a>    
    <?php else: ?>
        <a href="<?php echo URL; ?>login">دخول</a>
    <?php endif; ?>
</div>
    
<div id="content">
    
    