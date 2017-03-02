{head}
<html lang="ru">
<body>


	<header class="main-header">
		<div class="wrapper header-top">
		<a href="/">
			<figure class="main-logo">
				
				<img src="\template\img\logo.png" alt="Logo">
				<figcaption>
					<span>happykey</span>
					<span>щясливые рандом ключи</span>
				</figcaption>
				
			</figure></a>
			
			<nav class="nav">
			<a href="/">главная</a>
				<a href="/reviews">отзывы</a>
				<a href="/manual">гарантии</a>
				<a href="/faq">faq</a>
				
				<a href="/top">топ игроков</a>
				
				<!--<span href="#">еще
				<div class="submenu">
				<ul>
					<li><a href="#">поддержка</a></li>
					<li><a href="#">автор</a></li>
				</ul></div>
				</span>-->
				
			</nav>

          {profile} 		
			
			
		</div>
		<div id="last_winners" class="last_winners">
		
       {last}	
			
		</div>	  
	</header>
	
<div id="addmoney" class="popup-ovelay">
	<div class="popup animated zoomIn">
	<div class="close-popup bg"></div>
	<div id="close_pay" class="close-popup x">X</div>
		<div class="page-title">ПОПОЛНИТЬ СЧЕТ</div>
		<div class="popup_content">
			<div class="popup_descr">Оплаченные средства поступают на счет <span class="red">автоматически!</span>
			</div>
			<div class="popup_descr">Процесс занимает <span class="red">не более 3-5 минут.</span>
			</div>
			
			<div class="popup_body">
			
			<div class="pay_head">Мы принимаем:</div>
			
			<div class="popup-close"></div>
			
				<a href="" class="addmoney_item wm">
					<div class="addmoney_item--title">
						WebMoney
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item visa">
					<div class="addmoney_item--title">
						VISA / MasterCard
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item vtb" data-curr="BNK">
					<div class="addmoney_item--title">
						ВТБ24
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item megaf" data-curr="MGF">
					<div class="addmoney_item--title">
						Мегафон
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item yad" data-curr="PCR">
					<div class="addmoney_item--title">
						Яндекс.Деньги
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item sber" data-curr="BNK">
					<div class="addmoney_item--title">
						Сбербанк Онлайн
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item alpha" data-curr="BNK">
					<div class="addmoney_item--title">
						Альфа-Клик
					</div>
					5% комиссии
				</a>
				
				<a href="" class="addmoney_item mts " data-curr="MTS">
					<div class="addmoney_item--title">
						МТС
					</div>
					5% комиссии
				</a>
				
				<a href="" class="addmoney_item qiwi">
					<div class="addmoney_item--title">
						Qiwi
					</div>
					5% комиссии
				</a>
				
				<a href="" class="addmoney_item kor">
					<div class="addmoney_item--title">
						Коршунов банк 
					</div>
					5% комиссии
				</a>
				
				<a href="" class="addmoney_item sok">
					<div class="addmoney_item--title">
						Соколов банк
					</div>
					5% комиссии
				</a>
				
				<a href="#" class="addmoney_item bee" data-curr="BLN">
					<div class="addmoney_item--title">
						Билайн
					</div>
					5% комиссии
				</a>
			</div> 
			
			<form action="/payment.php" method="GET" class="pay-form">
				<span class="sum_label">СУММА:</span>
				<div class="pay-form_rublabel"><input type="text" name="sum" value="69" required=""><span class="red rub">&#8381;</span></div>
				<input style="cursor: pointer;" class="btn" type="submit" value="Пополнить счет">
				<span class="pay-form_note">Минимальная сумма пополнения 69 рублей</span>
			</form>
			
			
<a class="btn" id="kupon" style="margin-left: 300px;margin-bottom: 20px;">Активировать промокод</a>			
			
			
		</div>
	</div>
</div>

