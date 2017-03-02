<? include('top.php'); menu('Статистика');?>
<?	$user = $db->getRow('SELECT SUM(profit) as sum,SUM(cases) as cases,SUM(spent) as spent,COUNT(*) as cnt FROM `users`');			
	$users = $db->getRows('SELECT * FROM `users` ORDER BY id DESC LIMIT 5');										
	$inv = $db->getRows('SELECT * FROM `last` ORDER BY id DESC LIMIT 5');
	$case = $db->getRows('SELECT * FROM `cases` ORDER BY id');
	$autobuy = $db->getRows('SELECT * FROM `log_autobot` ORDER BY id LIMIT 20');				
											
											
?>
                        
                      
                <!--BEGIN CONTENT-->
                <div class="page-content">
                                            <div id="sum_box" class="row mbl">
                            <div class="col-sm-6 col-md-3">
                                <div class="panel profit db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-shopping-cart"></i>
                                        </p>
                                        <h4 class="value">
                                            <span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0">
                                            </span> <? echo $user['cases']; ?> <span> </span></h4>
                                        <p class="description">
                                            Открыто кейсов</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 40%;" class="progress-bar progress-bar-success"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel income db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-money"></i>
                                        </p>
                                        <h4 class="value">
                                            <span><? echo $user['spent']; ?></span><span>руб.</span></h4>
                                        <p class="description">
                                            Потратили на кейсы</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" class="progress-bar progress-bar-info"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel task db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-signal"></i>
                                        </p>
                                        <h4 class="value">
										
                                            <span><? echo $user['sum']; ?></span></h4>
                                        <p class="description">
                                            Профит пользователей</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 50%;" class="progress-bar progress-bar-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel visit db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-group"></i>
                                        </p>
                                        <h4 class="value">
                                            <span><? echo $user['cnt']; ?></span></h4>
                                        <p class="description">
                                           Зарегистрированных пользователей</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="3100" style="width: 5%;" class="progress-bar progress-bar-warning"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-lg-8">
                                <div class="portlet box">
                                    <div class="portlet-header">
                                        <div class="caption">
                                            Последние выигрыши</div>
                                    </div>
                                                 
                                 
                           
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th><center>Пользователь</center></th>
                                      
									
                                        <th><center>Игра</center></th>
										<th><center>Когда</center></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
		<? foreach($inv as $line) {
                    
										echo '<tbody align="center">
										        <tr>			
										            <td>'.$line['username'].'</td>
									
													      <td>'.$line['game'].'</td>
												<td>'.$line['last'].'</td>
												</tr>
											  </tbody>';
									    }
									?>
                                    
                                </table>
                            
                        </div>
                                </div>
                            </div>
                                              
                                                    <div class="col-lg-4">
                                <div class="portlet box">
                                    <div class="portlet-header">
                                        <div class="caption">
                                            Последние пользователи</div>
                                    </div>
                                                 
                                 
                           
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th><center>Аккаунт</center></th>
                                        <th><center>Логин</center></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>	
									<? foreach($users as $line) {
												if (strpos($line['steam'], '7656') !== false){
			                                        $profile = '<a href="http://steamcommunity.com/profiles/'.$line['steam'].'"  target="_blank">Steam</a>';
		                                        }else {
			                                        $profile = '<a href="http://vk.com/id'.$line['steam'].'" class="prof-button prof-button_but3" target="_blank">VK</a>';
		                                        }	 
										echo '<tbody align="center">
										        <tr>			
										            <td>'.$profile.'</td>
													<td>'.$line['name'].'</td>
												</tr>
											  </tbody>';
									    }
									?>
 
                                </table>
                            
                        </div>
                                </div>
                            </div>
      
                            
                        </div>