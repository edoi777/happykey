
<script type="text/javascript"> 
$(document).ready(function(){
	
//Set default open/close settings
$('.faq-a').hide(); //Hide/close all containers
 
//On Click
$('.faq-li').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.faq-li').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	else {
		$('.faq-li').removeClass('active').next().slideUp();
	}
	return false; //Prevent the browser jump to the link anchor
});
 
});
</script>
<style>
	#wrapper {
		min-height: 65%;
	}
</style>
<div class="opencase nobg">
	<div class="opencase nobg">
	

		<div class="inner clearfix shadow_content">
	    	<div class="big_title">Техподдержка</div>
			
						
<form action="/ajax/index.php" class="support sform" method="post" enctype="multipart/form-data">
 
			
	     <div class="headerProfile__line" style="margin-top: 5px;">
         <label class="headerProfile__label" for="headerSum">EMAIL:</label>
         <input type="text" class="headerProfile__input js-paymentSum" placeholder="user@example.com" name="email" id="headerSum" value="100" style="width: 496px;">
         </div>
	     <div class="headerProfile__line" style="margin-top: 5px;">
         <label class="headerProfile__label" for="headerSum">Описание:</label>
         <textarea type="text" class="headerProfile__input js-paymentSum"  placeholder="Опишите свою проблему..." name="text" id="headerSum" value="100" style="width: 496px;height:100px;"> </textarea>
         </div>
	     <div class="headerProfile__line" style="margin-top: 5px;">
         <label class="headerProfile__label" for="headerSum">Скриншот:</label>
       <input name="scr1" type="file" class="form-control">
         </div>		 
	     <div class="headerProfile__line" style="margin-top: 5px;">
         <label class="headerProfile__label" for="headerSum">Скриншот:</label>
       <input name="scr2" type="file" class="form-control">
         </div>					
	     <div class="headerProfile__line" style="margin-top: 5px;">
         <label class="headerProfile__label" for="headerSum">Скриншот:</label>
        <input name="scr3" type="file" class="form-control">
         </div>					
			
			 <input name="action" value="support" type="hidden" class="form-control">
			
			
			
			

 
 <div class="row_submit"><button class="headerProfile__submit headerProfile__submit-inline headerProfile__submit-tradeoffer" type="submit">Отправить</button></div>
</form>



<div style="color: #fff;" class="cb_cont idesc cb_gr">
 






       	<p><b><font style="color:#2160b2">ТЕХПОДДЕРЖКА:</font></b><br>
	</p><p style="text-indent: 25px;"> В случае возникновении проблем с серверами <a href="https://steamstat.us" target="_blank"> Steam (click)</a> мы не можем гарантировать корректную работу нашего сайта, если Вам не пришел предмет, нужно отправить обращение в тех. поддержку <a href="/support" target="_blank"> Тех. Поддержка(click)</a>.<br></p>
	<font color="#f27935">1.</font> Обращение в тех. поддержку должно быть написано не позднее, чем через 2 часа после первой отправки предмета, в котором произошел сбой.<br>
	<font color="#f27935">2.</font> Обязательно должно содержать в себе скриншот выйгриша (в инвентаре,либо при победе), а так же указать настоящую ссылку на ваш обмен в профиле.<br>
	<font color="#f27935">3.</font> Мы оставляем за собой право высылать выигрыш случайными предметами эквивалентной сумме выигрыша, в случае, если по нашей вине выигрыш не был доставлен вовремя либо пополнить ваш счёт эквивалентной сумме.<br><br>
	<p style="text-indent: 25px;"> Вы имеете гарантию получения ваших вещей в течении 24 часов с момента закрытия раунда, если соблюдены все правила написания обращения в тех. поддержку. По истечению этого времени мы не несем ответственность за Ваши вещи.</p>
	<b></b><p><b><font style="color:#2160b2">ВАЖНО!</font></b><br>
	<font style="color:#2160b2">*</font>Тикеты, нарушающие правила сайта - <font style="color:#2160b2">не рассматриваются!</font><br>
	<font style="color:#2160b2">*</font>Тикеты, оскорбляющие администрацию - <font style="color:#2160b2">не рассматриваются!</font></p>
	<p>
		
		<b>Cоц. сети:</b> <a href="https://new.vk.com/club122251507" target="_blank"> ВКонтакте</a><br>
	</p>
              
        </div>


		</div>
	</div>
</div>