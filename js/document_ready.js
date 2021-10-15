$(document).ready(function(){
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Opravdu se chcete odhlásit?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});

    heightToScroll = $("#chatbox").prop("scrollHeight");
    $("#chatbox").animate({ scrollTop: heightToScroll }, 100);

	
});

$( 'textarea' ).ready(function() {
	window.emojiPicker = new EmojiPicker({
		emojiable_selector: '[data-emojiable=true]',
		assetsPath: 'plugins/emoji-picker/lib/img',
		popupButtonClasses: 'fa fa-smile-o'
		});
		window.emojiPicker.discover();
		
  });

  