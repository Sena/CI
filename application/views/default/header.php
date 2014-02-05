<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <base href="<?php echo base_url(); ?>">
    <meta name="controller" content="<?php echo $this->router->class ?>" />
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css" media="screen">
    <script src="./assets/js/jquery-1.10.2.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <?php echo isset($header) ? $header : NULL; ?>
    <?php echo isset($css) ? $css : NULL; ?>
    <?php echo isset($js) ? $js : NULL; ?>
    <script src="./assets/js/script.js"></script>
</head>
<body>
    <div id="main">
        <div id="header">
            <ul class="mainMenu">
                <li>
                    <a href="./">
                        HOME
                    </a>
                </li>
            </ul>
        </div>
        <div id="content">