<div id="game-end" class="popup-ovelay">
   <div id="winning" class="modal animated zoomIn" style="margin-top: -374px;">
			<a id="end_close" href="#" class="close"></a>
			<span class="heading">Поздравляем! Ваш выигрыш:</span>
			<div id="winning_image">
			<div class="winning_image"></div>
			</div>
			<span class="title keys"></span>
			<span id="game_name" class="title ss">game_name</span>
			<div class="keys" id="key">key</div><img src="http://cultofthepartyparrot.com/parrots/parrot.gif" alt="" class="partyparrot" />

			<span class="add_info keys">Все выигрыши хранятся в личном кабинете</span>
           
		    <div style="display: block;" class="add_review" style="    max-height: 252px;">
			
				
				<div id="new_review"></div>
			</div>
		

    </div>
</div>

<div id="low_money" class="popup-ovelay">
   <div id="warning" class="modal animated zoomIn" style="margin-left: -212px; margin-top: -84px; display: block;">
		<a id="close_warning" href="#" class="close"></a>
	    <div class="text">Ваш баланс менее 69 рублей,<br>пополните его</div>
	    <a class="btn pay open_modal" id="pay_button_warrning">Пополнить баланс</a>			
    </div>
</div>




	 {content}
<style>
#support_chat {
    border-radius: 20px 20px 0px 0px;
    width: 300px;
    z-index: 1000;
    position: fixed;
    bottom: 0px;
    right: 13px;
    background: #C71219;
    padding: 13px 8px 7px;
    color: #eee;
    /* border-bottom: 1px solid #48525e; */
    /* border-top: 3px solid #76cfe2; */
    text-align: center;
    font-weight: 100;
    font-size: 14px;
    text-transform: none;
	text-decoration: none;
    cursor: pointer;
}
</style>
<a target="_blank" href="https://new.vk.com/im?sel=-126024463" id="support_chat"><img style="margin-left: 70px;width: 20px;float: left;" src="\template\img\convert.png"><div style="margin-left: 8px;float: left;">Связаться с нами</div></a>

<footer class="main-footer">
	<!-- инфо блок -->
	<div class="wrapper footer-box">
		<div class="info">
		
			<div class="spins count">
				<span id="games_count">{opens}</span>
				испытало<br>удачу
			</div>
			<div class="second_chance count">
				<span id="two_chance">{covert}</span>
				вторых шансов<br>выпало
			</div>
			<div class="second_chance count">
				<span id="users_count">{users}</span>
				игроков<br>зарегистрировано
			</div>
			<div class="cool count">
				<span id="online">0</span>
				игроков<br>онлайн
			</div>
			<div class="social-links">
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus" data-counter=""></div>
			</div>
			
            
			<div class="clearfix"></div>
		</div>

	
<!-- инфо блок -->


		
		
			<span class="pay-title">оплата любым способом</span>
					<div class="pay">
						<img src="\template\img\pay1.png">
						<img src="\template\img\pay2.png">
						<img src="\template\img\pay3.png">
						<img src="\template\img\pay14.png">
						<img src="\template\img\pay15.png">
						<img src="\template\img\pay16.png">
						<img src="\template\img\pay17.png">
						<img src="\template\img\pay18.png">
						<img src="\template\img\pay4.png">
						<img src="\template\img\pay5.png">
						<img src="\template\img\pay6.png">
						<img src="\template\img\pay7.png">
						<img src="\template\img\pay8.png">
						<img src="\template\img\pay9.png">
						<img src="\template\img\pay10.png">
						<img src="\template\img\pay11.png">
						<img src="\template\img\pay12.png">
						<img src="\template\img\pay13.png">
					</div>
		
			<div class="col-left">
				<div class="counters"><a href="https://new.vk.com/happykeynet" target="_blank"><img src="\template\img\banner-vk.png"></a></div>
				<div class="counters"><img src="\template\img\banner-g.png"></div>
				<div class="counters"><img src="\template\img\banner-steam.png"></div>
			</div>
			
			
	
			<div class="copyright">
			<span class="small">HappyKey.net</span>  
Все права защищены</div>
			<!-- <div class="cl"></div> -->
		</div>
</footer>
</body>
</html>
