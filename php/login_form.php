<?php
    function loginForm(){ 
        if (isset($_GET['room']))
            $room = $_GET['room'];
        else
            $room = 'general';
        echo '
            <html>
                <head>
                    <link rel="icon" type="image/png" href="/media/favicon.ico"/>
                    <title>Přihlášení</title>
                    <meta name="viewport" content=""/>
                    <link type="text/css" rel="stylesheet" href="css/style.css" />
                    <link type="text/css" rel="stylesheet" href="css/style_mobile.css" />
                    <link type="text/css" rel="stylesheet" href="css/bulma-tooltip.css" />
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
                </head>
                <body>
                    <div id="loginform">
                        <h1>Vítejte!</h1>
                        <form action="index.php" method="post">
                            <p>Zadejte, jak vás mají vidět ostatní:</p>
                            <div class="field">
                                <div class="control">
                                    <input class="input is-info" type="text" placeholder="" name="name">
                                </div>
                            </div>
                            <input type="hidden" name="room" value="'. $room .'">
                            <input class="button is-info" type="submit" name="enter" id="enter" value="Vstoupit" />
                        </form>
                    </div>
                </body>
            </html>';
    }
?>