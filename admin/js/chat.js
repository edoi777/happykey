$(function() {
	$('.chat-header').click(function (e) {
  		e.preventDefault();
  		if (this.className.indexOf('chat-up') !== -1) {
    		$('.chat-window').css('height', '25px');
    		$('.chat-header').removeClass('chat-up');
    		$('.chat-header').addClass('chat-down');
  		} else if (this.className.indexOf('chat-down') !== -1) {
    		$('.chat-window').css('height', '460px');
    		$('.chat-header').addClass('chat-up');
    		$('.chat-header').removeClass('chat-down');
  		}
	});
	
	var messageList = $('#chat-messages');
	var messageListAdd = $('.chat-messages');
	var messageField = $('.chat-input');
	var lastMsg = '';
	var lastMsgTime = '';
	var chat = new Firebase("https://fastgun.firebaseio.com/chat/1");

	function sendMessage() {
      	var message = messageField.val();
	    var maxlength = 200;
	    if (message.length > maxlength) {
	    	alert('Максимальное количество символов 200');
	        return;
	    }
		message = message.trim();
	    if (!message) {
	    	alert('Вы ничего не ввели');
	        return;
	    }
		if (lastMsgTime && new Date - lastMsgTime < 1000 * 5) {
			alert('1 сообщение в 5 секунд');
	        return;
	    }
	    lastMsgTime = new Date;
	    lastMsg = message;
      	$.ajax({
		  url: '/chatadd',
		  type: "POST",
		  data: { 
		  	'message': message,
		  	'token': $('#chat-token').val()
		  },
		  success: function(data) {
		  		if(data == 'deposit')
					alert('Вы должны сделать минимум 2 депозита на сайте');
		   		messageField.val('');
		   }
		});
	}
	$('#chat_messages').on('click', '.removeMSG',function() {
       	self = this;
		$.ajax({
		  url: '/ajax/chat',
		  type: "POST",
		  data: { 
		  	'type': 'remove',
		  	'id': $(self).attr('data-ids')
		  },
		  success: function(data) {
		   
		  	if(!data.success) {
		  		$.notify(data.text);
		  		return;
		  	} 
		  }
		});
        return false;
    });
	messageField.keypress(function (e) {
	    if (e.keyCode == 13) {
	    	sendMessage();
	    	return false;
	    }
	});
	$('.chat-send').submit(function() {
		sendMessage();
		return false;
	});
	var msgs = chat.limitToLast(50);
	msgs.on('child_removed', function (snapshot) {
	    var data = snapshot.val();

	    $('.chatMessage[data-uuid='+snapshot.key()+']').remove();
	    //messageList.mCustomScrollbar();
	});
	msgs.on('child_added', function (snapshot) {
	    var data = snapshot.val();
	    data.uuid = snapshot.key();
	    var username = data.username || "Error";
	    var message = data.message;
	    var avatar = data.avatar;
	    var steamid = data.steamid;
	    if(data.is_admin == "1") {
	    	username = 'Администратор';
	    	avatar = '/img/admin.png';
	    }
	    var avatarElement = $('<div class="chat-avatar-wrap"> <a href="#"><img src="'+avatar+'" class="chat-avatar circle-avatar-chat"></a></div>');
	    var nameElement = $('<div class="chat-message-wrap"><div class="chat-message-nick undefined">'+username+'</div></div> ');
	    var msgElement = $('<div class="chat-message-text undefined">'+message+'</div>');
	    var bodyElement = $('<li data-uuid="'+data.uuid+'" class="chat-message"></li>');

	    bodyElement.prepend(msgElement).prepend(nameElement).prepend(avatarElement);

	   	if(data.is_moderator == "1") {
	    	nameElement.attr('style', 'color:green;');
	    }
	    if(data.is_admin == "1") {
	    	nameElement.attr('style', 'color:red;');
	    }
	    //bodyElement.prepend(msgBodyElement).prepend(avatarElement);
	    messageList.append(bodyElement);
  	});
});