<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

	<title><?php echo $pageTitle; ?></title>
    <base href="<?php echo base_url(); ?>">
    <meta name="controller" content="<?php echo $this->router->class ?>" />
	<link rel="stylesheet" type="text/css" href="./assets/adm/css/style.css">
    <script src="./assets/js/jquery-2.0.3.min.js"></script>
    <script src="./assets/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="./assets/jquery-ui/js/jquery.ui.datepicker.regional.pt.js"></script>
    <link rel="stylesheet" href="./assets/jquery-ui/css/smoothness/jquery-ui.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="./assets/jquery-ui/css/smoothness/jquery.ui.theme.css" type="text/css" media="screen">
	<script src="./assets/adm/js/script.js" type="text/javascript" charset="utf-8"></script>
    <?php echo isset($header) ? $header : NULL; ?>
    <?php echo isset($css) ? $css : NULL; ?>
    <?php echo isset($js) ? $js : NULL; ?>
    
</head>
<body>
    <div id="main">
        <div id="header">
            <?php if(isset($logado->id)):?>
            <ul id="mainMenu">
                <li>
                    <a href="./<?php echo $this->uri->segment(1);?>">Inicio</a>
                </li>
                <li>
                    <a href="./<?php echo $this->uri->segment(1);?>/galeria">Galeria</a>
                </li>
                <li>
                    <a href="./<?php echo $this->uri->segment(1);?>/depoimentos">Depoimentos</a>
                </li>
                <li>
                    <a href="./<?php echo $this->uri->segment(1);?>/login">Sair</a>
                </li>
            </ul>
            <?php endIf;?>
        </div>
        <div id="content">
            <div class="msg"><?php echo $msg; ?></div>
            <div class="error"><?php echo $error; ?></div>
