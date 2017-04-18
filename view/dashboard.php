<!doctype html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- meta http-equiv="default-style" content="blog-android-app" -->
        <meta name="generator" content="HTML-Kit 292">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="rating" content="general">
        <meta name="copyright" content="© 2013 - 2017 Thiengo Calopsita">
        <meta name="DC.publisher" content="Vinícius Thiengo">
        <meta name="author" content="Vinícius Thiengo">
        <meta name="Custodian" content="Thiengo Calopsita">
        <meta name="robots" content="all">
        <meta name="keywords" content="android, blog">
        <meta name="description" content="Dashboard do Blog Android App.">

        <title>
            Blog Android App
        </title>

        <link type="text/css" rel="stylesheet" href="./view/css/blog-android-app.css" />
        <link type="text/css" rel="stylesheet" href="./view/css/mSnackbar.min.css" />
    </head>


    <body>

        <div id="header">
            Blog Android App
        </div>


        <div id="container">
            <?php
                echo $menu;
            ?>

            <div class="content">
                <?php
                    echo $html;
                ?>
            </div>
            <div class="cl"></div>
        </div>


        <script type="text/javascript" src="./view/js/jquery.3.2.1.min.js"></script>
        <script type="text/javascript" src="./view/js/mSnackbar.min.js"></script>
        <script type="text/javascript" src="./view/js/blog-android-app.js"></script>
    </body>
</html>