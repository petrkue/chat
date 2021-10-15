$(document).ready(function(){
	

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
		$('.emoji-wysiwyg-editor').focus();
  });

  
  