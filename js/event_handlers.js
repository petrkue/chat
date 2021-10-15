//If user has clicked on icon, notification will be played
$("#audio").click(function() {
    $('#audio').removeClass('fa-volume-mute');
    $('#audio').addClass('fa-volume-up');
    var audio = new Audio('media/notification.mp3');
    audio.play();
});

//If user submits the form
$("#submitmsg").click(function(){	
    var room = findGetParameter('room');
    var clientmsg = $("#usermsg").val();
    if (clientmsg == '')
        return false;
    $("#usermsg").val('');
    $('.emoji-wysiwyg-editor').html('');
    $.post("php/post.php", {'text': clientmsg, 'room': room || 'general'})
        .done(function( data ) {
            var response = JSON.parse(data);
            if (response['redirect'] != '')
                window.location = response['redirect'];
            loadChat();
        }
    );		
    $("#usermsg").attr("value", "");
    return false;
});

//hide notification from title on tab select
$(window).focus(function(){
    document.title = "Povídání";
});

//submit form with Enter (not with Shift + Enter)
$('.emoji-picker-container').keypress(function (e) {
    scrollHeight = $('.emoji-picker-containter')
    if(e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        $('.emoji-wysiwyg-editor').blur();
        $("#submitmsg").click();
        $('.emoji-wysiwyg-editor').focus();
        return false;
    }
});

//If user wants to end session
$("#exit").click(function(){
    var exit = confirm("Opravdu se chcete odhlásit?");
    if(exit==true){window.location = 'index.php?logout=true';}		
});