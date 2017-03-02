<script type="text/javascript" src="/template/js/jquery.tooltipster.min.js"></script>
	
		<script>
		
		    var currentCase = "{case}";
		    var game_id;
			var cardSelected = false;
			var cardsArray;
			var garant_card;
			var off_card;
			var scratchcards;

			var win = '/images/empty.png';
			var lose = '/images/empty.png';
			var foreground = '/images/case.png';
			var boreground = '/images/gar.png';
			
	function loadscratc(id) {
		$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'loadscratc',
				game_id: game_id,
				data: id
			},
			success: function(data) {
			memasik();
			if (data.status == 'success') {

			}
			else if (data.status == 'shans') {
			    createScratchCard({
			        'container': $('#case-10')[0],
			        'background': win,
			        'foreground': foreground,
			        'percent': 55,
			        'coin': '/images/coin.png',
			        'thickness': 12,
			        'counter': 'counting',
			        'callback': 'callback'
			    });

			    $('.scratchcase').addClass('disables');
			    $('.card-extra').addClass('shake animated');
			    $('.card-extra').css("opacity", "1");
			    $('.scratchcase').css("cursor", "default");
			    $('#case-10').removeClass('disables');
			    var weapon = data.weapon
			    $('#possible_item').text(weapon.fullname+' | '+weapon.spacename);
			    $('.card-extraerase').show();
				$('.extraPrice').text('Всего за '+data.shans+" руб.");
			    $('.card-extraarrow-left').show();
			    $('.card-extraarrow-right').show();
			    setTimeout(function() {
			        for (var i = 0, l = cardsArray.length; i < l; i++) {
			            cardsArray[i].lock(true);
			            cardsArray[i].className = 'scratchcase disables';
			            $('.scratchcard-Cursor').css("display", "none");
			        }

			        $('.scratchcase').css("cursor", "default");
			    }, 601)

			} else if (data.status == 'win') {
			    var currentCase = data.currentCase
			    var upchancePrice = data.game
			    var id_item = data.item_id

			    $('#case-10').addClass('disables');
				$.each(data.case, function (blockid, index) {				
				       var itemblock =  $('<div class="item-scratch ' + index.type + '">' +
			                 '<div class="picture"><img src="' + index.image + '"></div>' +
			                '<div class="descr"><strong>'+index.fullname+'</strong><span>'+index.spacename+'</span></div>'+	
			                 '</div>');
							 $(itemblock).fadeIn(300);
						$('#'+blockid).html(itemblock);
						
	            });


			    setTimeout(function() {
			        $('.winner-popup').show();
			        $('.wp-item img').attr('src', data.weapon.image)
			        $('.wp-head2 span').text(data.weapon.fullname+' | '+data.weapon.spacename)
					$('.btn-sell-item').html('<span onclick="sell('+data.iteamid+');">Продать за <span>'+data.weapon.price+'</span> РУБ.</span>');
			    }, 500)
			    $('.scratchcase').addClass('disables');
			}else if (data.status == 'garant') {
				$('.scratchcase').addClass('disables');
				$('#case-10').removeClass('disables');
					$('.card-extra').addClass('shake animated');
					$('.card-extra').css("opacity", "1");
					var weapon = data.weapon
						setTimeout(function() {
					for(var i = 0, l = cardsArray.length; i < l; i++) {
					cardsArray[i].lock(true);
					cardsArray[i].className = 'scratchcase disables';
					}
					$('.scratchcase').css("cursor", "default");
					}, 601)
					$('.card-extraarrow-right').show();

				} 

			}
		})
	}	
    function memasik(){
		var random = Math.floor(Math.random() * (14 - 0)) + 1;
        $('.card-funny-'+random).addClass('active');
			setTimeout(function() {
                $(".card-funny-" + random).removeClass("active");
            }, 1500);
	}
	function loadscratc_one(id) {
	    $.ajax({
	        url: '/ajax/index.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            action: 'loadscratc_one',
	            game_id: game_id,
	            data: id
	        },
	        success: function(data) {
	            if (data.status == 'success') {
					if(data.case_id=='case-10'){
						$('.btn-sell-item').html('<span onclick="sell('+data.iteamid+');">Продать за <span>'+data.weapon.price+'</span> РУБ.</span>');
					}
	                var caseid = $('#' + data.case_id);
	                var weapon = data.weapon
	                $('.playcard canvas').css('width', '100%').css('height', '100%').css('position', 'relative');
	                $('.descr').show();

	                var el = '<div class="item-scratch ' + weapon.type + '">' +
	                    '<div class="picture"><img src="' + weapon.image + '"></div>' +
	                    '<div class="descr"><strong>' + weapon.fullname + '</strong><span>' + weapon.spacename + '</span></div>' +
	                    '</div>';
	                caseid.prepend(el);


	            }
	        }
	    })
	}
			
		
	function loadgarant(id) {
		$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'garant',
				game_id: game_id,
				data: id
			},
			success: function(data) {
			console.log('end');
				if (data.status == 'success') {

				    $('.card-extraerase').hide();
				    var classname = ('#case-10 .scratchcard-Overlay');
				    var classname_two = ('#case-10 .scratchcard-Cursor');
				    $(classname).remove();
				    $(classname_two).remove();
				    $('#case-10').addClass('disables');
				    $.each(data.case, function(blockid, index) {
				        var itemblock = $('<div class="item-scratch ' + index.type + '">' +
				            '<div class="picture"><img src="' + index.image + '"></div>' +
				            '<div class="descr"><strong>' + index.fullname + '</strong><span>' + index.spacename + '</span></div>' +
				            '</div>');
				        $(itemblock).fadeIn(300);
				        $('#' + blockid).html(itemblock);

				    });
					socketf.emit('lastWin', { 
						'weaponname': data.socket.name,
						'userid': data.socket.userid,
						'type': data.socket.type,
						'img': data.socket.img,
						'caseimg': data.socket.case,
						'user': data.socket.user
					});
				    $('.winner-popup').fadeIn(300);
					
				    $('.wp-item img').attr('src', data.weapon.image)
				    $('.wp-head2 span').text(data.weapon.fullname + ' | ' + data.weapon.spacename)


				} else if (data.status == 'error') {
				
				
			}
			}
		})
	}	
		
		
		
			function callback(covered, element, container) {	
					for(var i = 0, l = cardsArray.length; i < l; i++) {
					cardsArray[i].lock(false);
					cardsArray[i].className = 'scratchcase disables';
					}
									for(var i = 0, l = cardsArray.length; i < l; i++) {
					if((cardsArray[i].id == covered.container.id)) {
						
					var case_id = $(cardsArray[i]).attr( "id");	
					var id = $(cardsArray[i]).attr( "id");	
					var classname = ('#' + case_id + ' .scratchcard-Overlay');	
					var classname_two = ('#' + case_id + ' .scratchcard-Cursor');	
					var classname_tff = ('#' + case_id);	
					$(classname).remove();
					$(classname_two).remove();
		

					for(var i = 0, l = cardsArray.length; i < l; i++) {
					cardsArray[i].lock(false);
					cardsArray[i].className = 'scratchcase';
					}
					cardSelected = false;
					$(classname_tff).addClass('tada animated');
					} 
				
				}
					
					if(covered .container.id == 'case-10') {
					loadgarant(covered.container.id);
					} else {
					loadscratc(covered.container.id);
					}

						
			}
			
			function counting(covered, element, container) {
				if(!cardSelected && covered > 0) {
				
					for(var i = 0, l = cardsArray.length; i < l; i++) {
						if(!(cardsArray[i].id == element.container.id)) {
							cardsArray[i].lock(true);
							cardsArray[i].className = 'disables scratchcase';
							$('scratchcard-Cursor').css("display", "none");							
						}
					}
					loadscratc_one(element.container.id);
					
					
					cardSelected = true;
				}
	
			}




		
		</script>

