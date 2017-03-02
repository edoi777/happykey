/* ОПЕНКАСЕС */
$( document ).ready(function() {
	
	var socketIO = io(':2052',{'max reconnection attempts':Infinity});	
	socketIO.on('online', function (data) {
        //console.log(data);
		$("#online").html(data.online );
    });
	socketIO.on('stats', function (data) {
        var info = JSON.parse(data);
		$("#games_count").text(info.games);
		$("#two_chance").text(info.two_chance);
		$("#users_count").text(info.accounts);
		$("#users_opens").text(info.players);
    });
	socketIO.on('loadLastWin', function (data) {
				$.ajax({
	            url: '/ajax/index.php?getwinners',	        
				type: 'GET',
	            success: function(data) {
                      $("#last_winners").html(data);
	            }
	    })
		$("#last_winners").html(data);
    });
	var loc = window.location.search;
    if (loc.indexOf('?yes') != -1) {
         swal('Успешно', 'Деньги начислены на ваш счёт!', 'success');
    }
    if (loc.indexOf('?no') != -1) {
        swal('Неудача', 'При пополнение счёта произошла ошибка!', 'error');
    }
    /////////////	 

	var audio = new Audio(); // Создаём новый элемент Audio
    audio.src = '/template/audio/roll.wav'; // Указываем путь к звуку	
	
	$('#spin_it').click(function() {
		get_your_win();
    });
	$('#codeactiv').click(function() {
        var codes = $('#code').val();
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'activecode',
                codes: codes,
            },
            type: "POST",
            success: function(data) {
                  swal('Успешно', data, 'success');
            }
        });

    });
	function get_your_win() {
		$.ajax({
	            url: '/ajax/index.php',	        
	            dataType: 'json',
	            data: {
	                action: 'start'
	            },
				type: 'POST',
	            success: function(data) {
	                if (data && data['status'] == 'success') {
						console.log(data);
	                    $("#click-clack-bang").text("Впускаем газ...");		
                        $('.obj16').html('<div class="game obj16"><img src="'+data.img+'"></div>');				
				        setTimeout(function() {
				           	roll(data);//запускаем рулетку
				        }, 1000);	
	                } else if (data && data['status'] == 'no_money'){
	                    swal('Ошибка', 'Пополните свой счёт на '+ data['money']+' руб.', 'error');
	                } else if (data && data['status'] == 'not_auth'){
	                    swal('Ошибка', 'Чтобы участвовать - авторизируйтесь! ', 'error');
	                }
	            },
	            error: function(data) {
					console.log(data);
	                swal('Ошибка', 'Произошла ошибка! Обратитесь к администратору!', 'error');
	            }
	    })

	}
	
	function getRandomInRange(min, max) {
	    var random = Math.floor(Math.random() * (max - min + 1)) + min;
        return random;
    }
	
	function roll(data){
		audio.play(); //воспроизведение звука		
		$("#click-clack-bang").text("Молим гейба о игре...");
		var pos = ["3060", "3080", "3152", "3200","3244"];//массив из позиций
		$("#shuffle_roll").css("left", "-"+pos[getRandomInRange(1, 4)]+"px");//сам ролл
		winning(data);	
	}
	
	function winning(data){
				var info = data;
				$("#key").text(info.key);
				$("#game_name").text(info.name);		
				$("#winning_image").html("<div style='background:url("+info.img+") no-repeat center center;background-size:cover;' class='winning_image'></div>");
				setTimeout(show_win, 9000);
			
	}
	
	function show_win(){
		$("#game-end").show();
		socketIO.emit('lastWin', '');
		$("#click-clack-bang").text("Рискнуть ещё раз за 69 рублей");
	}
	
	/////////////
	
	$('#kupon').click(function() {
	    swal({
	        title: 'Введите купон',
	        input: 'text',
	        showCancelButton: true,
	        cancelButtonText: 'Отмена',
	        inputValidator: function(value) {
	            return new Promise(function(resolve, reject) {
	                if (value) {
	                    resolve();
	                } else {
	                    reject('Введите что нибудь!');
	                }
	            });
	        }
	    }).then(function(result) {
	        $.ajax({
	            url: '/ajax/index.php',
	            type: 'POST',
	            dataType: 'json',
	            data: {
	                action: 'actpromo',
	                promo: result
	            },
	            success: function(data) {
	                if (data && data['status'] == true) {
	                    swal('Успешно', data['msg'], 'success');
	                } else {
	                    swal('Ошибка', data['msg'], 'error');
	                }
	            },
	            error: function() {
	                swal('Ошибка', 'Произошла ошибка! Обратитесь к администратору!', 'error');
	            }
	        })
	        return true;
	    })
	});
});