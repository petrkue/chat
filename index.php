<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
require 'php/dbh.php';

if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $name = stripslashes(htmlspecialchars($_POST['name']));
        if (!isset($_SESSION['name'])) {
            $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show)
            VALUES ('".$name."', '".date("Y-m-d H:i:s")."', '". $name ." se připojil/a!', 3, true)";

            if ($conn->query($sql) !== TRUE) {
                return "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $_SESSION['name'] = $name;
        header('Location: ?room=' . $_POST['room']);
        
    }
    else{
        echo('<span class="error">Zadejte prosím jméno</span>');
    }
}

if(isset($_GET['logout'])){ 
     
    //Simple exit message
    $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show)
            VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', '". $_SESSION['name'] ." se odpojil/a.', 2, true)";

    if ($conn->query($sql) !== TRUE) {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}

?>

<?php

require 'php/login_form.php';

if(!isset($_SESSION['name'])){
    loginForm();
}
else{
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Povídání</title>
        <meta name="viewport" content=""/>
        <link rel="icon" type="image/png" href="/media/favicon.ico"/>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/style_mobile.css" />
        <link type="text/css" rel="stylesheet" href="css/bulma-tooltip.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <script src="https://kit.fontawesome.com/36a9223ef4.js" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="plugins/emoji-picker/lib/css/emoji.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/document_ready.js"></script>
        
        <script type="text/javascript" src="js/load_chat.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Vítej, <b><?php echo $_SESSION['name']; ?></b> <i id="audio" class="fas fa-volume-mute"></i></p>
                
                <p class="logout button is-danger"><a id="exit" href="#">Opustit chat</a></p>
                <div style="clear:both"></div>
            </div>    
            <div id="chatbox">
                <div class="fa-3x has-text-centered">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
            </div>
            
            <form name="message" action="">
            <div class="lead emoji-picker-container">
                <textarea class="input is-info resize-ta" name="usermsg" type="text" id="usermsg" autofocus data-emojiable="true" data-emoji-input="unicode"></textarea>
            </div>
            <input class="button is-info" name="submitmsg" type="submit"  id="submitmsg" value="Odeslat" />                
            </form>
        </div>
        <script src="plugins/emoji-picker/lib/js/config.js"></script>
        <script src="plugins/emoji-picker/lib/js/util.js"></script>
        <script src="plugins/emoji-picker/lib/js/jquery.emojiarea.js"></script>
        <script src="plugins/emoji-picker/lib/js/emoji-picker.js"></script>
    </body>
    <script type="text/javascript" src="js/event_handlers.js"></script>
</html>
<?php
}

?>