<script type="text/javascript">
$(document).ready ( function(){	







function getName(name) {
	var arr = name.split('|');
	return (arr.length == 1) ? name : arr[1];
}
Array.prototype.shuffle = function() {
	var o = this;
	for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
}
Array.prototype.mul = function(k) {
	var res = []
	for (var i = 0; i < k; ++i) res = res.concat(this.slice(0))
	return res
}
Math.rand = function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var el = "";
    var cases = [];
    $.ajax({
        type: "GET",
        url: "/ajax/index.php",
		data: {
				action: "casein",
                caseid: currentCase,
        },
        dataType: 'json',
        success: function(data) {
			var itemsBlock = '';
			var i =0;
			$.each(data, function (itemWithPrice, index) {
				itemsBlock += '<a href="https://csgo.tm/?search='+getName(index['name0'])+' | '+getName(index['name1'])+'" class="item-incase '+index['quality']+'" target="_blank" style="text-decoration: none;">'
	+'<div class="picture">'
		+'<img src="//steamcommunity-a.akamaihd.net/economy/image/'+index['img']+'" alt="Дроп">'
		+'<div class="descr">'
			+'<strong>'+getName(index['name0'])+'</strong>'
			+'<span>'+getName(index['name1'])+'</span>'
		+'</div>'
	+'</div></a>';

						   cases[i]=[index['name0'], index['name1'], index['quality'],index['img']];
                           i++; 
	        });
			fillCarusel();
			$('.opencase-drops').html(itemsBlock);
        }
    });
				

function fillCarusel() {
	   

		var a1 = cases.filter(function(weapon) { return weapon[2] == 'milspec' }).slice(0).mul(5).shuffle()
		var a2 = cases.filter(function(weapon) { return weapon[2] == 'restricted' }).slice(0).mul(5).shuffle()
		var a3 = cases.filter(function(weapon) { return weapon[2] == 'classified' }).slice(0).mul(4).shuffle()
		var a4 = cases.filter(function(weapon) { return weapon[2] == 'covert' }).slice(0).mul(4).shuffle()
		var a5 = cases.filter(function(weapon) { return weapon[2] == 'rare' }).slice(0).mul(2).shuffle()
		
		var arr = a1.concat(a2, a3, a4, a5).shuffle().shuffle().shuffle();
		var el1 = ''
		arr.forEach(function(items, index) {
			var i=Math.floor(Math.random()*2);
			if(i == 1){
				window.b = '';
			}else{
				window.b = '';
			}
		
			el1 += '<div class="weaponblock weaponblock2 '+items[2]+'">'+
						'<img src="https://steamcommunity-a.akamaihd.net/economy/image/'+items[3]+'"/>'+
						'<div class="weaponblockinfo"></div>'+
						'<div class="name"><span>'+ b + getName(items[0])+'<br/>'+getName(items[1])+'</span></div>'+
					'</div>'
			
		})
		$('#casesCarusel').css("margin-left", "0px");
		$('#casesCarusel').html(el1);
		
}
	$('#extraerase').click(function() {		
		var that = $(this);
		var prevHtml = that.html();
		that.text('Пиздим Габена...')
		var userPanelError = $('.userPanelError')
		userPanelError.text('')
		
		$.ajax({
			url: '/ajax/index.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'shans',
				game_id: game_id
			},
			success: function(data) {
				if (data.status == 'on_shans') {
					that.html(prevHtml);
					$('.card-extraerase').hide();
					$('.card-extraarrow-left').hide();
					$('.card-extraarrow-right').hide();
					$('#case-10').innerHTML = '';
					for(var i = 0, l = cardsArray.length; i < l; i++) {
					cardsArray[i].lock(false);
					cardsArray[i].className = 'scratchcase';
					}
					$('#case-10').removeClass('shake animated');
					$('.card-extra').css("opacity", "0.6");
					$('#case-10').addClass('disables');
				}
				if (data.status == 'error_balance') {
					that.html(prevHtml);
					alert(data.msg);
					$('.extraPrice').text('Увы,но денег не достаточно ;( ');
				}
				if (data.status == 'error_off') {
					that.html(prevHtml);
					alert(data.msg);
				}
				else {
					userPanelError.text(data.msg)
					that.html(prevHtml)
				}
			}
		})
	})
	$('#startgame').click(function() {
	    var that = $(this)
	    var prevHtml = that.html();
	    that.text('Открываем...').attr('disabled', 'disabled');
	    openingCase = true
	    $.ajax({
	        url: '/ajax/index.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            'action': 'gogame',
	            'case': currentCase
	        },
	        success: function(data) {
	            if (data.status == 'success') {
				    $(".purse span").html(data.balance+'<small>p</small>')
	                $(".shut-light").addClass("rotate")
	                $(".shutupandtakemymoney").fadeOut(500)
	                game_id = data.game_id;
	                $('.card-id').text(data.game_id);
	                scratchcards = document.getElementById('scratchcards');
	                cardsArray = [$('#case-1')[0], $('#case-2')[0], $('#case-3')[0], $('#case-4')[0], $('#case-5')[0], $('#case-6')[0], $('#case-7')[0], $('#case-8')[0], $('#case-9')[0]];
	                $.each(cardsArray, function(ids, index) {
	                    createScratchCard({
	                        'container': cardsArray[ids],
	                        'background': win,
	                        'foreground': foreground,
	                        'coin': '/images/coin.png',
	                        'percent': 55,
	                        'thickness': 12,
	                        'counter': 'counting',
	                        'callback': 'callback'
	                    });
	                });
	            }else if (data.status == 'no_iteams') {
				   $('.gold ').text('Закончились предметы');
				}else if (data.status == 'no_money') {
				   $('.gold ').text('Недостаточно денег');
				}
	        }
	    })
	})

});
//

	   
window.onload = function() {
		$("#cont").css("transition", "All 1s ease");
		$(".preloader").hide();
		$("#cont").show();
	}

