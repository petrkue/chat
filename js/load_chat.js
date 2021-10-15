setInterval (loadChat, 1000);



//Load the file containing the chat log
function loadChat(){		
    var room = findGetParameter('room');

    var dict = {
        "max_id" : $('#lastId').html(),
        "room" : room || 'general'
    };

    $.ajax({
        type: "POST",
        url: "./php/read_chat.php",
        data: dict,
        success: function(html){		
            if (html != ''){
                $("#chatbox").html(html); //Insert chat log into the #chatbox div
                $last_message = $('.messageGlobal:last')
                if ($last_message.hasClass('msgTheirs')) {
                    if(document.hidden)
                        document.title = "(1) Povídání";
                    $('#audio').click();
                }

                //Auto-scroll			
                var newscrollHeight = $("#chatbox").prop("scrollHeight"); //Scroll height after the request
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'slow'); //Autoscroll to bottom of div
            }
            
                            
        },
    });
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}