<?php
class System_index extends connect
{
	function get_case(){
		global $pdo;
		$el = '';
		$data = $pdo->query("SELECT * FROM `cases` ORDER by rand()");


			$el = '
			<div class="content">
	<div class="wrapper">
	<!-- первый блок -->
		
		<div class="roulette_wrapper">
			<div id="win_select" class="win_select"><span class="book">Ваш</span> выигрыш</div>
			<div class="roulette_line"></div>
			
			<div id="roulette" class="roulette">
				<div id="shuffle_roll" class="shuffle_roll">';
				$obj = 0;
				foreach ($data as $row){			
				   $el.=' <div class="game obj'.$obj.'"><img src="'.$row['img'].'"></div>';
				   $obj++;
				}
				$el.='</div>				
			</div>';
		if(!isset($_SESSION['id'])){
			$el.='<a href="/?login" class="red-btn"><span id="click-clack-bang">Испытать удачу за 69 рублей</span></a>';
		}else {
			$el.='<a href="#" id="spin_it" class="red-btn"><span id="click-clack-bang">Испытать удачу за 69 рублей</span></a>';
		}
			
						

				
			$el.='	<a href="/list" class="list_link">Что можно выиграть?</a>
		</div>
	
		
	<!-- первый блок -->
	
	<!-- второй блок -->
<script>
$(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
    autoPlay : 5000,
    stopOnHover : true,
    //navigation:true,
    paginationSpeed : 1000,
    goToFirstSpeed : 2000,
    singleItem : true,
    autoHeight : true,
    //transitionStyle:"fade"
  });
 
});
</script>	
	
	
	
<div id="owl-demo" class="owl-carousel owl-theme">
 
    <div class="social_event">
		<div class="social_image">
			<img src="\template\img\social_banner.jpg">
		</div>
			<div class="social_text"></div>
			
			<a href="https://vk.com/happykeynet" class="red-btn" style="margin-top: -8px;" target="_blank"><span>принять участие</span></a>				
	</div>
	<div class="social_event">
		<div class="social_image">
			<img src="\template\img\social_banner-friends.jpg">
		</div>
			<div class="social_text"></div>
			<a href="/user/me" class="red-btn"  style="margin-top: -8px;" target="_blank"><span>Пригласить друзей</span></a>				
	</div>

	<div class="social_event">
		<div class="social_image">
			<img src="\template\img\social_banner-box4games.jpg">
		</div>
			<div class="social_text"></div>
			<a href="https://vk.com/happykeynet" class="red-btn"  style="margin-top: -8px;" target="_blank"><span>Посетить</span></a>				
	</div>
	
	
</div>	
	
		
		
	
	<!-- второй блок -->
	 </div>
</div>	 
			
			
			
			
			
			';
		
		
		
		return $el;
	}


	
	function action_index()
	{
		return array($this->get_case());
	}
} 