</script>




				
					













<div id="content" class="subsection open_case_subsection set_shadow set_border_thin open_case_shadow_case show hide_loader">
<div class="preloader" style="display: block;">		<div>		<img src="/template/img/preloader.gif?3">		</div>	</div>

</div>
<div class="opencase nobg " id="cont" style="display:none;margin-top: -65px;">
<div class="notches-bigcorner"><div class="nt-top">&nbsp;</div><div class="nt-bot">&nbsp;</div></div>
<div class="playcard playcard-4 playcard-tutorial nomoney">
    <!-- БЛОК ПОКУПКИ БЫЛЕТА -->


           {btn}


    <div class="playcard-teacher1">
        Чтобы победить, сотрите движением мыши 3 одинаковых слота из 9
        <button id="teacher1" class="gold">Понял, готов попробовать!</button>
    </div>
    <div class="playcard-teacher2">
        Выбирайте — открыть ещё один слот (сейчас бесплатно) или просто забрать свой гарантированный выигрыш?
        <button id="teacher2" class="gold">Готов выбрать</button>
    </div>
    <div class="playcard-teacher3">
        Если не получилось отгадать — откройте ваш гарантированный выигрыш!
        <button id="teacher3" class="gold">Хорошо</button>
    </div>


    <!-- БЛОК С ПОЗДРАВЛЕНИЕМ И ПРЕДМЕТОМ -->
