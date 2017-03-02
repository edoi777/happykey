<script>
$(function () {	
$('.progressbar').find('.bar b').animate({width:$('.progressbar').attr('data-verc')+'%'},2000);
});
</script>




<div class="staticpage">

				<div class="profile-common otheruser">


				
						<div class="o-info">
							<div class="left">
								<img src="{ava}">
							</div>
							<div class="right">
								<nav class="breadcrumbs">
									<h1>{name}</h1>
									
								</nav>
								<div class="ref-stat">
									<div class="w25">
									{link}
									</div>
									<div class="w25 center">
										<span>{op}</span>
										<i>Билетов</i>
									</div>
									<!--
									<div class="w25 center">
										<span>{{#if covertCount}}{{covertCount}}{{else}}0{{/if}}</span>
										<i>Тайного</i>
									</div>
									<div class="w25 center">
										<span>{{#if knifesCount}}{{knifesCount}}{{else}}0{{/if}}</span>
										<i>Ножей</i>
									</div>
									-->

								</div>
							</div>
						</div>
						





















						<div id="drops">
							
							<div class="items-incase">
								
									{inv}	

										
									
									
								
							</div>
						</div>

						

				</div> <!-- profile-common -->

			</div>








