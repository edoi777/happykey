/* ОПЕНКАСЕС */
$( document ).ready(function() {
	
	var socketIO = io(':2052'||':8304',{'max reconnection attempts':Infinity});	
	socketIO.on('online', function (data) {
        //console.log(data);
		$("#online").html(data);
    });
	socketIO.on('stats', function (data) {
        var info = JSON.parse(data);
		$("#games_count").text(info.games);
		$("#two_chance").text(info.two_chance);
		$("#users_count").text(info.accounts);
		$("#users_opens").text(info.players);
    });
	socketIO.on('last_winners', function (data) {
		$("#last_winners").html(data);
    });
	
    /////////////	 

	var audio = new Audio(); // Создаём новый элемент Audio
    audio.src = '/sounds/roll.wav'; // Указываем путь к звуку	
	
	$('#spin_it').click(function() {
		get_your_win();
    });
	
	function get_your_win() {
		$.get("/system/api.php?get_your_win", function(data){
			if (data.length == 32) {
				data = data.replace(/^\s*(.*)\s*$/, '$1');//костыль (на всякий случай)
				console.log(data);
				$("#click-clack-bang").text("Прогим у Гейба игр...");
				$("#shuffle_roll").load("/system/api.php?get_roll="+data);//подгрузка картинок в рулетку
				setTimeout(function() {
					roll(data);//запускаем рулетку
				}, 1000);				
			} else {
				swal({
                    title: 'Ошибка',
                    text: data,
			        type: 'error'
                })
			}			
        });
	}
	
	function getRandomInRange(min, max) {
	    var random = Math.floor(Math.random() * (max - min + 1)) + min;
        return random;
    }
	
	function roll(data){
		var win_game = $("#win_game").offset();
		console.log(win_game);
		audio.play(); //воспроизведение звука		
		$("#click-clack-bang").text("Открытие...");
		var pos = ["3060", "3080", "3152", "3200","3244"];//массив из позиций
		$("#shuffle_roll").css("left", "-"+pos[getRandomInRange(0, 4)]+"px");//сам ролл
		winning(data);	
	}
	
	function winning(data){
		$.get("/system/api.php?get_win="+data, function(data){
			if (data != ""){
				var info = JSON.parse(data);
				$("#key").text(info.key);
				$("#game_name").text(info.name);		
				$("#winning_image").html("<div style='background:url("+info.img+") no-repeat center center;background-size:cover;' class='winning_image'></div>");
				setTimeout(show_win, 9000);
			} else {
				alert('Системная ошибка при получении информации о выигранной игре. Зайдите в личный кабинет, там будет ваш выигрыш.');
			}
		});		
	}
	
	function show_win(){
		console.log('Открыть окошко победы');
		$("#game-end").show();
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
			$.get("/system/api.php?set_kupon="+result, function(data){
			    var kostil = data.replace(/^\s*(.*)\s*$/, '$1');
				kostil = JSON.parse(kostil);
				if (kostil.result == 'success'){
					swal({
                        title: 'Успешно',
                        text: kostil.return,
			            type: 'success'
                    }).then(function() {
				        location.reload();
			        })
				} else {
					swal({
                        title: 'Ошибка',
                        text: kostil.return,
			            type: 'error'
                    })
				}			    			
            });            
        })
    });
});