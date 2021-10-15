<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    require 'dbh.php';
    $sql = "SELECT MAX(id) as max_id FROM chat WHERE message_show=true and room='". strtolower( $_POST['room']) ."';";
    $result = $conn->query($sql);
    $max = $result->fetch_assoc();


    if (isset($_POST['max_id']) && $max['max_id'] == $_POST['max_id']){
        echo "";
        return;
    }

    $sql = "SELECT * FROM chat WHERE message_show=true and room='". strtolower( $_POST['room']) ."';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    $previous_message_datetime = 0;
    $previous_sender = "";
    while($row = $result->fetch_assoc()) {

        $phpdate = strtotime( $row['date_created'] );

        if ($phpdate < strtotime("first day of this year"))
            $date = date('H:i d.m.Y ', $phpdate);
        else if ($phpdate < strtotime("today"))
            $date = date('H:i d.m.', $phpdate);
        else
            $date = date('H:i', $phpdate);

        $timestamp = "";
        if (($phpdate - $previous_message_datetime) > 300) {
            $timestamp = '
                <div class="message_body">
                    <div class="msgCentral">
                        <div class="time_stamp_central">'.$date.' </div>
                    </div>
                </div>';
        }
        $sender = "";
        if ($row['username'] != $previous_sender || $timestamp != "" || $previous_sender == "") {
            $sender = '
                <div class="sender">
                    '. $row['username'] . '
                </div>';
        }
        $previous_message_datetime = $phpdate;
        if ($row['message_type'] == 1)
            $previous_sender = $row['username'];


        if ($row['message_type'] == 1) {
            if ($row['username'] == $_SESSION['name'])
                echo '
                    '. $timestamp .'
                    <div class="message_body">
                        <div class="messageGlobal msgMy has-tooltip-left has-tooltip-arrow has-tooltip-hidden-touch" data-tooltip="' . $date . '">
                            '. $row['message_text'].' 
                        </div>
                    </div>';    
            else
                echo '
                    '. $timestamp .'
                    <div class="message_body">
                        '. $sender .'
                        <div class="messageGlobal msgTheirs has-tooltip-right has-tooltip-arrow has-tooltip-hidden-touch" data-tooltip="' . $date . '">
                            '. $row['message_text'] .'
                        </div>
                        
                    </div>';
        }
        else {
            echo '
                '. $timestamp .'
                <div class="message_body">
                    <div class="messageGlobal msgCentral">
                        <i>'. $row['message_text'] .' </i>
                    </div>
                </div>';
        }
    }
    } else {
    echo "";
    }


    echo '<div class="is-hidden" id="lastId">' . $max['max_id'] . '</div>'
?>