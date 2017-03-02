<script>
$(document).ready(function() {
    $('.logout').click(function() {
        event.preventDefault();
        window.location.href = '/?logout';
    });
});


</script>	
<div id="profile" class="profile">
				<div id="my_games" class="profile_mygames">
					<div class="tip">
						Выигрышей <span id="free" class="profil-icon">{cases}</span>
						
					</div>			
					<a href="/user/me">Личный кабинет<span class="profil-icon"><img style="margin-top: 4px;" src="/template/img/zoom.png"></span></a>
					<div id="balance">
						<span>Баланс: <span id="balance_account">{money}</span></span>
						<a id="pay_button" class="profil-icon pay_button">+</a>
					</div>				
				</div>
				<div id="user" class="profile_user">
					<figure>
						<img src="{avatar}">
					</figure>
					<a class="logout profil-icon" href="/?logout" title="Выход" rel="nofollow">X</a>
				</div>
				<div class="clearfix"></div>
		    </div>

		
		
		      
      
