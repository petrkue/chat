<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'dbh.php';

if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $room = $_POST['room'];
    $error = "";
    $redirect = "";
    if($text == '/clear') {
        $sql = "UPDATE chat SET message_show=false WHERE room='$room';";

        if ($conn->query($sql) !== TRUE) {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show, room)
            VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', '". $_SESSION['name'] ." vyčistil/a chat!', 2, true, '$room')";

        if ($conn->query($sql) !== TRUE) {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else if(explode(' ', $text)[0] == '/join') {

        $new_room = explode(' ', $text)[1];
        
        $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show, room)
                VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', '". $_SESSION['name'] ." se přesunul/a do místosti $new_room! Pro přepojení použij /join $new_room', 2, true, '$room')";

        if ($conn->query($sql) !== TRUE) {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show, room)
                VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', '". $_SESSION['name'] ." se připojil/a z místosti $room. Pro přepojení použij /join $room', 2, true, '$new_room')";

        if ($conn->query($sql) !== TRUE) {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $redirect = base_url()."/chat/?room=$new_room";
    }
    else if($text == '/rooms') {
        
        $sql = "SELECT DISTINCT room FROM chat;";
        $result = $conn->query($sql);

        if ($result->num_rows <= 0) 
            $error = "Error: No rooms available!";
        else {
            $rooms = $result->fetch_all();
            $number_of_rooms = count($rooms);
            $rooms_str = "";
            print_r($rooms);
            echo $number_of_rooms;
            for ($i = 0 ; $i < $number_of_rooms ; $i++) {
                $rooms_str .= $rooms[$i][0];
                if ($i + 2 == $number_of_rooms) {
                    $rooms_str .=" a ";
                }
                else if ($i + 1 != $number_of_rooms) {
                    $rooms_str .=", ";
                }
            }
            
            $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show, room)
                VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', 'Používané místosti jsou: $rooms_str.', 2, true, '$room')";

            if ($conn->query($sql) !== TRUE) {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else {
        $sql = "INSERT INTO chat (username, date_created, message_text, message_type, message_show, room)
                VALUES ('".$_SESSION['name']."', '".date("Y-m-d H:i:s")."', '".strip_tags(nl2br(htmlspecialchars($text)), '<br>')."', 1, true, '$room')";

        if ($conn->query($sql) !== TRUE) {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo json_encode(['error'=>$error, 'redirect'=>$redirect]);

    
}



function base_url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
  }

?>