<div class="winner-popup" style="display: none;">
				
				<div class="wp-head1">
					
						Поздравляем!
					
				</div>
				<div class="wp-head2">
					
						Это ваш
					
					<span></span>
				</div>
				<div class="wp-item">
				<img src="">
				</div>
				<div class="wp-buttons">
					<div>
						<button class="green mini btn-sell-item">
							Продать за <span></span> РУБ.
						</button>
						<button class="gold go-next" onclick="location.reload();">
							Попробовать ещё
						</button>
										
						<a href="/user/me" class="buttonlink green mini btn-takeit">
							Забрать
						</a>
					</div>
					<span class="wp-buttons-bottom" style="padding: 15px 0 0;">
					</span>
				</div>
				<div class="wp-left dno">
					<p>Поделитесь с друзьями и <nobr>получите <b>50</b><small>p</small> на аккаунт!</nobr></p>
					<p style="padding-top: 10px;"><a href="#" class="bold">Рассказать друзьям</a></p>
				</div>

			</div>

    <!-- БЛОК СОДЕРЖИМОГО БИЛЕТА -->
    <div class="playcard-inner">

        <div class="scratchcases" id="scratchcards">

            <div class="scratchcase" id="case-1" data-id="1"></div>
            <div class="scratchcase" id="case-2" data-id="2"></div>
            <div class="scratchcase" id="case-3" data-id="3"></div>
            <div class="scratchcase" id="case-4" data-id="4"></div>
            <div class="scratchcase" id="case-5" data-id="5"></div>
            <div class="scratchcase" id="case-6" data-id="6"></div>
            <div class="scratchcase" id="case-7" data-id="7"></div>
            <div class="scratchcase" id="case-8" data-id="8"></div>
            <div class="scratchcase" id="case-9" data-id="9"></div>


        </div>
        <!-- scratchcases -->

        <div class="card-right">
            <img src="/template/img/arrow_extra_right.png" class="card-extraarrow-right">
            <div class="card-icon"><img src="{image}"></div>
            <div class="card-extra">
                <div class="card-extracase">

                    <div class="disables scratchcase" id="case-10" data-id="10"></div>

                </div>
            </div>
            <div class="card-rules">
                <b>Основные правила CSGOlots.net:</b>
                <ul>
                    <li>откройте 3 одинаковых предмета и получите его!</li>
                    <li>3 попытки + 1 дополнительная по желанию</li>
                    <li>гарантированный выигрыш для каждого!</li>
                </ul>
            </div>
           
        </div>

        <div class="card-extraerase">
            <div class="fon_svit"></div>
            <img src="/template/img/arrow_extra_left.png" class="card-extraarrow-left">
            <button class="button pic large" id="extraerase">
						+1 попытка
						<span class="extraPrice">сейчас бесплатно!</span>
					</button>
            <button class="button-line refill" style="display: none">
						Недостаточно средств — пополните баланс!
					</button>
            <div class="ce-text">
                <div class="ce-item">Есть шанс выиграть <span id="possible_item"></span></div>
                <div>Испытаете удачу или сразу заберёте гарантированный выигрыш?</div>
            </div>
        </div>
				<div class="card-id">XXXXXXXX</div>
				
				<div class="card-game csgo"></div>
    </div>
    <!-- playcard-inner -->

    <!-- Мелкие фаны -->
    <div class="card-funny card-funny-2">
        <img src="/template/img/funny_tear.png">
    </div>
    <div class="card-funny card-funny-3">
        <img src="/template/img/funny_nichosi.png">
    </div>
    <div class="card-funny card-funny-4">
        <img src="/template/img/funny_satana.png">
    </div>
    <div class="card-funny card-funny-5">
        <img src="/template/img/funny_wish.png">
    </div>
    <div class="card-funny card-funny-6">
        <img src="/template/img/funny_cat.png">
    </div>

    <!-- Большие фаны на 4 слот -->
    <div class="card-funny card-funny-1">
        <img src="/template/img/funny_gabe.png">
    </div>
    <div class="card-funny card-funny-7">
        <img src="/template/img/funny_sahar.png">
    </div>
    <div class="card-funny card-funny-8">
        <img src="/template/img/funny_santa.png">
    </div>
</div>
<div id="skills-progress">

</div>
	
	
	
	
	<div class="subsection_content cases_possible_subsection" id="cases_possible_subsection">
<h3 style="text-align: center;">Содержимое билета</h3>
   <div class="wrap">
      <ul class="open_cases_items">
<div class="opencase-drops widther"></div>
</div>
      </ul>
       </div>
</div>
	